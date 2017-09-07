<?php

// src/PC/PlatformBundle/DataFixtures/ORM/LoadCategory.php

namespace PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PC\PlatformBundle\Entity\Category;

class LoadCategory implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $names = array(
            'italien',
            'traditionnel',
            'chinois',
            'fast-food',
            'indien',
            'mexicain',
            'thaï',
            'oriental',
            'espagnol',
            'libanais',
            'grec',
            'japonais',

        );

        foreach ($names as $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
        }
        $manager->flush();
    }
}
