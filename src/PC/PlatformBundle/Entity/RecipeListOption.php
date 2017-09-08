<?php

namespace PC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecipeListOption
 *
 * @ORM\Table(name="recipe_list_option")
 * @ORM\Entity(repositoryClass="PC\PlatformBundle\Repository\RecipeListOptionRepository")
 */
class RecipeListOption extends RecipeOption
{
    /**
     * @var string
     *
     * @ORM\Column(name="keyword", type="string", length=255, nullable=true)
     */
    private $keyword;

    /**
     * @ORM\ManyToMany(targetEntity="PC\PlatformBundle\Entity\Category", cascade={"persist"})
     * @ORM\JoinTable(name="pc_recipelistoption_category")
     */
    protected $categories;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set keyword
     *
     * @param string $keyword
     *
     * @return RecipeListOption
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;

        return $this;
    }

    /**
     * Get keyword
     *
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
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
     * @return RecipeListOption
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
     * @return RecipeListOption
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
     * @return RecipeListOption
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
     * @return RecipeListOption
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
     * Set bestRating
     *
     * @param boolean $bestRating
     *
     * @return RecipeListOption
     */
    public function setBestRating($bestRating)
    {
        $this->bestRating = $bestRating;

        return $this;
    }

    /**
     * Get bestRating
     *
     * @return boolean
     */
    public function getBestRating()
    {
        return $this->bestRating;
    }

    /**
     * Add category
     *
     * @param \PC\PlatformBundle\Entity\Category $category
     *
     * @return RecipeListOption
     */
    public function addCategory(\PC\PlatformBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \PC\PlatformBundle\Entity\Category $category
     */
    public function removeCategory(\PC\PlatformBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return RecipeListOption
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
