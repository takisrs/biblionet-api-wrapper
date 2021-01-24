<?php

namespace Biblionet\Models;

class Contributor
{

    private int $id;
    private string $name;
    private string $typeId;
    private string $typeName;
    private int $order;

    public function __construct($id, $name, $typeId = 1, $typeName = 'Συγγραφέας', $order = 0)
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

    public function getTypeId()
    {
        return $this->typeId;
    }

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
