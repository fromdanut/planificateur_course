<?php

namespace PC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShoppingList
 *
 * @ORM\Table(name="shopping_list")
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

    /*
        Fonction qui retourne la liste des courses en fonctions de la liste de recette.
        Génère une associative array :
            $shoppingList = array( 'fraise' => array( "quantity" => 12,
                                                      "price" => 3,
                                                      "unit" => kg,
                                                      "name" => "fraise"
                                                  ),
                                    'pomme' => array(...),
                                )
    */

    public function getShoppingList()
    {
        $shoppingList = array();
        foreach ($this->getRecipes() as $recipe) {
            foreach($recipe->getRecipeIngredients() as $recipeIngredient) {
                $ingredient = $recipeIngredient->getIngredient();
                // Si l'ingrédient est déjà dans la liste on se contente d'incrémenter la quantité.
                if (array_key_exists($ingredient->getName(), $shoppingList)) {
                    $shoppingList[$ingredient->getName()]['quantity'] += $recipeIngredient->getQuantity();
                }
                // Si c'est la première occurence pour un ingrédient, on l'ajoute à la shoppingList.
                else {
                    $shoppingList[$ingredient->getName()] = array(
                        "name"     => $ingredient->getName(),
                        "quantity" => $recipeIngredient->getQuantity(),
                        "price"    => $ingredient->getPrice(),
                        "unit"     => $ingredient->getUnit()
                    );
                }
            }
        }

        return $shoppingList;
    }
}
