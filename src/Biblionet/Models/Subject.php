<?php

namespace takisrs\Biblionet\Models;

/**
 * The model class of Subject
 * 
 * @author Panagiots Pantazopoulos <takispadaz@gmail.com>
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
     * @param int $id
     * @param string $name
     * @param string $ddc
     * @param int $order
     */
    public function __construct($id, $name, $ddc, $order)
    {
        $this->id = $id;
        $this->name = $name;
        $this->ddc = $ddc;
        $this->order = (int)$order;
    }

    /**
     * Get the id of subject
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the name of subject
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the DDC of subject
     * 
     * @return string
     */
    public function getDdc(): string
    {
        return $this->ddc;
    }

    /**
     * Get the order of subject
     * 
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }
}
