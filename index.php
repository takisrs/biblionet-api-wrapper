<?php 
require_once "vendor/autoload.php";

define("APP_DIR", __DIR__);

use Biblionet\ApiFetcher;

$fetcher = new ApiFetcher("testuser", "testpsw");

$fetcher->fetch(ApiFetcher::FETCH_BY_MONTH)->filter('id', 252655, ">")->fill();

$fetchedItems = $fetcher->getFetchedItems();

foreach ($fetchedItems as $item){
    echo $item->getTitle() . " => " . $item->getLanguage()->getName().PHP_EOL;
    //print_r($item);
}

?>