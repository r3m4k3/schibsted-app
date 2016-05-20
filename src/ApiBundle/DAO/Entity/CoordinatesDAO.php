<?php

namespace ApiBundle\DAO\Entity;

use ApiBundle\Entity\Coordinates;

interface CoordinatesDAO {
   public function find($id);
   public function findAll();
   public function add(Coordinates $coordinates);
   public function remove(Coordinates $coordinates);
}