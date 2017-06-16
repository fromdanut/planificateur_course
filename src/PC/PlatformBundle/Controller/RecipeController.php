<?php

namespace PC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// Entities
use PC\PlatformBundle\Entity\Recipe;

class RecipeController extends Controller
{
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository('PCPlatformBundle:Recipe');
        $recipes = $repo->findAll();

        return $this->render('PCPlatformBundle:Default:list.html.twig',
                             array( 'recipes' => $recipes ));
    }

    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('PCPlatformBundle:Recipe');
        $recipe = $repo->find($id);

        return $this->render('PCPlatformBundle:Default:view.html.twig',
                             array( 'recipe' => $recipe));
    }
}
