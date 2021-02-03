# A wrapper library for biblionet's API

A wrapper library for biblionet's API, written in PHP, to help you fetch books' data easily.

Read more about [biblionet](https://biblionet.gr/) and their [api](https://biblionet.gr/webservice/)


## Installation

`composer require takisrs/biblionet-api-wrapper`


## How to use

### Fetch a book by id and display some info
```php
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
```

### Fetch current month's hardcopy books with their contributors and display some info
```php
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
```

### Examples on how to use the fetch method

```php
$fetcher->fetch(ApiFetcher::FETCH_BY_ID, 252986); // specific book
$fetcher->fetch(ApiFetcher::FETCH_BY_ID, [253064, 252986, 252976]); // specific books
$fetcher->fetch(ApiFetcher::FETCH_BY_MONTH); // current month's books
$fetcher->fetch(ApiFetcher::FETCH_BY_MONTH, "2020-10"); // specific month's books
$fetcher->fetch(ApiFetcher::FETCH_BY_MONTH, "2020-10", "2021-01"); // specific period's books
```   
You may also combine all the above. ex:   
```php
// January's book of the last 3 years
$fetcher->fetch(ApiFetcher::FETCH_BY_MONTH, "2019-01")->fetch(ApiFetcher::FETCH_BY_MONTH, "2020-01")->fetch(ApiFetcher::FETCH_BY_MONTH, "2021-01");
```   

### Examples on how to use the filter method

```php
$fetcher->filter('type', 'e-book', '=='); // Keep only the ebooks
$fetcher->filter('place.name', 'Αθήνα', '=='); // Keep only those published in Athens
$fetcher->filter('cover', 'Μαλακό εξώφυλλο', '=='); // Keep only those with a soft cover
$fetcher->filter('availability', 'Κυκλοφορεί', '=='); // Keep only the available ones
$fetcher->filter('id', 253064, '>='); // Keep the books with an id >= 253064
```   
You may also combine all the above.    

### More Examples

You may check for more examples in the [examples](examples/) folder on this repository.



## Documentation
You may read the full documentation [here](https://takisrs.github.io/biblionet-api-wrapper/) or check the docs bellow.   


- [\takisrs\Biblionet\ApiFetcher](#class-takisrsbiblionetapifetcher)
- [\takisrs\Biblionet\Helper](#class-takisrsbiblionethelper)
- [\takisrs\Biblionet\Logger](#class-takisrsbiblionetlogger)
- [\takisrs\Biblionet\Models\Category](#class-takisrsbiblionetmodelscategory)
- [\takisrs\Biblionet\Models\Book](#class-takisrsbiblionetmodelsbook)
- [\takisrs\Biblionet\Models\Company](#class-takisrsbiblionetmodelscompany)
- [\takisrs\Biblionet\Models\Contributor](#class-takisrsbiblionetmodelscontributor)
- [\takisrs\Biblionet\Models\Subject](#class-takisrsbiblionetmodelssubject)
- [\takisrs\Biblionet\Models\Place](#class-takisrsbiblionetmodelsplace)
- [\takisrs\Biblionet\Models\Language](#class-takisrsbiblionetmodelslanguage)

<hr />

### Class: \takisrs\Biblionet\ApiFetcher

> A wrapper class for biblionet's api. This library will help you fetch books' data from biblionet database. It provides some helpful methods that simplify the communication with their api.

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>string</em> <strong>$username</strong>, <em>string</em> <strong>$password</strong>, <em>array</em> <strong>$log=array()</strong>, <em>integer</em> <strong>$requestTimeout=10</strong>, <em>integer</em> <strong>$resultsPerPage=50</strong>)</strong> : <em>void</em><br /><em>ApiFetcher constructor</em> |
| public | <strong>fetch(</strong><em>string</em> <strong>$fetchType=1</strong>, <em>string/int/array</em> <strong>$param1=null</strong>, <em>string</em> <strong>$param2=null</strong>)</strong> : <em>[\takisrs\Biblionet\ApiFetcher](#class-takisrsbiblionetapifetcher)</em><br /><em>Fetch books from biblionet's api. You may call with method to fetch data for a specific book, or provide a month to fetch books published in that month. You may also provide two months to fetch books published in that period.</em> |
| public | <strong>fill(</strong><em>array</em> <strong>$types=array()</strong>)</strong> : <em>[\takisrs\Biblionet\ApiFetcher](#class-takisrsbiblionetapifetcher)</em><br /><em>Fill with extra data the already fetched items. You may use this method to fetch extra data from biblionet's api for the books that you have fetch with the fetch() method. This method, depending the params, makes extra api requests to the api to fetch the requested data, so it may be slow. Use this method if you want to fetch book's subjects, contributors or companies.</em> |
| public | <strong>filter(</strong><em>\string</em> <strong>$field</strong>, <em>mixed</em> <strong>$value</strong>, <em>\string</em> <strong>$operator=`'=='`</strong>)</strong> : <em>[\takisrs\Biblionet\ApiFetcher](#class-takisrsbiblionetapifetcher)</em><br /><em>Filter the already fetched items. Use this method to narrow down the number of books that have already been fetched depending on specific filters. You may, for example, use this method to keep only the hardcopy books from the fetched items.</em> |
| public | <strong>getItems()</strong> : <em>Book[] an array of Book objects</em><br /><em>Returns the fetched items. Use this method to get all the data that have been fetch from biblionet's api.</em> |

<hr />

### Class: \takisrs\Biblionet\Helper

> A helper class that provides some static functions.

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>compare(</strong><em>mixed</em> <strong>$var1</strong>, <em>mixed</em> <strong>$var2</strong>, <em>\string</em> <strong>$operator</strong>)</strong> : <em>bool The result of the comparison</em><br /><em>Makes a comparison between two variables</em> |
| public static | <strong>getPercentage(</strong><em>integer/\int</em> <strong>$current</strong>, <em>integer/\int</em> <strong>$total</strong>)</strong> : <em>float the percentage</em><br /><em>Calculates and return a percentage of completion</em> |
| public static | <strong>isCli()</strong> : <em>bool</em><br /><em>Checks if the script has been called through cli</em> |
| public static | <strong>isJson(</strong><em>\string</em> <strong>$str</strong>)</strong> : <em>bool</em><br /><em>Checks if a string is json</em> |

<hr />

### Class: \takisrs\Biblionet\Logger

> A helper class to output logs.

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>array</em> <strong>$show=array()</strong>)</strong> : <em>void</em><br /><em>Constructor.</em> |
| public | <strong>disable()</strong> : <em>void</em><br /><em>Disables the logging</em> |
| public | <strong>enable()</strong> : <em>void</em><br /><em>Enables the logging</em> |
| public | <strong>log(</strong><em>\string</em> <strong>$type</strong>, <em>\string</em> <strong>$entity</strong>, <em>\string</em> <strong>$title</strong>, <em>\string</em> <strong>$text=`''`</strong>, <em>\float</em> <strong>$percentage=null</strong>)</strong> : <em>void</em><br /><em>Logs an entry.</em> |

<hr />

### Class: \takisrs\Biblionet\Models\Category

> The model class of Category

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>int</em> <strong>$id</strong>, <em>string</em> <strong>$name</strong>)</strong> : <em>void</em><br /><em>category constructor</em> |
| public | <strong>getId()</strong> : <em>int</em><br /><em>get the id of the category</em> |
| public | <strong>getName()</strong> : <em>string</em><br /><em>get the name of the category</em> |

<hr />

### Class: \takisrs\Biblionet\Models\Book

> The model class of Book

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>mixed</em> <strong>$data</strong>)</strong> : <em>void</em> |
| public | <strong>getAgeFrom()</strong> : <em>int</em><br /><em>Get the value of ageFrom</em> |
| public | <strong>getAgeTo()</strong> : <em>int</em><br /><em>Get the value of ageTo</em> |
| public | <strong>getAlternativeTitle()</strong> : <em>string</em><br /><em>Get the value of alternativeTitle</em> |
| public | <strong>getAvailability()</strong> : <em>string</em><br /><em>Get the value of availability</em> |
| public | <strong>getCategory()</strong> : <em>[\takisrs\Biblionet\Models\Category](#class-takisrsbiblionetmodelscategory)</em><br /><em>Get the value of category</em> |
| public | <strong>getComments()</strong> : <em>string</em><br /><em>Get the value of comments</em> |
| public | <strong>getCompanies()</strong> : <em>[\takisrs\Biblionet\Models\Company](#class-takisrsbiblionetmodelscompany)[]</em><br /><em>Get the array of Company objs</em> |
| public | <strong>getContributors()</strong> : <em>[\takisrs\Biblionet\Models\Contributor](#class-takisrsbiblionetmodelscontributor)[]</em><br /><em>Get the array of Contributor objs</em> |
| public | <strong>getCover()</strong> : <em>string</em><br /><em>Get the value of cover</em> |
| public | <strong>getCurrentPublishDate()</strong> : <em>mixed</em><br /><em>Get the value of currentPublishDate</em> |
| public | <strong>getDimensions()</strong> : <em>string</em><br /><em>Get the value of dimensions</em> |
| public | <strong>getEditionNo()</strong> : <em>string</em><br /><em>Get the value of editionNo</em> |
| public | <strong>getFirstPublishDate()</strong> : <em>mixed</em><br /><em>Get the value of firstPublishDate</em> |
| public | <strong>getFuturePublishDate()</strong> : <em>mixed</em><br /><em>Get the value of futurePublishDate</em> |
| public | <strong>getId()</strong> : <em>int</em><br /><em>Get the value of id</em> |
| public | <strong>getImage()</strong> : <em>string</em><br /><em>Get the value of image</em> |
| public | <strong>getIsbn()</strong> : <em>string</em><br /><em>Get the value of isbn</em> |
| public | <strong>getIsbn2()</strong> : <em>string</em><br /><em>Get the value of isbn2</em> |
| public | <strong>getIsbn3()</strong> : <em>string</em><br /><em>Get the value of isbn3</em> |
| public | <strong>getLanguage()</strong> : <em>[\takisrs\Biblionet\Models\Language](#class-takisrsbiblionetmodelslanguage)</em><br /><em>Get the value of language</em> |
| public | <strong>getLastUpdated()</strong> : <em>[\Datetime](http://php.net/manual/en/class.datetime.php)</em><br /><em>Get the value of lastUpdated</em> |
| public | <strong>getMultiVolumeTitle()</strong> : <em>string</em><br /><em>Get the value of multiVolumeTitle</em> |
| public | <strong>getOriginalLanguage()</strong> : <em>[\takisrs\Biblionet\Models\Language](#class-takisrsbiblionetmodelslanguage)</em><br /><em>Get the value of originalLanguage</em> |
| public | <strong>getOriginalTitle()</strong> : <em>string</em><br /><em>Get the value of originalTitle</em> |
| public | <strong>getPageNo()</strong> : <em>int</em><br /><em>Get the value of pageNo</em> |
| public | <strong>getPlace()</strong> : <em>[\takisrs\Biblionet\Models\Place](#class-takisrsbiblionetmodelsplace)</em><br /><em>Get the value of place</em> |
| public | <strong>getPrice()</strong> : <em>float</em><br /><em>Get the value of price (euros)</em> |
| public | <strong>getPublisher()</strong> : <em>[\takisrs\Biblionet\Models\Company](#class-takisrsbiblionetmodelscompany)</em><br /><em>Get the value of publisher</em> |
| public | <strong>getSeries()</strong> : <em>string</em><br /><em>Get the value of series</em> |
| public | <strong>getSeriesNo()</strong> : <em>string</em><br /><em>Get mapped to SeriesNo</em> |
| public | <strong>getSpecifications()</strong> : <em>string</em><br /><em>Get the value of specifications</em> |
| public | <strong>getSubSeries()</strong> : <em>string</em><br /><em>Get mapped to SubSeries</em> |
| public | <strong>getSubSeriesNo()</strong> : <em>string</em><br /><em>Get mapped to SubSeriesNo</em> |
| public | <strong>getSubjects()</strong> : <em>[\takisrs\Biblionet\Models\Subject](#class-takisrsbiblionetmodelssubject)[]</em><br /><em>Get the array of Subject objs</em> |
| public | <strong>getSubtitle()</strong> : <em>string</em><br /><em>Get the value of subtitle</em> |
| public | <strong>getSummary()</strong> : <em>string</em><br /><em>Get the value of summary</em> |
| public | <strong>getTitle()</strong> : <em>string</em><br /><em>Get the value of title</em> |
| public | <strong>getTranslatedLanguage()</strong> : <em>[\takisrs\Biblionet\Models\Language](#class-takisrsbiblionetmodelslanguage)</em><br /><em>Get the value of translatedLanguage</em> |
| public | <strong>getType()</strong> : <em>string</em><br /><em>Get the value of type</em> |
| public | <strong>getVat()</strong> : <em>float</em><br /><em>Get the value of vat (percentage)</em> |
| public | <strong>getVolumeCount()</strong> : <em>string</em><br /><em>Get the value of volumeCount</em> |
| public | <strong>getVolumeNo()</strong> : <em>string</em><br /><em>Get the value of volumeNo</em> |
| public | <strong>getWebAddress()</strong> : <em>string</em><br /><em>Get the value of webAddress</em> |
| public | <strong>getWeight()</strong> : <em>int</em><br /><em>Get the value of weight (grams)</em> |
| public | <strong>getWriter()</strong> : <em>[\takisrs\Biblionet\Models\Contributor](#class-takisrsbiblionetmodelscontributor)</em><br /><em>Get the value of writer</em> |
| public | <strong>setCompanies(</strong><em>array</em> <strong>$data</strong>)</strong> : <em>void</em><br /><em>Init Book's companies</em> |
| public | <strong>setContributors(</strong><em>array</em> <strong>$data</strong>)</strong> : <em>void</em><br /><em>Init Book's contributors</em> |
| public | <strong>setSubjects(</strong><em>array</em> <strong>$data</strong>)</strong> : <em>void</em><br /><em>Init Book's subjects</em> |

<hr />

### Class: \takisrs\Biblionet\Models\Company

> The model class of Company (ex. publisher)

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>int</em> <strong>$id</strong>, <em>string</em> <strong>$name</strong>, <em>int</em> <strong>$typeId=1</strong>, <em>string</em> <strong>$typeName=`'Εκδότης'`</strong>, <em>int</em> <strong>$order</strong>)</strong> : <em>void</em><br /><em>Company constructor</em> |
| public | <strong>getId()</strong> : <em>int</em><br /><em>Get the id of the category</em> |
| public | <strong>getName()</strong> : <em>string</em><br /><em>Get the name of the category</em> |
| public | <strong>getOrder()</strong> : <em>int</em><br /><em>Get the order of the category</em> |
| public | <strong>getTypeId()</strong> : <em>int</em><br /><em>Get the type id of the category</em> |
| public | <strong>getTypeName()</strong> : <em>string</em><br /><em>Get the type name of the category</em> |

<hr />

### Class: \takisrs\Biblionet\Models\Contributor

> The model class of Contributor (ex. writer)

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>int</em> <strong>$id</strong>, <em>string</em> <strong>$name</strong>, <em>int</em> <strong>$typeId=1</strong>, <em>string</em> <strong>$typeName=`'Συγγραφέας'`</strong>, <em>int</em> <strong>$order</strong>)</strong> : <em>void</em><br /><em>Contributor constructor</em> |
| public | <strong>getId()</strong> : <em>int</em><br /><em>Get the id of the contributor</em> |
| public | <strong>getName()</strong> : <em>string</em><br /><em>Get the name of the contributor</em> |
| public | <strong>getOrder()</strong> : <em>int</em><br /><em>Get the order of the contributor</em> |
| public | <strong>getTypeId()</strong> : <em>int</em><br /><em>Get the type id of the contributor</em> |
| public | <strong>getTypeName()</strong> : <em>string</em><br /><em>Get the type name of the contributor</em> |

<hr />

### Class: \takisrs\Biblionet\Models\Subject

> The model class of Subject

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>int</em> <strong>$id</strong>, <em>string</em> <strong>$name</strong>, <em>string</em> <strong>$ddc</strong>, <em>int</em> <strong>$order</strong>)</strong> : <em>void</em><br /><em>Subject constructor</em> |
| public | <strong>getDdc()</strong> : <em>string</em><br /><em>Get the DDC of subject</em> |
| public | <strong>getId()</strong> : <em>int</em><br /><em>Get the id of subject</em> |
| public | <strong>getName()</strong> : <em>string</em><br /><em>Get the name of subject</em> |
| public | <strong>getOrder()</strong> : <em>int</em><br /><em>Get the order of subject</em> |

<hr />

### Class: \takisrs\Biblionet\Models\Place

> The model class of Place

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>int</em> <strong>$id</strong>, <em>string</em> <strong>$name</strong>)</strong> : <em>void</em><br /><em>Place constructor</em> |
| public | <strong>getId()</strong> : <em>int</em><br /><em>Get the id of the place</em> |
| public | <strong>getName()</strong> : <em>string</em><br /><em>Get the name of the place</em> |

<hr />

### Class: \takisrs\Biblionet\Models\Language

> The model class of Language

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>int</em> <strong>$id</strong>, <em>string</em> <strong>$name</strong>)</strong> : <em>void</em><br /><em>The language constructor</em> |
| public | <strong>getId()</strong> : <em>int</em><br /><em>Get the id of the language</em> |
| public | <strong>getName()</strong> : <em>string</em><br /><em>Get the name of the language</em> |
