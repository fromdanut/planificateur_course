<?php

namespace PC\PlatformBundle\Controller;

use PC\PlatformBundle\Form\IngredientType;

use PC\PlatformBundle\Entity\Ingredient;
use PC\PlatformBundle\Entity\Unit;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class IngredientController extends Controller
{
    /**
     * @Security("has_role('ROLE_USER')")
     */

    public function addAction(Request $request)
    {
        $ingredient = new Ingredient();
        $form = $this->get('form.factory')->create(IngredientType::class, $ingredient);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($ingredient);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Nouvel ingrédient enregistré : '.$ingredient->getName());

            return $this->redirectToRoute('pc_platform_ingredient_add');
            }

        return $this->render('PCPlatformBundle:Ingredient:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
