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
            $ingList = array( 'fruis et légumes' => array(
                                                'fraise' => array(
                                                        "quantity" => 12,
                                                        "price" => 3,
                                                        "unit" => kg,
                                                        "name" => "fraise"
                                                        ),
                                                'pomme' => array(...),
                                            'produit laitiers' => array(...)
                                )
    */

    public function getGroupedIngredientList()
    {
        $ingList = array(); // ingList for groupedIngredientList
        // pour chaque recette.
        foreach ($this->getRecipes() as $recipe) {
            // pour chaque ingrédient de recette.
            foreach($recipe->getRecipeIngredients() as $recipeIngredient) {
                $ingredient = $recipeIngredient->getIngredient();
                $ingCat = $ingredient->getCategory()->getName();
                $ingName = $ingredient->getName();
                // Si la catégory de l'ingrédient est déjà renseignée dans la liste d'ingrédient.
                if (array_key_exists($ingCat, $ingList)) {
                    // Si l'ingrédient est déjà renseigné.
                    if (array_key_exists($ingName, $ingList[$ingCat])) {
                        // on rajoute la quantity du recipeIngredient.
                        $ingList[$ingCat][$ingName]['quantity'] += $recipeIngredient->getQuantity();
                    }
                    // Si c'est la première occurence pour cet ingrédient, on l'ajoute à la ingList.
                    else {
                        $ingList[$ingCat][$ingName] = array(
                            "name"     => $ingredient->getName(),
                            "quantity" => $recipeIngredient->getQuantity(),
                            "price"    => $ingredient->getPrice(),
                            "unit"     => $ingredient->getUnit(),
                        );
                    }
                }
                // Si c'est la première occurence pour cette catégory, on l'ajoute, avec l'ingrédient.
                else {
                    $ingList[$ingCat][$ingName] = array(
                        "name"     => $ingredient->getName(),
                        "quantity" => $recipeIngredient->getQuantity(),
                        "price"    => $ingredient->getPrice(),
                        "unit"     => $ingredient->getUnit(),
                    );
                }
            }
        }

        return $ingList;
    }
}
