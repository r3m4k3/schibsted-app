<?php

namespace ApiBundle\Entity;

use ApiBundle\Entity\Coordinates;

class Place
{
    private $id;

    private $location;

    private $name;

    private $address;

    public function __construct($id, $name, Coordinates $location, $address = null) 
    {
       $this->id = $id;
       $this->location = $location;
       $this->name = $name;
       $this->address = $address;
    }

}
