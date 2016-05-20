<?php

namespace ApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use ApiBundle\Entity\Coordinates;

class LoadSavedPlacesData implements FixtureInterface
{
    /**
     * 
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $coordinates = new Coordinates(54.348511, 18.653256);
        $manager->persist($coordinates);
        $manager->flush();
    }

}