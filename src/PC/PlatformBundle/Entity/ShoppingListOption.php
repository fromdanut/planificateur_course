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
     * @var bool
     *
     * @ORM\Column(name="lunch", type="boolean")
     */
    private $lunch;

    /**
     * @var bool
     *
     * @ORM\Column(name="dinner", type="boolean")
     */
    private $dinner;

    /**
     * @var bool
     *
     * @ORM\Column(name="we", type="boolean")
     */
    private $we;

    /**
     * @ORM\ManyToMany(targetEntity="PC\PlatformBundle\Entity\Category", cascade={"persist"})
     * @ORM\JoinTable(name="pc_shoppinglistoption_category")
     */
    protected $styles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->styles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set lunch
     *
     * @param boolean $lunch
     *
     * @return ShoppingListOption
     */
    public function setLunch($lunch)
    {
        $this->lunch = $lunch;

        return $this;
    }

    /**
     * Get lunch
     *
     * @return boolean
     */
    public function getLunch()
    {
        return $this->lunch;
    }

    /**
     * Set dinner
     *
     * @param boolean $dinner
     *
     * @return ShoppingListOption
     */
    public function setDinner($dinner)
    {
        $this->dinner = $dinner;

        return $this;
    }

    /**
     * Get dinner
     *
     * @return boolean
     */
    public function getDinner()
    {
        return $this->dinner;
    }

    /**
     * Set we
     *
     * @param boolean $we
     *
     * @return ShoppingListOption
     */
    public function setWe($we)
    {
        $this->we = $we;

        return $this;
    }

    /**
     * Get we
     *
     * @return boolean
     */
    public function getWe()
    {
        return $this->we;
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

    /*
     * return int
     * Cacule le nb de recette en fonction de lunch, dinner, we.
     */
    public function getNbMeal()
    {
        $nb = 0;
        if ($this->getLunch()) {
            if ($this->getWe()) { $nb += 7; }
            else { $nb += 5; }
        }
        if ($this->getDinner()) {
            if ($this->getWe()) { $nb += 7; }
            else { $nb += 5;}
        }
        return $nb;
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
}
