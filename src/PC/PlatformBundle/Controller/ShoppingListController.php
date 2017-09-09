<?php

namespace PC\PlatformBundle\Controller;

use PC\PlatformBundle\Form\ShoppingListOptionType;
use PC\PlatformBundle\Form\ShoppingListType;
use PC\PlatformBundle\Entity\Recipe;
use PC\PlatformBundle\Entity\ShoppingList;
use PC\PlatformBundle\Entity\ShoppingListOption;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class ShoppingListController extends Controller
{
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function viewAction(Request $request)
    {
        $shoppingList = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('PCPlatformBundle:ShoppingList')
            ->findWithAllFeatures($this->getUser());

        // The first time the user hasn't yet a shoppingList.
        if ($shoppingList === null) {
            $request->getSession()->getFlashBag()->add('notice', 'Vous n\'avez pas encore de liste de courses, créez en une !');
            return $this->redirectToRoute('pc_platform_shoppinglistoption_edit');
        }

        $shoppingListOption = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('PCPlatformBundle:ShoppingListOption')
            ->findOneBy(array('user' => $this->getUser()));

        return $this->render('PCPlatformBundle:ShoppingList:view.html.twig', array(
            'shoppingList'       => $shoppingList,
            'shoppingListOption' => $shoppingListOption,
            'recipes'            => $shoppingList->getRecipes()
        ));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // Get the ShoppingListOption of the current user.
        $shoppingListOption = $em
            ->getRepository('PCPlatformBundle:ShoppingListOption')
            ->findOneBy(array('user' => $this->getUser()));

        $shoppingList = $em
            ->getRepository('PCPlatformBundle:ShoppingList')
            ->findOneBy(array('user' => $this->getUser()));

        // Case where the user create his first shoppingList.
        if ($shoppingList === null) {
            $shoppingList = new ShoppingList();
            $shoppingList->setUser($this->getUser());
        }

        // Remove all recipe from this shoppingList.
        foreach ($shoppingList->getRecipes() as $recipe) {
            $shoppingList->removeRecipe($recipe);
        }

        // Create a shoppingList from options.
        $recipes = $em
            ->getRepository('PCPlatformBundle:Recipe')
            ->findByOption($shoppingListOption);

        foreach ($recipes as $recipe) {
            $shoppingList->addRecipe($recipe);
        }

        $em->persist($shoppingList);
        $em->flush();

        return $this->redirectToRoute('pc_platform_shoppinglist_view');
    }

    /**
     * Add a recipe to the shoppingList.
     * @Security("has_role('ROLE_USER')")
     * @ParamConverter("recipe", options={"mapping": {"id": "id"}})
     */
    public function addRecipeAction(Request $request, Recipe $recipe)
    {

        $em = $this->getDoctrine()->getManager();
        $shoppingList = $em
            ->getRepository('PCPlatformBundle:ShoppingList')
            ->findOneBy(array('user' => $this->getUser()->getId()));
        // A user may not have a shopping list, if so he is redirected to edit it.
        if ($shoppingList === null) {
            $request->getSession()->getFlashBag()->add('notice', 'Impossible d\'ajouter une recette à votre liste de courses car vous n\'en n\'avez pas encore. Créez en une ici.');
            return $this->redirectToRoute('pc_platform_shoppinglistoption_edit');
        }

        if ($recipe === null) {
            throw new NotFoundHttpException('Cette recette n\'existe pas impossible de l\'ajouter !');
        }

        // A user can't add a recipe that is already in the shoppingList.
        foreach ($shoppingList->getRecipes() as $recipeSelected) {
            if($recipe === $recipeSelected) {
                throw new NotAcceptableHttpException('Vous avez déjà ajouté cette recette à votre liste de course ! Vous n\'allez pas manger que des ' . $recipe->getName());
            }
        }

        $shoppingList->addRecipe($recipe);
        $em->flush();

        return $this->redirectToRoute('pc_platform_shoppinglist_view');
    }


    /**
     * Remove a recipe of the shoppingList.
     * @Security("has_role('ROLE_USER')")
     * @ParamConverter("recipe", options={"mapping": {"id": "id"}})
     */
    public function removeRecipeAction(Recipe $recipe)
    {

        $em = $this->getDoctrine()->getManager();
        $shoppingList = $em
            ->getRepository('PCPlatformBundle:ShoppingList')
            ->findOneBy(array('user' => $this->getUser()->getId()));

        if ($recipe === null) {
            throw new NotFoundHttpException('Cette recette n\'existe pas impossible de l\'enlever de la shoppinglist !');
        }

        $shoppingList->removeRecipe($recipe);
        $em->flush();

        return $this->redirectToRoute('pc_platform_shoppinglist_view');
    }

    /**
     * When the user is doing his shopping.
     * @Security("has_role('ROLE_USER')")
     */
    public function shoppingAction() {

    }
}
