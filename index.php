<?php 
require_once "vendor/autoload.php";

define("APP_DIR", __DIR__);

use Biblionet\ApiFetcher;

$fetcher = new ApiFetcher("testuser", "testpsw");

$fetcher->fetch(ApiFetcher::FETCH_BY_ID, 252822)->filter('place.name', "Αθήνα", "==")->fill();

$fetchedItems = $fetcher->getFetchedItems();

foreach ($fetchedItems as $item){
    echo $item->getTitle() . " => " . $item->getLanguage()->getName().PHP_EOL;
    //print_r($item);
}

?>