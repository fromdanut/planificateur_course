<?php

namespace PC\PlatformBundle\Controller;

use PC\PlatformBundle\Form\ShoppingListOptionType;
use PC\PlatformBundle\Entity\ShoppingListOption;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class ShoppingListOptionController extends Controller
{
    public function editAction(Request $request)
    {
        // Récupère la ShoppingListOption de l'utilisateur.
        $shoppingListOption = $this
                                ->getDoctrine()
                                ->getManager()
                                ->getRepository('PCPlatformBundle:ShoppingListOption')
                                ->findOneBy(array('user' => $this->getUser()));

        // Créé une nouvelle liste si l'utilisateur n'en avait pas déjà une.
        if ($shoppingListOption === null) {
            $shoppingListOption = new ShoppingListOption();
            $shoppingListOption->setUser($this->getUser());
        }

        $form = $this->get('form.factory')->create(ShoppingListOptionType::class, $shoppingListOption);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // Update la ShoppingListOption de l'user.
            $em->persist($shoppingListOption);
            $em->flush();

            // Renvoie vers la création de liste de recette.
            $this->redirectToRoute('pc_platform_shoppinglist_add');

        }
        // Envoie le formulaire d'édition prérempli.
        return $this->render('PCPlatformBundle:ShoppingListOption:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
