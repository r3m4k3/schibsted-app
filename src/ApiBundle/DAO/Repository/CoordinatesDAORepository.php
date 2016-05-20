<?php
namespace ApiBundle\DAO\Repository;

use ApiBundle\DAO\Entity\CoordinatesDAO;
use ApiBundle\Entity\Coordinates;
use ApiBundle\Repository\CoordinatesRepository;


final class CoordinatesDAORepository implements CoordinatesRepository
{
    private $dao;

    public function __construct(CoordinatesDAO $coordinatesDAO)
    {
        $this->dao = $coordinatesDAO;
    }

    public function add(Coordinates $coordinates)
    {
        $this->dao->add($coordinates);
    }

    public function remove(Coordinates $coordinates)
    {
        $this->dao->remove($coordinates);
    }

    public function find($id)
    {
        return $this->dao->find($id);
    }

    public function findAll()
    {
        return $this->dao->findAll();
    }

}