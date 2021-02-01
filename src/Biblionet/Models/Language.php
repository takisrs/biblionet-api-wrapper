<?php

namespace Biblionet\Models;

/**
 * The model class of Language
 * 
 * @author Panagiots Pantazopoulos <takispadaz@gmail.com>
 */
class Language
{

    private int $id;
    private string $name;

    /**
     * The language constructor
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
     * Get the id of the language
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the name of the language
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
