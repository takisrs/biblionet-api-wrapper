<?php

namespace Biblionet\Models;

/**
 * The model class of Language
 */
class Language
{

    private int $id;
    private string $name;

    /**
     * The language constructor
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
     * Get the id of the language
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the name of the language
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
