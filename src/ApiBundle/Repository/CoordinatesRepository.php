<?php

namespace ApiBundle\Repository;

use ApiBundle\Entity\Coordinates;

interface CoordinatesRepository
{
    public function add(Coordinates $coordinates);
    public function remove(Coordinates $coordinates);
    public function find($id);
    public function findAll();
}