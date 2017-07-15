<?php

// src/PC/PlatformBundle/Antispam/PCAntispam.php

namespace PC\PlatformBundle\Antispam;

class PCAntispam
{

    protected $em;
    protected $insertion_limit_time;

    public function __construct(\Doctrine\ORM\EntityManager $em,
                                $insertion_limit_time)
    {
      $this->em = $em;
      $this->insertion_limit_time = $insertion_limit_time;
    }

     /**
     * Vérifie si la recette est du spam
     *
     * @param $recipe
     * @return bool
     */
    public function isSpam($recipe)
    {
        // difference between date of the new and the last recipe.
        $last_recipe = $this->em
            ->getRepository('PCPlatformBundle:Recipe')
            ->findLastRecipe();

        #delta
        $d = $recipe
            ->getDatePublication()
            ->diff($last_recipe->getDatePublication());

        if ($d->y == 0 AND $d->m == 0 AND $d->h == 0 AND $d->i == 0 AND
            $d->s < $this->insertion_limit_time) {
            return False;
        }
        else {
            return True;
        }
    }
}
