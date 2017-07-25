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
        $shoppingListOption = $this
                                ->getDoctrine()
                                ->getManager()
                                ->getRepository('PCPlatformBundle:ShoppingListOption')
                                ->findOneBy(array('user' => $this->getUser()));

        // Create a new shoppingListOption if the user hasn't one yet.
        if ($shoppingListOption === null) {
            $shoppingListOption = new ShoppingListOption();
            $shoppingListOption->setUser($this->getUser());
        }

        $form = $this->get('form.factory')->create(ShoppingListOptionType::class, $shoppingListOption);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // Update the ShoppingListOption of the user.
            $em->persist($shoppingListOption);
            $em->flush();

            return $this->redirectToRoute('pc_platform_shoppinglist_add');

        }
        return $this->render('PCPlatformBundle:ShoppingListOption:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
