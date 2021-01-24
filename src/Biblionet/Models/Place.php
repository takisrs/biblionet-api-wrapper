<?php

namespace Biblionet\Models;

/**
 * The model class of Place
 */
class Place
{

    private int $id;
    private string $name;

    /**
     * Place constructor
     *
     * @param integer $id
     * @param string $name
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * Get the id of the place
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the name of the place
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
