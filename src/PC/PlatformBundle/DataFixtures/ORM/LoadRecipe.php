<?php

// src/PC/PlatformBundle/DataFixtures/ORM/LoadRecipe.php

namespace PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PC\PlatformBundle\Entity\Recipe;
use PC\PlatformBundle\Entity\Image;
use PC\PlatformBundle\Entity\Ingredient;
use PC\PlatformBundle\Entity\RecipeIngredient;

class LoadRecipe implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 30; $i++) {

            /*
                Ce Datafixtures doit permettre d'avoir un panel de recette avec des attributs différents afin,
                notamment de tester la génération de liste de recette en fonction de critères (temps de préparation,
                prix, diététique)
            */

            // La recette
            $recipe = new Recipe();
            $recipe->setName("recette n°".$i);
            $recipe->setCookingTime(2*$i);
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


            // Les ingrédients
            $ingredients = $manager->getRepository('PCPlatformBundle:Ingredient')->findAll();
            foreach ($ingredients as $ingredient) {
                $RecipeIngredient = new RecipeIngredient();
                $RecipeIngredient->setRecipe($recipe); // lie à la recette.
                $RecipeIngredient->setIngredient($ingredient); // lie à l'ingrédient.
                $RecipeIngredient->setQuantity($i + (2 * $i * ($i % 2))); // On aura des recette avec des quantité différentes mais mini 1
                $manager->persist($RecipeIngredient);
            }
             // Deux catégories
            $catItalien = $manager->getRepository('PCPlatformBundle:Category')->findOneBy(array('name' => 'italien'));
            $catAsiatique = $manager->getRepository('PCPlatformBundle:Category')->findOneBy(array('name' => 'asiatique'));

            // Petite bidouille pour obtenir des recettes avec des cat et des notes (rating) différentes

            if ($i % 2 == 0) {
                $recipe->addCategory($catItalien);
                $recipe->setRating(4);
            }
            else {
                $recipe->addCategory($catAsiatique);
                $recipe->setRating(2);
            }

            // L'image (la meme pour l'ensemble des recettes)
            $image = new Image();
            $image->setUrl("https://images.marmitoncdn.org/recipephotos/multiphoto/57/572cf720-8433-4896-ad45-b0534eac1bb9_normal.jpg");
            $image->setAlt("Une tarte à la fraise");
            $recipe->setImage($image);
            $manager->persist($image);

            $manager->persist($recipe);

        }
        $manager->flush();
    }
}
