<?php

namespace PC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShoppingListOption
 *
 * @ORM\Table(name="shopping_list_option")
 * @ORM\Entity(repositoryClass="PC\PlatformBundle\Repository\ShoppingListOptionRepository")
 */
class ShoppingListOption extends RecipeOption
{

    /**
     * @ORM\ManyToMany(targetEntity="PC\PlatformBundle\Entity\Category", cascade={"persist"})
     * @ORM\JoinTable(name="pc_shoppinglistoption_category")
     */
    protected $styles;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_meal", type="integer")
     */
    private $nbMeal;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->styles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set eco
     *
     * @param boolean $eco
     *
     * @return ShoppingListOption
     */
    public function setEco($eco)
    {
        $this->eco = $eco;

        return $this;
    }

    /**
     * Get eco
     *
     * @return boolean
     */
    public function getEco()
    {
        return $this->eco;
    }

    /**
     * Set quick
     *
     * @param boolean $quick
     *
     * @return ShoppingListOption
     */
    public function setQuick($quick)
    {
        $this->quick = $quick;

        return $this;
    }

    /**
     * Get quick
     *
     * @return boolean
     */
    public function getQuick()
    {
        return $this->quick;
    }

    /**
     * Set diet
     *
     * @param boolean $diet
     *
     * @return ShoppingListOption
     */
    public function setDiet($diet)
    {
        $this->diet = $diet;

        return $this;
    }

    /**
     * Get diet
     *
     * @return boolean
     */
    public function getDiet()
    {
        return $this->diet;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     *
     * @return ShoppingListOption
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Add style
     *
     * @param \PC\PlatformBundle\Entity\Category $style
     *
     * @return ShoppingListOption
     */
    public function addStyle(\PC\PlatformBundle\Entity\Category $style)
    {
        $this->styles[] = $style;

        return $this;
    }

    /**
     * Remove style
     *
     * @param \PC\PlatformBundle\Entity\Category $style
     */
    public function removeStyle(\PC\PlatformBundle\Entity\Category $style)
    {
        $this->styles->removeElement($style);
    }

    /**
     * Get styles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStyles()
    {
        return $this->styles;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return ShoppingListOption
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set nbMeal
     *
     * @param integer $nbMeal
     *
     * @return ShoppingListOption
     */
    public function setNbMeal($nbMeal)
    {
        $this->nbMeal = $nbMeal;

        return $this;
    }

    /**
     * Get nbMeal
     *
     * @return integer
     */
    public function getNbMeal()
    {
        return $this->nbMeal;
    }
}
