<?php 
require_once "vendor/autoload.php";

define("APP_DIR", __DIR__);

use Biblionet\ApiFetcher;

$fetcher = new ApiFetcher("testuser", "testpsw");
//$fetcher->fetchById(['251710', '252220']);
$fetcher->fetch("2021-01");


$fetchedItems = $fetcher->getFetchedItems();


foreach ($fetchedItems as $item){
    echo $item->getTitle() . " => " . $item->getLanguage()->getName().PHP_EOL;
    //print_r($item);
}

?>