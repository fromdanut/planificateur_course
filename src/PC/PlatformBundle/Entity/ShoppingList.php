<?php

namespace PC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PC\PlatformBundle\Utility\IngredientList;

/**
 * ShoppingList
 *
 * @ORM\Table(name="shoppinglist")
 * @ORM\Entity(repositoryClass="PC\PlatformBundle\Repository\ShoppingListRepository")
 */
class ShoppingList
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
    * @ORM\ManyToMany(targetEntity="PC\PlatformBundle\Entity\Recipe", cascade={"persist"})
    * @ORM\JoinTable(name="pc_shoppingList_recipe")
    */
    private $recipes;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User")
     */
    protected $user;

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
     * Constructor
     */
    public function __construct()
    {
        $this->recipes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add recipe
     *
     * @param \PC\PlatformBundle\Entity\Recipe $recipe
     *
     * @return ShoppingList
     */
    public function addRecipe(\PC\PlatformBundle\Entity\Recipe $recipe)
    {
        $this->recipes[] = $recipe;

        return $this;
    }

    /**
     * Remove recipe
     *
     * @param \PC\PlatformBundle\Entity\Recipe $recipe
     */
    public function removeRecipe(\PC\PlatformBundle\Entity\Recipe $recipe)
    {
        $this->recipes->removeElement($recipe);
    }

    /**
     * Get recipes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecipes()
    {
        return $this->recipes;
    }

    /**
     * Get ingredients list
     *\Doctrine\Common\Collections\Collection
     * @return PC\PlatformBundle\Utility\IngredientList
     */
    public function getIngredientList()
    {
        $ingList = new IngredientList($this->getRecipes());
        return $ingList->getIngList();
    }

    public function getTotalPrice()
    {
        $ingList = $this->getIngredientList();
        $total = 0;
        foreach ($ingList as $cats) {
            foreach ($cats as $ing) {
                $total += $ing['quantity']*$ing['price'];
            }
        }

        return $total;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return ShoppingList
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
