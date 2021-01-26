<?php

namespace Biblionet;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

use Biblionet\Helper;
use GuzzleHttp\Client;

use Biblionet\Models\Book;

class ApiFetcher
{

    const FETCH_BY_MONTH = 1;
    const FETCH_BY_ID = 2;

    const FILL_CONTRIBUTORS = 'get_contributors';
    const FILL_COMPANIES = 'get_title_companies';
    const FILL_SUBJECTS = 'get_title_subject';
    const FILL_OPTIONS = [self::FILL_CONTRIBUTORS, self::FILL_COMPANIES, self::FILL_SUBJECTS];

    /**
     * biblionet api username
     */
    private string $apiUsername;

    /**
     * biblionet api password
     */
    private string $apiPassword;

    /**
     * the num of results that requested per call
     */
    private int $resultsPerPage;

    /**
     * an instance of the Biblionet\Logger class
     */
    private Logger $logger;

    /**
     * keep the array of fetched items as Biblionet\Models\Book objects
     */
    private array $fetchedItems = [];

    /**
     * ApiFetcher constructor
     * 
     * @param string $username
     * @param string $password
     * @param array $log
     * @param integer $requestTimeout
     * @param integer $resultsPerPage
     */
    function __construct($username, $password, $log = [Logger::SUCCESS, Logger::ERROR, Logger::INFO, Logger::WARNING], $requestTimeout = 10, $resultsPerPage = 50)
    {

        $this->apiUsername = $username;
        $this->apiPassword = $password;
        $this->resultsPerPage = $resultsPerPage;

        $this->client = new Client([
            'base_uri' => 'https://biblionet.gr/wp-json/biblionetwebservice/',
            'timeout'  => $requestTimeout
        ]);

        $this->logger = new Logger($log);
    }

    /**
     * Returns the fetched items
     *
     * @return array an array of Book objects
     */
    public function getFetchedItems()
    {
        return $this->fetchedItems;
    }


    /**
     * Fetch books from biblionet api.
     * 
     * You may pass a single month as argument or two month to fetch the books published in that range.
     * 
     * @param string $fetchType
     * @param date|null $fromMonth
     * @param date|null $toMonth
     * @param array|null $ids
     * 
     * @return object $this
     * 
     */
    public function fetch($fetchType = ApiFetcher::FETCH_BY_MONTH, $fromMonth = NULL, $toMonth = NULL, $ids = [])
    {
        switch ($fetchType) {
            case ApiFetcher::FETCH_BY_MONTH:
                $monthsToFetch = [];

                $fromMonth = $fromMonth ?: date("Y-m");
                $fromMonth = new \DateTime($fromMonth);
                $fromMonth->modify('first day of this month');

                if ($toMonth) {
                    $toMonth = new \DateTime($toMonth);
                    $toMonth->modify('first day of next month');

                    $interval = \DateInterval::createFromDateString('1 month');
                    $period = new \DatePeriod($fromMonth, $interval, $toMonth);

                    foreach ($period as $dt) {
                        array_push($monthsToFetch, $dt);
                    }
                } else {
                    array_push($monthsToFetch, $fromMonth);
                }

                foreach ($monthsToFetch as $month) {
                    $page = 0;

                    while (true) {
                        $page++;

                        $fetchedBooks = $this->_makeRequest('get_month_titles', [
                            'year' => $month->format("Y"),
                            'month' => $month->format("m"),
                            'titles_per_page' => $this->resultsPerPage,
                            'page' => $page
                        ]);

                        if ($fetchedBooks && is_array($fetchedBooks)) {
                            $fetchedBooks = $this->_mapResponseToObjects($fetchedBooks);
                            $this->fetchedItems = array_merge($this->fetchedItems, $fetchedBooks);
                            continue;
                        } else {
                            break;
                        }
                    }
                }
                break;
            case ApiFetcher::FETCH_BY_ID:
                if (count($ids) > 0) foreach ($ids as $id) {
                    $fetchedBooks = $this->_makeRequest('get_title', ['title' => $id]);
                    if ($fetchedBooks && is_array($fetchedBooks)) {
                        $fetchedBooks = $this->_mapResponseToObjects($fetchedBooks);
                        $this->fetchedItems = array_merge($this->fetchedItems, $fetchedBooks);
                    }
                }
                break;

            default:
                $this->logger->log(Logger::ERROR, 'fetch', 'provide a valid fetch option');
        }

        return $this;
    }


