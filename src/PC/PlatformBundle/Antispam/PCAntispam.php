<?php

// src/PC/PlatformBundle/Antispam/PCAntispam.php

namespace PC\PlatformBundle\Antispam;

use PC\PlatformBundle\Entity\Recipe;
use PC\PlatformBundle\Entity\Ingredient;

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
     * Check if a entity has been create less than X mn ago.
     * @param $recipe
     * @return bool
     */
    public function isSpam($entity)
    {
        // diff between last entity and the new one.
        $last_entity = $this->em
            ->getRepository(get_class($entity))
            ->findLast();

        $d = $entity
            ->getDatePublication()
            ->diff($last_entity->getDatePublication());

        // not enough time...
        if ($d->y == 0 && $d->m == 0 && $d->h == 0 && $d->i == 0 &&
            $d->s < $this->insertion_limit_time) {
            return True;
        }

        return False;
    }
}
