<?php

namespace Biblionet\Models;

class Category{

    private int $id;
    private string $name;

    /**
     * category constructor
     * @param int $id
     * @param string $name
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * get the id of the category
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * get the name of the category
     * @return string
     */
    public function getName(){
        return $this->name;
    }
}