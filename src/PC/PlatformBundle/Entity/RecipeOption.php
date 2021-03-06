<?php

namespace PC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecipeOption
 *
 * @ORM\MappedSuperclass
 */
class RecipeOption
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="eco", type="boolean")
     */
    protected $eco = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="quick", type="boolean")
     */
    protected $quick = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="diet", type="boolean")
     */
    protected $diet = false;

    /**
     * @var int
     *
     * @ORM\Column(name="rating", type="integer")
     */
    protected $rating = 1;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $user;


}
