<?php

namespace takisrs\Biblionet\Models;

/**
 * The model class of Company (ex. publisher)
 * 
 * @author Panagiots Pantazopoulos <takispadaz@gmail.com>
 */
class Company
{

    private int $id;
    private string $name;
    private int $typeId;
    private string $typeName;
    private int $order;

    /**
     * Company constructor
     *
     * @param int $id category id
     * @param string $name category name
     * @param int $typeId category type id
     * @param string $typeName category type name
     * @param int $order category order
     */
    public function __construct($id, $name, $typeId = 1, $typeName = 'Εκδότης', $order = 0)
    {
        $this->id = (int)$id;
        $this->name = $name;
        $this->typeId = (int)$typeId;
        $this->typeName = $typeName;
        $this->order = (int)$order;
    }

    /**
     * Get the id of the category
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the name of the category
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the type id of the category
     * 
     * @return int
     */
    public function getTypeId(): int
    {
        return $this->typeId;
    }

    /**
     * Get the type name of the category
     * 
     * @return string
     */
    public function getTypeName(): string
    {
        return $this->typeName;
    }

    /**
     * Get the order of the category
     * 
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }
}
