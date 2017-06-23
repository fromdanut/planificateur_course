<?php

// src/PC/PlatformBundle/DataFixtures/ORM/LoadIngredient.php

namespace PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PC\PlatformBundle\Entity\Ingredient;
use PC\PlatformBundle\Entity\Unit;
use PC\PlatformBundle\Entity\CategoryIngredient;

class LoadIngredient implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // 3 unités différentes.
        $clUnit = new Unit();
        $clUnit->setName('cl');
        $gUnit = new Unit();
        $gUnit->setName('g');
        $unit = new Unit();
        $unit->setName('unite');

        // 6 categories.
        $names = array(
            'boissons',
            'épicerie salée',
            'épicerie sucrée'
        );

        $pl = new CategoryIngredient;
        $pl->setName('produits laitiers');
        $fl = new CategoryIngredient;
        $fl->setName('fruits et legumes');
        $vp = new CategoryIngredient;
        $vp->setName('viandes et poissons');
        $b = new CategoryIngredient;
        $b->setName('boissons');
        $esa = new CategoryIngredient;
        $esa->setName('épicerie salée');
        $esu = new CategoryIngredient;
        $esu->setName('épicerie sucrée');


        // 5 ingrédient (nom, prix, calorie, unité, cat)
        $rows = array(
            array('fraise', 0.001,'150', $gUnit, $fl),
            array('sucre', 0.0001,'600', $gUnit, $esu),
            array('farine', 0.002,'300', $gUnit, $esa),
            array('lait', 0.003,'90', $clUnit, $pl),
            array('oeuf', 0.20,'80', $unit, $esa),
        );

        foreach ($rows as $row) {
            $ingredient = new Ingredient();
            $ingredient->setName($row[0]);
            $ingredient->setPrice($row[1]);
            $ingredient->setCalorie($row[2]);
            $ingredient->setUnit($row[3]);
            $ingredient->setCategory($row[4]);
            $manager->persist($ingredient);
        }
        $manager->flush();
    }
}
