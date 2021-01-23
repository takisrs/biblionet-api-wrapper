<?php

namespace Biblionet;

class Biblionet
{
    private $apiFetcher;

    public function __construct($username, $password)
    {

        $this->apiFetcher = new ApiFetcher($username, $password);
    }

    public function getApiFetcher()
    {
        return $this->apiFetcher;
    }

}
