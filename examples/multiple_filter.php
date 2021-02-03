<?php
require_once dirname(__DIR__)."/vendor/autoload.php";

use takisrs\Biblionet\ApiFetcher;

$fetcher = new ApiFetcher("testuser", "testpsw");

$filterDate = new \Datetime("2021-01-15");

// Fetches the books of January 2021 and keep only the hard copy books and those published after 15/01/2021
$fetcher->fetch(ApiFetcher::FETCH_BY_MONTH, "2021-01")->filter('currentPublishDate', $filterDate, ">")->filter('type', 'Βιβλίο', '==');

$fetchedItems = $fetcher->getItems();

foreach ($fetchedItems as $item) {
    echo "**** " . $item->getTitle() . " ****" . PHP_EOL;
    echo "Current Publication Date: " . $item->getCurrentPublishDate()->format("d/m/y") . PHP_EOL;
    echo "Type: " . $item->getType() . PHP_EOL;
    echo "Writer: " . $item->getWriter()->getName() . PHP_EOL;
    echo "Publisher: " . $item->getPublisher()->getName() . PHP_EOL;
    echo PHP_EOL;
}
