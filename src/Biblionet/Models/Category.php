<?php

namespace Biblionet\Models;

/**
 * The model class of Category
 * 
 * @author Panagiots Pantazopoulos <takispadaz@gmail.com>
 */
class Category
{

    private int $id;
    private string $name;

    /**
     * category constructor
     * @param int $id category id
     * @param string $name category name
     */
    public function __construct($id, $name)
    {
        $this->id = (int)$id;
        $this->name = $name;
    }

    /**
     * get the id of the category
     * 
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * get the name of the category
     * 
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
