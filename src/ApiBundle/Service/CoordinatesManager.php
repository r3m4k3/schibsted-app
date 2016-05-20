<?php

namespace ApiBundle\Service;

use Doctrine\ORM\EntityManager;

use ApiBundle\DAO\Entity\CoordinatesDAOImpl;
use ApiBundle\DAO\Repository\CoordinatesDAORepository;
use ApiBundle\Entity\Coordinates;


class CoordinatesManager
{
	private $repository;

	public function __construct(EntityManager $em)
	{
		$dao = new CoordinatesDAOImpl($em);
        $this->repository = new CoordinatesDAORepository($dao);
	}

	public function add(Coordinates $coordinates)
	{
		$this->repository->add($coordinates);
	}

    public function remove(Coordinates $coordinates)
    {
    	$this->repository->remove($coordinates);
    }

    public function find($id)
    {
    	return $this->repository->find($id);
    }

    public function findAll()
    {
    	return $this->repository->findAll();
    }

}