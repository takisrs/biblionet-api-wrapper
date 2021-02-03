<?php
require_once dirname(__DIR__)."/vendor/autoload.php";

use takisrs\Biblionet\ApiFetcher;

// Initialize the fetcher class
$fetcher = new ApiFetcher("testuser", "testpsw");

// Fetch a book
$fetchedItems = $fetcher->fetch(ApiFetcher::FETCH_BY_ID, 252822)->getItems();

// Get the Book object
$fetchedBook = reset($fetchedItems);

// Output some info with the help of getters
if ($fetchedBook){
    echo $fetchedBook->getTitle() . " => " . $fetchedBook->getLanguage()->getName().PHP_EOL;
}