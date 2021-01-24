<?php

namespace Biblionet\Models;

class Subject
{

    private int $id;
    private string $name;
    private string $ddc;
    private int $order;

    public function __construct($id, $name, $ddc, $order)
    {
        $this->id = $id;
        $this->name = $name;
        $this->ddc = $ddc;
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
     * Get the value of ddc
     */ 
    public function getDdc()
    {
        return $this->ddc;
    }

    /**
     * Get the value of order
     */ 
    public function getOrder()
    {
        return $this->order;
    }
}
