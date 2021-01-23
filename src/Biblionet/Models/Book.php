<?php

namespace Biblionet\Models;

class Book
{

    private $id;
    private $title;
    private $image;
    private $subtitle;
    private $alternativeTitle;
    private $originalTitle;

    private $isbn;
    private $isbn2;
    private $isbn3;

    private $publisher;

    private $writer;

    private $firstPublishDate;
    private $currentPublishDate;

    private $futurePublishDate;

    private $place;

    private $type;

    private $editionNo;
    private $cover;
    private $dimensions;
    private $pageNo;

    private $availability;

    private $price;
    private $vat;
    private $weight;

    private $ageFrom;
    private $ageTo;

    private $summary;

    private $language;

    private $originalLanguage;

    private $translatedLanguage;

    private $series;

    private $subseries;

    private $multiVolumeTitle;

    private $volumeNo;

    private $specifications;
    private $webAddress;

    private $comments;

    private $category;

    private $lastUpdated;

    public function __construct($data)
    {
        $this->id = $data->TitlesID;
        $this->title = $data->Title;
        $this->subtitle = $data->Subtitle;
        $this->alternativeTitle = $data->AlternativeTitle;
        $this->originalTitle = $data->OriginalTitle;
        $this->isbn = $data->ISBN;
        $this->isbn2 = $data->ISBN_2;
        $this->isbn3 = $data->ISBN_3;

        $this->firstPublishDate = $data->FirstPublishDate;
        $this->currentPublishDate = $data->CurrentPublishDate;
        $this->futurePublishDate = $data->FuturePublishDate;

        $this->type = $data->TitleType;

        $this->editionNo = $data->EditionNo;
        $this->cover = $data->Cover;
        $this->dimensions = $data->Dimensions;
        $this->pageNo = $data->PageNo;

        $this->availability = $data->Availability;

        $this->price = $data->Price;
        $this->vat = $data->VAT;

        $this->weight = $data->Weight;
        $this->ageFrom = $data->AgeFrom;
        $this->ageTo = $data->AgeTo;

        $this->summary = $data->Summary;

        $this->language = new Language($data->LanguageID, $data->Language);
        $this->originaLanguage = new Language($data->LanguageOriginalID, $data->LanguageOriginal);
        $this->translatedLanguage = new Language($data->LanguageTranslatedFromID, $data->LanguageTranslatedFrom);

        $this->publisher = new Publisher($data->PublisherID, $data->Publisher);
        $this->writer = new Writer($data->WriterID, $data->WriterName);
        $this->category = new Category($data->CategoryID, $data->Category);

        $this->place = new Place($data->PlaceID, $data->Place);


        $this->series = $data->Series;
        //$this->series = $data->Series;

        $this->subseries = $data->SubSeries;

        $this->multiVolumeTitle = $data->MultiVolumeTitle;

        $this->volumeNo = $data->VolumeNo;

        $this->specifications = $data->Specifications;
        $this->webAddress = $data->WebAddress;

        $this->comments = $data->Comments;

        $this->lastUpdated = $data->LastUpdate;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getCategory()
    {
        return $this->category;
    }


    /**
     * Get the value of image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Get the value of subtitle
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Get the value of alternativeTitle
     */
    public function getAlternativeTitle()
    {
        return $this->alternativeTitle;
    }

    /**
     * Get the value of originalTitle
     */
    public function getOriginalTitle()
    {
        return $this->originalTitle;
    }

    /**
     * Get the value of isbn
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Get the value of isbn2
     */
    public function getIsbn2()
    {
        return $this->isbn2;
    }

    /**
     * Get the value of isbn3
     */
    public function getIsbn3()
    {
        return $this->isbn3;
    }

    /**
     * Get the value of publisher
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * Get the value of writer
     */
    public function getWriter()
    {
        return $this->writer;
    }

    /**
     * Get the value of firstPublishDate
     */
    public function getFirstPublishDate()
    {
        return $this->firstPublishDate;
    }

    /**
     * Get the value of currentPublishDate
     */
    public function getCurrentPublishDate()
    {
        return $this->currentPublishDate;
    }

    /**
     * Get the value of futurePublishDate
     */
    public function getFuturePublishDate()
    {
        return $this->futurePublishDate;
    }

    /**
     * Get the value of place
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Get the value of type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the value of editionNo
     */
    public function getEditionNo()
    {
        return $this->editionNo;
    }

    /**
     * Get the value of cover
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Get the value of dimensions
     */
    public function getDimensions()
    {
        return $this->dimensions;
    }

    /**
     * Get the value of pageNo
     */
    public function getPageNo()
    {
        return $this->pageNo;
    }

    /**
     * Get the value of availability
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Get the value of vat
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * Get the value of weight
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Get the value of ageFrom
     */
    public function getAgeFrom()
    {
        return $this->ageFrom;
    }

    /**
     * Get the value of ageTo
     */
    public function getAgeTo()
    {
        return $this->ageTo;
    }

    /**
     * Get the value of summary
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Get the value of language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Get the value of originalLanguage
     */
    public function getOriginalLanguage()
    {
        return $this->originalLanguage;
    }

    /**
     * Get the value of translatedLanguage
     */
    public function getTranslatedLanguage()
    {
        return $this->translatedLanguage;
    }

    /**
     * Get the value of series
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * Get the value of subseries
     */
    public function getSubseries()
    {
        return $this->subseries;
    }

    /**
     * Get the value of multiVolumeTitle
     */
    public function getMultiVolumeTitle()
    {
        return $this->multiVolumeTitle;
    }

    /**
     * Get the value of volumeNo
     */
    public function getVolumeNo()
    {
        return $this->volumeNo;
    }

    /**
     * Get the value of specifications
     */
    public function getSpecifications()
    {
        return $this->specifications;
    }

    /**
     * Get the value of webAddress
     */
    public function getWebAddress()
    {
        return $this->webAddress;
    }

    /**
     * Get the value of comments
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Get the value of lastUpdated
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }
}
