<?php

namespace PC\PlatformBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Ingredient
 *
 * @ORM\Table(name="ingredient")
 * @ORM\Entity(repositoryClass="PC\PlatformBundle\Repository\IngredientRepository")
 */
class Ingredient
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_publication", type="datetime")
     */
    private $datePublication;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\Length(max=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=5)
     * @Assert\Range(min=0, max=9999)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="calorie", type="integer")
     * @Assert\Range(min=0, max=9999)
     */
    private $calorie;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="PC\PlatformBundle\Entity\Unit", cascade={"persist"})
     */
     private $unit;

    /**
     *
     * @ORM\ManyToOne(targetEntity="PC\PlatformBundle\Entity\CategoryIngredient", cascade={"persist"})
     */
    private $category;

    /**
     * @Gedmo\Slug(fields={"name"}, updatable=false)
     * @ORM\Column(length=255, unique=true)
     */
    protected $slug;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->datePublication = new \DateTime();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Ingredient
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get name with unit between () -> 'fraise (g)', 'pomme (unité)', 'lait (ml)'
     *
     * @return string
     */
    public function getNameWithUnit()
    {
        $name = $this->getName();
        $unit = $this->getUnit()->getName();

        return $name . ' (' . $unit . ')';
    }



    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Ingredient
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set calorie
     *
     * @param integer $calorie
     *
     * @return Ingredient
     */
    public function setCalorie($calorie)
    {
        $this->calorie = $calorie;

        return $this;
    }

    /**
     * Get calorie
     *
     * @return int
     */
    public function getCalorie()
    {
        return $this->calorie;
    }

    /**
     * Set unit
     *
     * @param \PC\PlatformBundle\Entity\Unit $unit
     *
     * @return Ingredient
     */
    public function setUnit(\PC\PlatformBundle\Entity\Unit $unit = null)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return \PC\PlatformBundle\Entity\Unit
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set category
     *
     * @param \PC\PlatformBundle\Entity\CategoryIngredient $category
     *
     * @return Ingredient
     */
    public function setCategory(\PC\PlatformBundle\Entity\CategoryIngredient $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \PC\PlatformBundle\Entity\CategoryIngredient
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return Ingredient
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    /**
     * Get datePublication
     *
     * @return \DateTime
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Ingredient
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
