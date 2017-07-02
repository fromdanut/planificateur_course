<?php

namespace PC\PlatformBundle\Repository;

/**
 * ShoppingListRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ShoppingListRepository extends \Doctrine\ORM\EntityRepository
{

    // Utilisé dans la view du ShoppingListController
    public function findWithAllFeatures($user)
    {
        $qb = $this
                ->createQueryBuilder('s')
                ->leftJoin('s.recipes', 'recipes')
                    ->addSelect('recipes')
                ->leftJoin('recipes.image', 'image')
                    ->addSelect('image')
                ->leftJoin('recipes.categories', 'recipeCategories')
                    ->addSelect('recipeCategories')
                ->leftJoin('recipes.recipeIngredients', 'recipeIngredients')
                    ->addSelect('recipeIngredients')
                ->leftJoin('recipeIngredients.ingredient', 'ingredient')
                    ->addSelect('ingredient')
                ->leftJoin('ingredient.category', 'catIngredient')
                    ->addSelect('catIngredient')
                ->leftJoin('ingredient.unit', 'unitIngredient')
                    ->addSelect('unitIngredient')
                ->where('s.user = :user')
                    ->setParameter('user', $user);
        return $qb
          ->getQuery()
          // La 1ere fois, l'utilisateur n'a pas encore de shoppingLinst
          ->getOneOrNullResult();
    }

}
