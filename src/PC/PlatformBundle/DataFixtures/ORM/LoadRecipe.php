<?php

// src/PC/PlatformBundle/DataFixtures/ORM/LoadRecipe.php

namespace PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PC\PlatformBundle\Entity\Recipe;
use PC\PlatformBundle\Entity\Image;

class LoadRecipe implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 10; $i++) {
            // La categorie;
            $cat = $manager->getRepository('PCPlatformBundle:Category')->findOneBy(array('name' => 'italien'));
            // L'image (la meme pour l'ensemble des recettes)
            $image = new Image();
            $image->setUrl("https://images.marmitoncdn.org/recipephotos/multiphoto/57/572cf720-8433-4896-ad45-b0534eac1bb9_normal.jpg");
            $image->setAlt("Une tarte à la fraise");
            // La recette
            $recipe = new Recipe();
            $recipe->setName("recette n°".$i);
            $recipe->setCookingTime(20+$i);
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
            $recipe->setRating(4);
            $recipe->setImage($image);
            $recipe->addCategory($cat);
            # recipe->setDatePublication(new \DateTime());
            // persite l'image et la recipe.
            $manager->persist($image);
            $manager->persist($recipe);

        }
        $manager->flush();
    }
}
