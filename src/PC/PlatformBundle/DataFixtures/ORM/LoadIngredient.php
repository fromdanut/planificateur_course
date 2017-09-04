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
        $ml = new Unit();
        $ml->setName('ml');
        $g = new Unit();
        $g->setName('g');
        $u = new Unit();
        $u->setName('unite');

        // 6 categories.
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


        // 5 ingrédient (nom, prix, calorie, unité, cat, date)
        $rows = array(
            // En g.
            array('sel', 0.0001, 0, $g, $esa, $date),
            array('poivre', 0.05, 0, $g, $esa, $date),
            array('noix de muscade', 0.05, 0, $g, $esa, $date),
            array('curcuma', 0.05, 0, $g, $esa, $date),
            array('curry', 0.05, 0, $g, $esa, $date),
            array('sucre', 0.001, 4, $g, $esu, $date),
            array('farine', 0.002, 4, $g, $esa, $date),
            array('pâte', 0.002, 1, $g, $esa, $date),
            array('pâte complète', 0.003, 1, $g, $esa, $date),
            array('riz', 0.002, 1, $g, $esa, $date),
            array('riz complet', 0.003, 1, $g, $esa, $date),
            array('semoule', 0.002, 3, $g, $esa, $date),
                // legumes
            array('pomme de terre', 0.002, 1, $g, $fl, $date),
            array('courgette', 0.002, 0, $g, $fl, $date),
            array('aubergine', 0.005, 0, $g, $fl, $date),
            array('poivron', 0.005, 0, $g, $fl, $date),
            array('haricot vert', 0.007, 0, $g, $fl, $date),
            array('coco de paimpol', 0.010, 1, $g, $fl, $date),
            array('pois chiche', 0.002, 4, $g, $fl, $date),
            array('lentille verte', 0.003, 3, $g, $fl, $date),
            array('tomate', 0.004, 0, $g, $fl, $date),
            array('tomate concassée', 0.01, 1, $g, $fl, $date),
                // fruits
            array('fraise', 0.010 , 1, $g, $fl, $date),
            array('framboise', 0.010 , 1, $g, $fl, $date),
            array('cassis', 0.010 , 1, $g, $fl, $date),
            array('pomme', 0.003 , 1, $g, $fl, $date),
            array('poire', 0.004 , 1, $g, $fl, $date),
            array('pêche', 0.004 , 1, $g, $fl, $date),
                // produits laitiers
            array('beurre', 0.008, 7, $g, $pl, $date),
            array('gruyère rapé', 0.020, 4, $g, $pl, $date),
            array('parmesan rapé', 0.025, 5, $g, $pl, $date),
            array('camembert', 0.016, 3, $g, $pl, $date),
            array('crème fraiche', 0.008, 2, $g, $pl, $date),

            // En ml
            array('lait', 0.002 , 2, $ml, $pl, $date),
            array('huile d\'olive', 0.006 , 9, $ml, $esa, $date),
            array('vinaigre', 0.006 , 0, $ml, $esa, $date),

            // A l'unité.
            array('oeuf', 0.20, 75, $u, $esa, $date),
            array('gousse d\'ail', 0.05, 10, $u, $fl, $date),
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
