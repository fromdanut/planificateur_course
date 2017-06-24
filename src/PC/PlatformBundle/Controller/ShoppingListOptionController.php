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
        $shoppingListOption = new ShoppingListOption();
        $form = $this->get('form.factory')->create(ShoppingListOptionType::class, $shoppingListOption);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($shoppingListOption);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Options enregistrés.');

        }

        return $this->render('PCPlatformBundle:ShoppingListOption:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
