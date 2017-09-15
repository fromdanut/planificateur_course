<?php

// src/PC/PlatformBundle/DataFixtures/ORM/LoadRecipe.php

namespace PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PC\PlatformBundle\Entity\Recipe;
use PC\PlatformBundle\Entity\Image;
use PC\PlatformBundle\Entity\Ingredient;
use PC\PlatformBundle\Entity\RecipeIngredient;
use UserBundle\Entity\User;

class LoadRecipe implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Une recette de tarte aux fraises.
        $recipe = new Recipe();

        $recipe->setName("Tarte aux fraises");
        $recipe->setCookingTime(50);
        $recipe->setNbPerson(4);
        $recipe->setLongDescription('
            PÂTE:
            Blanchir les jaunes et le sucre au fouet et détendre le mélange avec un peu d eau.
            Mélanger au doigt la farine et le beurre coupé en petites parcelles pour obtenir une consistance sableuse et que tout le beurre soit absorbé (!!! Il faut faire vite pour que le mélange ne ramollisse pas trop!).
            Verser au milieu de ce "sable" le mélange liquide.
            Incorporer au couteau les éléments rapidement sans leur donner de corps.
            Former une boule avec les paumes et fraiser 1 ou 2 fois pour rendre la boule + homogène.
            Foncer un moule de 25 cm de diamètre avec la pâte, garnissez la de papier sulfurisé et de haricots secs.
            Faire cuire à blanc 20 à 25 min, à 180°C (thermostat 6).
            NB: après baisser le four à 120°C/150°C environ pour la meringue.
            CRÈME PÂTISSIÈRE :
            Mettre le lait à bouillir avec le parfum choisi (vanille ou autre).
            Travailler l oeuf avec le sucre jusqu à ce que la pâte fasse le ruban, ajouter la farine.
            Verser le lait bouillant sur le mélange en tournant bien.
            Remettre dans la casserole sur le feu.
            Faire cuire en tournant très soigneusement.
            Retirer après ébullition.
            Verser la crème sur le fond de tarte et disposer joliment les fraises coupées en 2.');
        $recipe->setShortDescription('Petite tarte aux fraises de saison qui ravira les petits comme les grands.');

        // L'auteur
        $user = $manager->getRepository('UserBundle:User')->findOneBy(array('username' => 'minus'));
        $recipe->setUser($user);

        // Les ingrédients

        $fraise = $manager->getRepository('PCPlatformBundle:Ingredient')->findOneBy(array('name' => 'fraise'));
        $fraiseRI = new RecipeIngredient();
        $fraiseRI->setRecipe($recipe);              // lie à la recette.
        $fraiseRI->setIngredient($fraise);
        $fraiseRI->setQuantity(400);
        $manager->persist($fraiseRI);

        $sucre = $manager->getRepository('PCPlatformBundle:Ingredient')->findOneBy(array('name' => 'sucre'));
        $sucreRI = new RecipeIngredient();
        $sucreRI->setRecipe($recipe);              // lie à la recette.
        $sucreRI->setIngredient($sucre);
        $sucreRI->setQuantity(200);
        $manager->persist($sucreRI);

        $oeuf = $manager->getRepository('PCPlatformBundle:Ingredient')->findOneBy(array('name' => 'oeuf'));
        $oeufRI = new RecipeIngredient();
        $oeufRI->setRecipe($recipe);              // lie à la recette.
        $oeufRI->setIngredient($oeuf);
        $oeufRI->setQuantity(4);
        $manager->persist($oeufRI);

        $lait = $manager->getRepository('PCPlatformBundle:Ingredient')->findOneBy(array('name' => 'lait'));
        $laitRI = new RecipeIngredient();
        $laitRI->setRecipe($recipe);              // lie à la recette.
        $laitRI->setIngredient($lait);
        $laitRI->setQuantity(200);
        $manager->persist($laitRI);

        $farine = $manager->getRepository('PCPlatformBundle:Ingredient')->findOneBy(array('name' => 'farine'));
        $farineRI = new RecipeIngredient();
        $farineRI->setRecipe($recipe);              // lie à la recette.
        $farineRI->setIngredient($farine);
        $farineRI->setQuantity(200);
        $manager->persist($farineRI);

        $beurre = $manager->getRepository('PCPlatformBundle:Ingredient')->findOneBy(array('name' => 'beurre'));
        $beurreRI = new RecipeIngredient();
        $beurreRI->setRecipe($recipe);              // lie à la recette.
        $beurreRI->setIngredient($beurre);
        $beurreRI->setQuantity(100);
        $manager->persist($beurreRI);

         // Deux catégories tradi et dessert.
        $recipe->addCategory(
            $manager->getRepository('PCPlatformBundle:Category')->findOneBy(array('name' => 'tradi'))
        );
        $recipe->addCategory(
            $manager->getRepository('PCPlatformBundle:Category')->findOneBy(array('name' => 'dessert'))
        );

        // Met la note à 4.
        $recipe->setRating(4);

        // L'image
        $image = new Image();
        $image->setUrl("http://images.freeimages.com/images/large-previews/c77/delicious-2-1515071.jpg");
        $image->setAlt("Tarte à la fraise");
        $recipe->setImage($image);
        $manager->persist($image);

        $manager->persist($recipe);

        $manager->flush();
    }

    public function getOrder()
    {
    // the order in which fixtures will be loaded
    // the lower the number, the sooner that this fixture is loaded
    return 2;
    }
}
