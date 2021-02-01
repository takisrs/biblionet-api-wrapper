<?php

namespace Biblionet;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;

use Biblionet\Helper;
use GuzzleHttp\Client;

use Biblionet\Models\Book;

/**
 * A wrapper php class for biblionet api.
 * 
 * This library will help you fetch books' data from biblionet database.
 * It provides some helpful methods that simplify the communication with their api.
 * 
 * @link https://biblionet.gr/webservice/ Biblionet API documentation
 * 
 * @author Panagiots Pantazopoulos <takispadaz@gmail.com>
 * 
 */
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
     * an instance of the logger class
     * @see Biblionet\Logger the logger class
     */
    private Logger $logger;

    /**
     * keep the array of fetched items as Biblionet\Models\Book objects
     * @see Biblionet\Models\Book the model of Book
     */
    private array $fetchedItems = [];


    /**
     * ApiFetcher constructor
     * 
     * @param string $username Biblionet's api username that required for authentication
     * @param string $password Biblionet's api password that required for authentication
     * @param array $log Configure the Logger class
     * @param integer $requestTimeout The timeout in seconds for an api request
     * @param integer $resultsPerPage Number of items to fetch per request. Max value is 50
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
     * Returns the fetched items.
     * 
     * Use this method to get all the data that have been fetch from biblionet's api.
     *
     * @return Book[] an array of Book objects
     * @see \Biblionet\Models\Book Book model class
     */
    public function getFetchedItems(): array
    {
        return $this->fetchedItems;
    }


    /**
     * Fetch books from biblionet's api.
     * 
     * You may call with method to fetch data for a specific book, or provide a month to fetch books published in that month. 
     * You may also provide two months to fetch books published in that range.
     * 
     * @param string $fetchType Provide the fetch type.
     * @param string|int|array $param1 Depending on the fetch type, you may input a month or an array with specific book id
     * @param date $param2 Used only when fetchType = ApiFetcher::FETCH_BY_MONTH.
     * 
     * @return ApiFetcher
     * 
     */
    public function fetch($fetchType = ApiFetcher::FETCH_BY_MONTH, $param1 = NULL, $param2 = NULL): ApiFetcher
    {
        switch ($fetchType) {
            case ApiFetcher::FETCH_BY_MONTH:
                $monthsToFetch = [];

                $fromMonth = $param1 ?: date("Y-m");
                $fromMonth = new \DateTime($fromMonth);
                $fromMonth->modify('first day of this month');

                if ($param2) {
                    $toMonth = new \DateTime($param2);
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
                if (is_array($param1)){
                    if (count($param1) > 0) foreach ($param1 as $id) {
                        $fetchedBooks = $this->_makeRequest('get_title', ['title' => $id]);
                        if ($fetchedBooks && is_array($fetchedBooks)) {
                            $fetchedBooks = $this->_mapResponseToObjects($fetchedBooks);
                            $this->fetchedItems = array_merge($this->fetchedItems, $fetchedBooks);
                        }
                    }
                } else {
                    $fetchedBooks = $this->_makeRequest('get_title', ['title' => $param1]);
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
     * Fill with extra data the already fetched items.
     * 
     * You may use this method to fetch extra data from biblionet's api for the books that you have fetch with the fetch() method.
     * This method, depending the params, makes extra api requests to the api to fetch the requested data, so it may be slow.
     *
     * @param array $types
     * @return ApiFetcher
     */
    public function fill($types = self::FILL_OPTIONS): ApiFetcher
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
     * Filter the already fetched items.
     * 
     * Use this method to narrow down book that have already been fetched.
     * You may, for example, use this method to keep only the hardcopy books from the fetched items.
     *
     * @param string $field provide a book property
     * @param string|int $value the value to search for in the property
     * @param string $operator the operation to use for the comparison
     * @return ApiFetcher
     */
    public function filter(string $field, string $value, string $operator = "=="): ApiFetcher
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
     * Makes the api request.
     * 
     * Just a helper method to make the requested api request with the help of Guzzle
     *
     * @param string $method the api method
     * @param array $params an array with params for the api call except authentication params
     * @return mixed
     */
    private function _makeRequest($method, $params): mixed
    {
        $this->logger->log(Logger::INFO, 'api', 'request', json_encode($params));

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
        } catch (ServerException $e) {
            $this->logger->log(Logger::ERROR, 'api', 'ServerException', $e->getMessage());
        }
    }


    /**
     * Maps api response to the predefined models.
     *
     * @param array $responseData the data returned by the api request
     * @return array a list of Book std objects
     */
    private function _mapResponseToObjects($responseData): array
    {
        $books = [];
        if (is_array($responseData)) foreach ($responseData as $bookData) {
            array_push($books, new Book($bookData));
        }

        return $books;
    }
}
