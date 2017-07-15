<?php

// src/PC/PlatformBundle/Antispam/PCAntispam.php

namespace PC\PlatformBundle\Antispam;
use PC\PlatformBundle\Entity\Recipe;

class PCAntispam
{

    protected $em;
    protected $insertion_limit_time;
    protected $nb_max_ingredient;

    public function __construct(\Doctrine\ORM\EntityManager $em,
                                $insertion_limit_time,
                                $nb_max_ingredient)
    {
      $this->em = $em;
      $this->insertion_limit_time = $insertion_limit_time;
      $this->nb_max_ingredient = $nb_max_ingredient;
    }

     /**
     * Vérifie 2 choses :
     * - si aucune recette n'a déjà été enregistrée dans les XX dernières secondes.
     * - si le nombre d'ingrédients est supérieur a XX
     * @param $recipe
     * @return bool
     */
    public function isSpam(Recipe $recipe)
    {
        // diff entre la dernière recette et la nouvelle.
        $last_recipe = $this->em
            ->getRepository('PCPlatformBundle:Recipe')
            ->findLastRecipe();

        $d = $recipe
            ->getDatePublication()
            ->diff($last_recipe->getDatePublication());

        // trop d'ingrédient dans la recette.
        if (count($recipe->getRecipeIngredients()) > $this->nb_max_ingredient) {
            return True;
        }

        // trop peu de tps entre 2 recettes.
        if ($d->y == 0 && $d->m == 0 && $d->h == 0 && $d->i == 0 &&
            $d->s < $this->insertion_limit_time) {
            return True;
        }

        return False;
    }
}
