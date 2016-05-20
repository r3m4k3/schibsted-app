<?php

namespace ApiBundle\Entity;

class Coordinates
{
    private $id;

    private $latitude;

    private $longitude;

    public function __construct($latitude, $longitude) 
    {
       $this->latitude = $latitude;
       $this->longitude = $longitude;
    }

    public function __toString()
    {
    	return $this->latitude . ", " . $this->longitude;
    }

}