    /**
     * filter the fetched items.
     *
     * @param string $field provide a book property
     * @param string $value the value to search for in the property
     * @param string $operator the operation to use for the comparison
     * @return void
     */
    public function filter($field, $value, $operator = "==")
    {
        $totalCount = count($this->fetchedItems);
        $filteredCount = $totalCount;
        $properties = explode('.', $field);
        if ($totalCount > 0) {
            if (property_exists($this->fetchedItems[0], $properties[0])) {
                $this->fetchedItems = array_filter($this->fetchedItems, function ($item) use ($properties, $value, $operator) {
                    $command = '';
                    foreach ($properties as $prop){
                        $command.='->get'.ucfirst($prop).'()';
                    }
                    $getter = 'return $item'.$command.';';
                    return Helper::compare(eval($getter), $value, $operator);
                });
                $filteredCount = count($this->fetchedItems);
                $this->logger->log(Logger::INFO, 'filter', 'filter by ' . $field . $operator . $value, 'filtered:' . $filteredCount . '/' . $totalCount);
           }
        }


        return $this;
    }


    /**
     * Fill the already fetched items with more info by making new api calls
     *
     * @param array $types
     * @return void
     */
    public function fill($types = self::FILL_OPTIONS)
    {

        if (count($this->fetchedItems) == 0) {
            $this->logger->log(Logger::WARNING, 'api', 'fill', 'no items fetched');
            return $this;
        }

        foreach ($types as $type) {
            if (!in_array($type, self::FILL_OPTIONS)) {
                $this->logger->log(Logger::ERROR, 'api', 'fill', 'wrong input => ' . $type);
                continue;
            }

            $total = count($this->fetchedItems);
            $counter = 0;
            foreach ($this->fetchedItems as $key => $item) {
                $counter++;
                $this->logger->log(Logger::INFO, 'api', "fetch " . $type . " " . $counter . "/" . $total, $item->getId(), Helper::getPercentage($counter, $total));
                $extraFields = $this->_makeRequest($type, ['title' => $item->getId()]);

                if ($extraFields && is_array($extraFields)) {
                    switch ($type){
                        case self::FILL_SUBJECTS:
                            $this->fetchedItems[$key]->setSubjects($extraFields);
                            break;
                        case self::FILL_CONTRIBUTORS:
                            $this->fetchedItems[$key]->setContributors($extraFields);
                            break;
                        case self::FILL_COMPANIES:
                            $this->fetchedItems[$key]->setCompanies($extraFields);
                            break;
                    }
                        
                }
            }

        }

        return $this;
    }

    /**
     * Make the api request
     *
     * @param string $method the api method
     * @param array $params an array with params for the api call except authentication params
     * @return void
     */
    private function _makeRequest($method, $params)
    {
        $this->logger->log(Logger::INFO, 'api', "request", json_encode($params));

        $requestParams = [
            'username' => $this->apiUsername,
            'password' => $this->apiPassword
        ] + $params;

        try {
            $response = $this->client->request('POST', $method, [
                'form_params' => $requestParams
            ]);

            $body = $response->getBody();

            $result = $body->getContents();

            if (Helper::isJson($result))
                return json_decode($result)[0];
            else
                return NULL;
        } catch (ClientException $e) {
            $this->logger->log(Logger::ERROR, 'api', 'ClientException', $e->getMessage());
        } catch (ConnectException $e) {
            $this->logger->log(Logger::ERROR, 'api', 'ConnectException', $e->getMessage());
        }
    }


    /**
     * Map api response to the predefined models
     *
     * @param array $responseData the data returned for the api request
     * @return array a list of Book objects
     */
    private function _mapResponseToObjects($responseData)
    {
        $books = [];
        if (is_array($responseData)) foreach ($responseData as $bookData) {
            array_push($books, new Book($bookData));
        }

        return $books;
    }
}
