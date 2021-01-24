<?php

namespace Biblionet\Models;

class Company
{

    private int $id;
    private string $name;
    private int $typeId;
    private string $typeName;
    private int $order;

    public function __construct($id, $name, $typeId = 1, $typeName = 'Εκδότης', $order = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->typeId = $typeId;
        $this->typeName = $typeName;
        $this->order = $order;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of typeId
     */ 
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * Get the value of typeName
     */ 
    public function getTypeName()
    {
        return $this->typeName;
    }

    /**
     * Get the value of order
     */ 
    public function getOrder()
    {
        return $this->order;
    }
}
