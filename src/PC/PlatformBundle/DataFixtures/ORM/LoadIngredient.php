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

        $date = new \DateTime();

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
            array('fraise', 0.01,'150', $gUnit, $fl, $date),
            array('sucre', 0.001,'600', $gUnit, $esu, $date),
            array('farine', 0.002,'300', $gUnit, $esa, $date),
            array('lait', 0.003,'90', $clUnit, $pl, $date),
            array('oeuf', 0.20,'80', $unit, $esa, $date),
        );

        foreach ($rows as $row) {
            $ingredient = new Ingredient();
            $ingredient->setName($row[0]);
            $ingredient->setPrice($row[1]);
            $ingredient->setCalorie($row[2]);
            $ingredient->setUnit($row[3]);
            $ingredient->setCategory($row[4]);
            $ingredient->setDatePublication($row[5]);
            $manager->persist($ingredient);
        }
        $manager->flush();
    }
}
