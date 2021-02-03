<?php
require_once dirname(__DIR__)."/vendor/autoload.php";

use takisrs\Biblionet\ApiFetcher;

$fetcher = new ApiFetcher("testuser", "testpsw");

// Fetch current month's books
$fetcher->fetch(ApiFetcher::FETCH_BY_MONTH, date("Y-m"));

// Keep only the hardcopy books
$fetcher->filter('type', 'Βιβλίο', '==');

// Fill the rest with extra data (contributors)
$fetcher->fill([ApiFetcher::FILL_CONTRIBUTORS]);

// Get an array of books
$fetchedItems = $fetcher->getItems();

// Display some info
foreach ($fetchedItems as $item) {
    echo "**** " . $item->getTitle() . " ****" . PHP_EOL;
    echo "Publication Date: " . $item->getFirstPublishDate()->format("d/m/y") . PHP_EOL;
    echo "Weight: " . $item->getWeight() . ' g' . PHP_EOL;
    echo "Price: " . $item->getPrice() . ' €' . PHP_EOL;

    $contributors = $item->getContributors();

    foreach ($contributors as $contributor) {
        echo $contributor->getTypeName() . ": " . $contributor->getName() . PHP_EOL;
    }
    echo PHP_EOL;
}
