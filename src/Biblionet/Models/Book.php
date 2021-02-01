<?php

namespace Biblionet\Models;

/**
 * The model class of Book
 */
class Book
{

    /**
     * Mapped to TitlesID
     */
    private int $id;

    /**
     * Mapped to Title
     */
    private string $title;

    /**
     * Mapped to CoverImage
     */
    private string $image;

    /**
     * Mapped to Subtitle
     */
    private string $subtitle;

    /**
     * Mapped to AlternativeTitle
     */
    private string $alternativeTitle;

    /**
     * Mapped to OriginalTitle
     */
    private string $originalTitle;

    /**
     * Mapped to ISBN
     */
    private string $isbn;

    /**
     * Mapped to ISBN_2
     */
    private string $isbn2;

    /**
     * Mapped to ISBN_3
     */
    private string $isbn3;

    /**
     * Mapped to Publisher, PublisherID
     */
    private Company $publisher;

    /**
     * Mapped to Writer, WriterID, WriterName
     */
    private Contributor $writer;

    /**
     * Mapped to FirstPublishDate
     */
    private \Datetime $firstPublishDate;

    /**
     * Mapped to CurrentPublishDate
     */
    private \Datetime $currentPublishDate;

    /**
     * Mapped to FuturePublishDate
     */
    private \Datetime $futurePublishDate;

    /**
     * Mapped to PlaceID, Place
     */
    private Place $place;

    /**
     * Mapped to TitleType
     */
    private string $type;

    /**
     * Mapped to EditionNo
     */
    private string $editionNo;

    /**
     * Mapped to Cover
     */    
    private string $cover;

    /**
     * Mapped to Dimensions
     */
    private string $dimensions;

    /**
     * Mapped to PageNo
     */
    private int $pageNo;

    /**
     * Mapped to Availability
     */
    private string $availability;

    /**
     * Mapped to Price
     */
    private float $price;

    /**
     * Mapped to VAT
     */
    private float $vat;

    /**
     * Mapped to Weight
     */
    private int $weight;

    /**
     * Mapped to AgeFrom
     */
    private int $ageFrom;

    /**
     * Mapped to AgeTo
     */
    private int $ageTo;

    /**
     * Mapped to Summary
     */
    private string $summary;

    /**
     * Mapped to LanguageID, Language
     */
    private Language $language;

    /**
     * Mapped to LanguageOriginalID, LanguageOriginal
     */
    private Language $originalLanguage;

    /**
     * Mapped to LanguageTranslatedFromID, LanguageTranslatedFrom
     */
    private Language $translatedLanguage;

    /**
     * Mapped to Series
     */
    private string $series;

    /**
     * Mapped to SeriesNo
     */
    private string $seriesNo;

    /**
     * Mapped to SubSeries
     */
    private string $subSeries;

    /**
     * Mapped to SubSeriesNo
     */
    private string $subSeriesNo;

    /**
     * Mapped to MultiVolumeTitle
     */  
    private string $multiVolumeTitle;

    /**
     * Mapped to VolumeNo
     */ 
    private string $volumeNo;

    /**
     * Mapped to VolumeCount
     */ 
    private string $volumeCount;

    /**
     * Mapped to Specifications
     */ 
    private string $specifications;

    /**
     * Mapped to WebAddress
     */ 
    private string $webAddress;

    /**
     * Mapped to Comments
     */ 
    private string $comments;

    /**
     * Mapped to CategoryID, Category
     */ 
    private Category $category;

    /**
     * Mapped to LastUpdate
     */ 
    private \Datetime $lastUpdated;

    private array $subjects = [];
    private array $contributors = [];
    private array $companies = [];

