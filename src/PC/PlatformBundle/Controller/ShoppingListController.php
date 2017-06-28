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


class ShoppingListController extends Controller
{

    public function viewAction($id)
    {
        $shoppingList = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('PCPlatformBundle:ShoppingList')
            ->findWithAllFeatures($id);

        return $this->render('PCPlatformBundle:ShoppingList:view.html.twig', array(
            'shoppingList' => $shoppingList,
        ));
    }
    /*
        Formulaire pour ajouter une shopping list sur laquelle on l'utilisateur
        ne voit uniquement que la liste des recettes (qu'il peut modifier).
    */
    public function addAction(Request $request)
    {
        // Récupère la ShoppingListOption de l'utilisateur.
        $shoppingListOption = $this
                                ->getDoctrine()
                                ->getManager()
                                ->getRepository('PCPlatformBundle:ShoppingListOption')
                                ->findOneBy(array('user' => $this->getUser()));

        // Génère la liste de recette en fonction de la shoppingListOption.
        $recipes = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('PCPlatformBundle:Recipe')
                    ->findByOption($shoppingListOption);

        // Créé une shoppingList à laquelle sont ajoutées les recettes.
        $shoppingList = new ShoppingList();
        foreach ($recipes as $recipe) {
            $shoppingList->addRecipe($recipe);
        }

        // Créé le formulaire à partir de la shoppingList.
        $form = $this->get('form.factory')->create(ShoppingListType::class, $shoppingList);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($shoppingList);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Nouvelle liste de courses enregistrées.');

            return $this->redirectToRoute('pc_platform_shoppinglist_view', array(
                                    'id' => $shoppingList->getId()
                                ));
        }

        return $this->render('PCPlatformBundle:ShoppingList:add.html.twig', array(
            'form' => $form->createView(),
            'shoppingListOption' => $shoppingListOption,
        ));
    }
}
