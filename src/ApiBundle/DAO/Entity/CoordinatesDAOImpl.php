<?php

namespace ApiBundle\DAO\Entity;

use Doctrine\ORM\EntityManager;

use ApiBundle\DAO\Entity\CoordinatesDAO;
use ApiBundle\Entity\Coordinates;

class CoordinatesDAOImpl implements CoordinatesDAO
{

   private $em;
	

   public function __construct(EntityManager $em)
   {
      $this->em = $em;
   }

   public function getRepository()
   {
      return $this->em->getRepository('ApiBundle:Coordinates');
   }

   public function find($id) 
   {
      return $this->getRepository()->find($id);
   }


   public function findAll()
   {
   	return $this->getRepository()->findAll();
   }

   public function add(Coordinates $coordinates)
   {
      $this->em->persist($coordinates);
      $this->em->flush();
   }

   public function remove(Coordinates $coordinates)
   {
      $this->em->remove($coordinates);
      $this->em->flush();
   }
	
}