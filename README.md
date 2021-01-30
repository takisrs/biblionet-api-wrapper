# A Wrapper class for biblionet's API

A wrapper class for biblionet's API, written in PHP, to help you fetch book's data easily.

Read more about [biblionet](https://biblionet.gr/) and their [api](https://biblionet.gr/webservice/)

## Installation

To be updated

## How to use with examples

### Fetch a book by id, and display some basic info
```php
require_once "vendor/autoload.php";

use Biblionet\ApiFetcher;

// Initialize the fetcher class by providing the username and password for biblionet api
$fetcher = new ApiFetcher("testuser", "testpsw");

// Fetch a book
$fetcher->fetch(ApiFetcher::FETCH_BY_ID, 252822);

// Get the Book object
$fetchedItems = $fetcher->getFetchedItems();

// Output some info with the help of getters
foreach ($fetchedItems as $item){
    echo $item->getTitle() . " => " . $item->getLanguage()->getName().PHP_EOL;
}
```


### Fetch current month books
```php
require_once "vendor/autoload.php";

use Biblionet\ApiFetcher;

// Initialize the fetcher class by providing the username and password for biblionet api
$fetcher = new ApiFetcher("testuser", "testpsw");

// Fetch current month books, filter them and keep only the hardcopy books and finally fetch extra info about books' contributors
$fetcher->fetch(ApiFetcher::FETCH_BY_MONTH, date("Y-m"))->filter('type', 'Βιβλίο', '==')->fill([ApiFetcher::FILL_CONTRIBUTORS]);

$fetchedItems = $fetcher->getFetchedItems();

foreach ($fetchedItems as $item){
    echo $item->getTitle().":".PHP_EOL;
    $contributors = $item->getContributors();

    foreach ($contributors as $contributor){
        echo $contributor->getId().". ".$contributor->getName().' ('.$contributor->getTypeName().')'.PHP_EOL;
    }
    echo PHP_EOL;
}
```