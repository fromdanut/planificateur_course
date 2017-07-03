<?php
/*
    Cette entity fait le lien entre les recettes et les ingrédients (permet d'ajouter la quantité)
*/
namespace PC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecipeIngredient
 *
 * @ORM\Table(name="pc_recipe_ingredient")
 * @ORM\Entity(repositoryClass="PC\PlatformBundle\Repository\RecipeIngredientRepository")
 */
class RecipeIngredient
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
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", options={"unsigned"=true})
     */
    private $quantity;

    /**
    * @ORM\ManyToOne(targetEntity="PC\PlatformBundle\Entity\Recipe", inversedBy="recipeIngredients")
    * @ORM\JoinColumn(nullable=false)
    */
    private $recipe;

    /**
    * @ORM\ManyToOne(targetEntity="PC\PlatformBundle\Entity\Ingredient")
    * @ORM\JoinColumn(nullable=false)
    */
    private $ingredient;

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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return RecipeIngredient
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set recipe
     *
     * @param \PC\PlatformBundle\Entity\Recipe $recipe
     *
     * @return RecipeIngredient
     */
    public function setRecipe(\PC\PlatformBundle\Entity\Recipe $recipe)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get recipe
     *
     * @return \PC\PlatformBundle\Entity\Recipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Set ingredient
     *
     * @param \PC\PlatformBundle\Entity\Ingredient $ingredient
     *
     * @return RecipeIngredient
     */
    public function setIngredient(\PC\PlatformBundle\Entity\Ingredient $ingredient)
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    /**
     * Get ingredient
     *
     * @return \PC\PlatformBundle\Entity\Ingredient
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }
}
