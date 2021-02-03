<?php

namespace takisrs\Biblionet\Models;

/**
 * The model class of Place
 * 
 * @author Panagiots Pantazopoulos <takispadaz@gmail.com>
 */
class Place
{

    private int $id;
    private string $name;

    /**
     * Place constructor
     *
     * @param int $id
     * @param string $name
     */
    public function __construct($id, $name)
    {
        $this->id = (int)$id;
        $this->name = $name;
    }

    /**
     * Get the id of the place
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the name of the place
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
