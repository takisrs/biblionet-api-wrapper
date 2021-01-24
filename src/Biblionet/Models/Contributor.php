<?php

namespace Biblionet\Models;

/**
 * The model class of Contributor (ex. writer)
 */
class Contributor
{

    private int $id;
    private string $name;
    private string $typeId;
    private string $typeName;
    private int $order;

    /**
     * Contributor constructor
     *
     * @param integer $id contributor id
     * @param string $name contributor name
     * @param integer $typeId contributor type id
     * @param string $typeName contributor type name
     * @param integer $order contributor order
     */
    public function __construct($id, $name, $typeId = 1, $typeName = 'Συγγραφέας', $order = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->typeId = $typeId;
        $this->typeName = $typeName;
        $this->order = $order;
    }

    /**
     * Get the id of the contributor
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the name of the contributor
     *
     * @return void
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the type id of the contributor
     *
     * @return integer
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * Get the type name of the contributor
     *
     * @return string
     */
    public function getTypeName()
    {
        return $this->typeName;
    }

    /**
     * Get the order of the contributor
     */ 
    public function getOrder()
    {
        return $this->order;
    }
}
