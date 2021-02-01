<?php 
require_once "vendor/autoload.php";

use Biblionet\ApiFetcher;

$fetcher = new ApiFetcher("testuser", "testpsw");

//$fetcher->fetch(ApiFetcher::FETCH_BY_ID, 252822)->filter('place.name', "Αθήνα", "==")->fill();
$fetcher = $fetcher->fetch(ApiFetcher::FETCH_BY_MONTH, "2021-01");

$fetcher->filter('type', 'Βιβλίο', '==')->fill([ApiFetcher::FILL_CONTRIBUTORS]);

$fetchedItems = $fetcher->getFetchedItems();

foreach ($fetchedItems as $item){
    echo "Title: ".$item->getTitle().":".PHP_EOL;
    echo "Publication Date: " . $item->getFirstPublishDate()->format("d/m/y").PHP_EOL;
    echo "Weight: " . $item->getWeight().PHP_EOL;
    echo "Price: " . $item->getPrice().PHP_EOL;

    $contributors = $item->getContributors();

    foreach ($contributors as $contributor){
        echo $contributor->getId().". ".$contributor->getName().' ('.$contributor->getTypeName().')'.PHP_EOL;
    }
    echo PHP_EOL;
}

?>