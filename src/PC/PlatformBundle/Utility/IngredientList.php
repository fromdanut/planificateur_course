<?php

namespace PC\PlatformBundle\Utility;
/*
    Classe qui retourne la liste des courses en fonctions d'une liste de recette.
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
class IngredientList
{
    private $ingList = [];

    public function __construct($recipes)
    {
        $ingList = array();
        // pour chaque recette.
        foreach ($recipes as $recipe) {
            // pour chaque ingrédient de recette.
            foreach($recipe->getRecipeIngredients() as $recipeIngredient) {
                $ingredient = $recipeIngredient->getIngredient();
                $ingCat = $ingredient->getCategory()->getName();
                $ingName = $ingredient->getName();
                $ingSlug = $ingredient->getSlug();
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
                            "slug"     => $ingredient->getSlug(),
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
                        "slug"     => $ingredient->getSlug(),
                        "quantity" => $recipeIngredient->getQuantity(),
                        "price"    => $ingredient->getPrice(),
                        "unit"     => $ingredient->getUnit(),
                    );
                }
            }
        }

        $this->ingList = $ingList;
    }

    public function getIngList()
    {
        return $this->ingList;
    }
}
