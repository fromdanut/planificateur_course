<?php

// src/PC/PlatformBundle/DataFixtures/ORM/LoadShoppingList.php

namespace PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PC\PlatformBundle\Entity\ShoppingList;
use PC\PlatformBundle\Entity\Recipe;

class LoadShoppingList implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // créé une nouvelle liste de courses.
        $shoppingList = new ShoppingList();

        // récupère l'ensemble des recettes end BDD.
        $recipeRepo = $manager->getRepository('PCPlatformBundle:Recipe');
        $recipes = $recipeRepo->findAll();

        foreach ($recipes as $recipe) {
            $shoppingList->addRecipe($recipe);
        }
        $manager->persist($shoppingList);
        $manager->flush();
    }
}
