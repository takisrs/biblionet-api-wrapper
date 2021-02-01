<?php

namespace Biblionet\Models;

/**
 * The model class of Contributor (ex. writer)
 * 
 * @author Panagiots Pantazopoulos <takispadaz@gmail.com>
 */
class Contributor
{

    private int $id;
    private string $name;
    private string $typeId;
    private string $typeName;
    private int $order;

    /**
     * Contributor constructor
     *
     * @param int $id contributor id
     * @param string $name contributor name
     * @param int $typeId contributor type id
     * @param string $typeName contributor type name
     * @param int $order contributor order
     */
    public function __construct($id, $name, $typeId = 1, $typeName = 'Συγγραφέας', $order = 0)
    {
        $this->id = (int)$id;
        $this->name = $name;
        $this->typeId = (int)$typeId;
        $this->typeName = $typeName;
        $this->order = (int)$order;
    }

    /**
     * Get the id of the contributor
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the name of the contributor
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the type id of the contributor
     *
     * @return int
     */
    public function getTypeId(): int
    {
        return $this->typeId;
    }

    /**
     * Get the type name of the contributor
     *
     * @return string
     */
    public function getTypeName(): string
    {
        return $this->typeName;
    }

    /**
     * Get the order of the contributor
     * 
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }
}
