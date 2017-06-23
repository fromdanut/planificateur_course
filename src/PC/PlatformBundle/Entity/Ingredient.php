<?php

namespace PC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=5)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="calorie", type="integer", nullable=true)
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
}
