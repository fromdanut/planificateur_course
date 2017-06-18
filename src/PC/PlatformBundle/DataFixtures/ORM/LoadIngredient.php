<?php

// src/PC/PlatformBundle/DataFixtures/ORM/LoadIngredient.php

namespace PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PC\PlatformBundle\Entity\Ingredient;
use PC\PlatformBundle\Entity\Unit;

class LoadIngredient implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        //
        $clUnit = new Unit();
        $clUnit->setName('cl');
        $gUnit = new Unit();
        $gUnit->setName('g');
        $unit = new Unit();
        $unit->setName('unite');

        // 5 ingrédient (nom, prix, calorie, unité)
        $rows = array(
            array('fraise','6','600', $gUnit),
            array('sucre','2','3000', $gUnit),
            array('farine','1','3000', $gUnit),
            array('lait','2','900', $clUnit),
            array('oeuf','6','600', $unit),
        );

        foreach ($rows as $row) {
            $ingredient = new Ingredient();
            $ingredient->setName($row[0]);
            $ingredient->setPrice($row[1]);
            $ingredient->setCalorie($row[2]);
            $ingredient->setUnit($row[3]);
            $manager->persist($ingredient);
        }
        $manager->flush();
    }
}
