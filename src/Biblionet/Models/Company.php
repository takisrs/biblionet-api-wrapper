<?php

namespace Biblionet\Models;

/**
 * The model class of Company (ex. publisher)
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
     * @param integer $id category id
     * @param string $name category name
     * @param integer $typeId category type id
     * @param string $typeName category type name
     * @param integer $order category order
     */
    public function __construct($id, $name, $typeId = 1, $typeName = 'Εκδότης', $order = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->typeId = $typeId;
        $this->typeName = $typeName;
        $this->order = $order;
    }

    /**
     * Get the id of the category
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the name of the category
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the type id of the category
     * 
     * @return integer
     */ 
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * Get the type name of the category
     * 
     * @return string
     */ 
    public function getTypeName()
    {
        return $this->typeName;
    }

    /**
     * Get the order of the category
     * 
     * @return integer
     */ 
    public function getOrder()
    {
        return $this->order;
    }
}
