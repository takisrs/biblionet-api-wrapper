<?php

namespace Biblionet\Models;

/**
 * The model class of subject
 */
class Subject
{

    private int $id;
    private string $name;
    private string $ddc;
    private int $order;

    /**
     * Subject constructor
     *
     * @param integer $id
     * @param string $name
     * @param string $ddc
     * @param integer $order
     */
    public function __construct($id, $name, $ddc, $order)
    {
        $this->id = $id;
        $this->name = $name;
        $this->ddc = $ddc;
        $this->order = $order;
    }

    /**
     * Get the id of subject
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the name of subject
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the DDC of subject
     */ 
    public function getDdc()
    {
        return $this->ddc;
    }

    /**
     * Get the order of subject
     */ 
    public function getOrder()
    {
        return $this->order;
    }
}
