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

    public function viewAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('PCPlatformBundle:ShoppingList');
        $shoppingList = $repo->findOnlyOne();

        return $this->render('PCPlatformBundle:ShoppingList:view.html.twig', array(
            'shoppingList' => $shoppingList,
        ));
    }

    public function addAction(Request $request)
    {
        // Récupère une ShoppingListOption arbitrairement, plus tard il faudra chercher celle de l'utilisateur...
        $shoppingListOption = $this
                                ->getDoctrine()
                                ->getManager()
                                ->getRepository('PCPlatformBundle:ShoppingListOption')
                                ->findOneBy(array());

        // Récupère une liste de recette en fonction de la shoppingListOption.
        $recipes = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('PCPlatformBundle:Recipe')
                    ->findByShoppingListOption(
                        $shoppingListOption->getQuick()
                    );

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
            $request->getSession()->getFlashBag()->add('notice', 'Liste de courses enregistrée.');

            return $this->render('PCPlatformBundle:ShoppingList:view.html.twig', array(
                                    'shoppingList' => $shoppingList,
                                    'debug' => count($shoppingList)
                                ));
        }

        return $this->render('PCPlatformBundle:ShoppingList:add.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    public function optionViewAction(Request $request)
    {
        $shoppingListOption = new ShoppingListOption();
        $form = $this->get('form.factory')->create(ShoppingListOptionType::class, $shoppingListOption);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // set date to now.
            $shoppingListOption->setDate(new \DateTime());

            $em->persist($shoppingListOption);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Options enregistrés.');

        }

        return $this->render('PCPlatformBundle:ShoppingList:optionView.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
