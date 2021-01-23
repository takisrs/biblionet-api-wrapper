<?php

namespace Biblionet\Models;

class Writer{

    private int $id;
    private string $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }
}