    public function __construct($data)
    {
        $this->id = (int)$data->TitlesID;
        $this->title = $data->Title;
        $this->subtitle = $data->Subtitle;
        $this->alternativeTitle = $data->AlternativeTitle;
        $this->originalTitle = $data->OriginalTitle;

        $this->isbn = $data->ISBN;
        $this->isbn2 = $data->ISBN_2;
        $this->isbn3 = $data->ISBN_3;

        if (!empty($data->FirstPublishDate) && $data->FirstPublishDate !== "0000-00-00")
            $this->firstPublishDate = new \Datetime($data->FirstPublishDate);

        if (!empty($data->CurrentPublishDate) && $data->CurrentPublishDate !== "0000-00-00")
            $this->currentPublishDate = new \Datetime($data->CurrentPublishDate);

        if (!empty($data->FuturePublishDate) && $data->FuturePublishDate !== "0000-00-00")
            $this->futurePublishDate = new \Datetime($data->FuturePublishDate);

        $this->type = $data->TitleType;

        $this->editionNo = $data->EditionNo;
        $this->cover = $data->Cover;
        $this->dimensions = $data->Dimensions;
        $this->pageNo = (int)$data->PageNo;

        $this->weight = (int)$data->Weight;

        $this->availability = $data->Availability;

        $this->price = round((float)$data->Price, 2);
        $this->vat = $data->VAT;
        
        $this->ageFrom = (int)$data->AgeFrom;
        $this->ageTo = (int)$data->AgeTo;

        $this->summary = $data->Summary;

        $this->language = new Language($data->LanguageID, $data->Language);
        $this->originaLanguage = new Language($data->LanguageOriginalID, $data->LanguageOriginal);
        $this->translatedLanguage = new Language($data->LanguageTranslatedFromID, $data->LanguageTranslatedFrom);

        $this->publisher = new Company($data->PublisherID, $data->Publisher);
        $this->writer = new Contributor($data->WriterID, $data->WriterName);

        $this->category = new Category($data->CategoryID, $data->Category);

        $this->place = new Place($data->PlaceID, $data->Place);

        $this->series = $data->Series;
        $this->seriesNo = $data->SeriesNo;
        $this->subSeries = $data->SubSeries;
        $this->subSeriesNo = $data->SubSeriesNo;

        $this->multiVolumeTitle = $data->MultiVolumeTitle;
        $this->volumeNo = $data->VolumeNo;
        $this->volumeCount = $data->VolumeCount;

        $this->specifications = $data->Specifications;
        $this->webAddress = $data->WebAddress;

        $this->comments = $data->Comments;

        if (!empty($data->LastUpdate) && $data->LastUpdate !== "0000-00-00")
            $this->lastUpdated = new \Datetime($data->LastUpdate);
    }

    /**
     * Init Book's subjects
     *
     * @param array $data
     * @return void
     */
    public function setSubjects($data)
    {
        foreach ($data as $item) {
            if (!empty($item->SubjectsID)) {
                $subject = new Subject($item->SubjectsID, $item->SubjectTitle, $item->SubjectDDC, $item->SubjectOrder);
                array_push($this->subjects, $subject);
            }
        }
    }

    /**
     * Init Book's contributors
     *
     * @param array $data
     * @return void
     */
    public function setContributors($data)
    {
        foreach ($data as $item) {
            if (!empty($item->ContributorID)) {
                $contributor = new Contributor($item->ContributorID, $item->ContributorFullName, $item->ContributorTypeID, $item->ContributorType, $item->PresentOrder);
                array_push($this->contributors, $contributor);
            }
        }
    }

    /**
     * Init Book's companies
     *
     * @param array $data
     * @return void
     */
    public function setCompanies($data)
    {
        foreach ($data as $item) {
            if (!empty($item->CompanyID)) {
                $company = new Company($item->CompanyID, $item->CompanyName, $item->ComKindID, $item->ComKindType, $item->PresentOrder);
                array_push($this->companies, $company);
            }
        }
    }

    /**
     * Get the array of Subject objs
     * 
     * @return Subject[]
     */
    public function getSubjects(): array
    {
        return $this->subjects;
    }

    /**
     * Get the array of Contributor objs
     * 
     * @return Contributor[]
     */
    public function getContributors(): array
    {
        return $this->contributors;
    }

    /**
     * Get the array of Company objs
     * 
     * @return Company[]
     */
    public function getCompanies(): array
    {
        return $this->companies;
    }

    /**
     * Get the value of id
     * 
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the value of title
     * 
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Get the value of category
     * 
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * Get the value of image
     * 
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * Get the value of subtitle
     * 
     * @return string
     */
    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    /**
     * Get the value of alternativeTitle
     * 
     * @return string
     */
    public function getAlternativeTitle(): string
    {
        return $this->alternativeTitle;
    }

    /**
     * Get the value of originalTitle
     * 
     * @return string
     */
    public function getOriginalTitle(): string
    {
        return $this->originalTitle;
    }

    /**
     * Get the value of isbn
     * 
     * @return string
     */
    public function getIsbn(): string
    {
        return $this->isbn;
    }

    /**
     * Get the value of isbn2
     * 
     * @return string
     */
    public function getIsbn2(): string
    {
        return $this->isbn2;
    }

    /**
     * Get the value of isbn3
     * 
     * @return string
     */
    public function getIsbn3(): string
    {
        return $this->isbn3;
    }

