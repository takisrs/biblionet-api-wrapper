<?php
require_once dirname(__DIR__)."/vendor/autoload.php";

use takisrs\Biblionet\ApiFetcher;

$fetcher = new ApiFetcher("testuser", "testpsw");

// Fetches all books from 10/2020 to 02/2021
$fetcher->fetch(ApiFetcher::FETCH_BY_MONTH, "2020-10", "2021-02");

$fetchedItems = $fetcher->getItems();

foreach ($fetchedItems as $item) {
    echo "**** " . $item->getTitle() . " ****" . PHP_EOL;
    echo "Writer: " . $item->getWriter()->getName() . PHP_EOL;
    echo "Publisher: " . $item->getPublisher()->getName() . PHP_EOL;
    echo PHP_EOL;
}
