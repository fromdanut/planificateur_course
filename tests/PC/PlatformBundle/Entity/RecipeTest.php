<?php

namespace Tests\PC\PlatformBundle\Entity;

use PHPUnit\Framework\TestCase;
use PC\PlatformBundle\Entity\Recipe;
use PC\PlatformBundle\Entity\Ingredient;
use PC\PlatformBundle\Entity\RecipeIngredient;

class RecipeTest extends TestCase
{
    public function testComputePrice()
    {
        // Create 2 ingredients
        $ing1 = new Ingredient();
        $ing1->setPrice(20);
        $ing2 = new Ingredient();
        $ing2->setPrice(5);

        // Create recipeIngredients with ingredients
        $rIng1 = new RecipeIngredient();
        $rIng1->setIngredient($ing1)->setQuantity(3);
        $rIng2 = new RecipeIngredient();
        $rIng2->setIngredient($ing2)->setQuantity(2);

        // Create the recipe and add the recipeIngredients.
        $recipe = new Recipe();
        $recipe->addRecipeIngredient($rIng1);
        $recipe->addRecipeIngredient($rIng2);

        // Assert total price is 70 (3*20 + 2*5)
        $this->assertSame(70, $recipe->computePrice());
    }

    public function testValidIsSetToFalseByDefault()
    {
        // Create a single ingredient and recipe ingredient.
        $ing = new Ingredient();
        $ing->setPrice(10);
        $rIng = new RecipeIngredient();
        $rIng->setIngredient($ing)->setQuantity(2);
        // Add it to a new recipe
        $recipe = new Recipe();
        $recipe->addRecipeIngredient($rIng);

        $this->assertFalse($recipe->getValid());
    }

}
?>