    /**
     * Get the value of publisher
     * 
     * @return Company
     */
    public function getPublisher(): Company
    {
        return $this->publisher;
    }

    /**
     * Get the value of writer
     * 
     * @return Contributor
     */
    public function getWriter(): Contributor
    {
        return $this->writer;
    }

    /**
     * Get the value of firstPublishDate
     */
    public function getFirstPublishDate(): \Datetime
    {
        return $this->firstPublishDate;
    }

    /**
     * Get the value of currentPublishDate
     */
    public function getCurrentPublishDate(): \Datetime
    {
        return $this->currentPublishDate;
    }

    /**
     * Get the value of futurePublishDate
     */
    public function getFuturePublishDate(): \Datetime
    {
        return $this->futurePublishDate;
    }

    /**
     * Get the value of place
     * 
     * @return Place
     */
    public function getPlace(): Place
    {
        return $this->place;
    }

    /**
     * Get the value of type
     * 
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get the value of editionNo
     * 
     * @return string
     */
    public function getEditionNo(): string
    {
        return $this->editionNo;
    }

    /**
     * Get the value of cover
     * 
     * @return string
     */
    public function getCover(): string
    {
        return $this->cover;
    }

    /**
     * Get the value of dimensions
     * 
     * @return string
     */
    public function getDimensions(): string
    {
        return $this->dimensions;
    }

    /**
     * Get the value of pageNo
     * 
     * @return int
     */
    public function getPageNo(): int
    {
        return $this->pageNo;
    }

    /**
     * Get the value of availability
     * 
     * @return string
     */
    public function getAvailability(): string
    {
        return $this->availability;
    }

    /**
     * Get the value of price (euros)
     * 
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Get the value of vat (percentage)
     * 
     * @return float
     */
    public function getVat(): float
    {
        return $this->vat;
    }

    /**
     * Get the value of weight (grams)
     * 
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * Get the value of ageFrom
     * 
     * @return int
     */
    public function getAgeFrom(): int
    {
        return $this->ageFrom;
    }

    /**
     * Get the value of ageTo
     * 
     * @return int
     */
    public function getAgeTo(): int
    {
        return $this->ageTo;
    }

    /**
     * Get the value of summary
     * 
     * @return string
     */
    public function getSummary(): string
    {
        return $this->summary;
    }

    /**
     * Get the value of language
     * 
     * @return Language
     */
    public function getLanguage(): Language
    {
        return $this->language;
    }

    /**
     * Get the value of originalLanguage
     * 
     * @return Language
     */
    public function getOriginalLanguage(): Language
    {
        return $this->originalLanguage;
    }

    /**
     * Get the value of translatedLanguage
     * 
     * @return Language
     */
    public function getTranslatedLanguage(): Language
    {
        return $this->translatedLanguage;
    }

    /**
     * Get the value of series
     * 
     * @return string
     */
    public function getSeries(): string
    {
        return $this->series;
    }

    /**
     * Get the value of multiVolumeTitle
     * 
     * @return string
     */
    public function getMultiVolumeTitle(): string
    {
        return $this->multiVolumeTitle;
    }

    /**
     * Get the value of volumeNo
     * 
     * @return string
     */
    public function getVolumeNo(): string
    {
        return $this->volumeNo;
    }

    /**
     * Get the value of specifications
     * 
     * @return string
     */
    public function getSpecifications(): string
    {
        return $this->specifications;
    }

    /**
     * Get the value of webAddress
     * 
     * @return string
     */
    public function getWebAddress(): string
    {
        return $this->webAddress;
    }

    /**
     * Get the value of comments
     * 
     * @return string
     */
    public function getComments(): string
    {
        return $this->comments;
    }

    /**
     * Get the value of lastUpdated
     * 
     * @return \Datetime
     */
    public function getLastUpdated(): \Datetime
    {
        return $this->lastUpdated;
    }

    /**
     * Get mapped to SeriesNo
     * 
     * @return string
     */ 
    public function getSeriesNo(): string
    {
        return $this->seriesNo;
    }

    /**
     * Get mapped to SubSeries
     * 
     * @return string
     */ 
    public function getSubSeries(): string
    {
        return $this->subSeries;
    }

    /**
     * Get mapped to SubSeriesNo
     * 
     * @return string
     */ 
    public function getSubSeriesNo(): string
    {
        return $this->subSeriesNo;
    }

    /**
     * Get the value of volumeCount
     * 
     * @return string
     */ 
    public function getVolumeCount(): string
    {
        return $this->volumeCount;
    }
}
