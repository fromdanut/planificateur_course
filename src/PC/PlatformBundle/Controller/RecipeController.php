<?php

namespace PC\PlatformBundle\Controller;

use PC\PlatformBundle\Form\RecipeType;
use PC\PlatformBundle\Entity\Recipe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class RecipeController extends Controller
{
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository('PCPlatformBundle:Recipe');
        $recipes = $repo->findAllWithImage();

        return $this->render('PCPlatformBundle:Recipe:list.html.twig',
                             array( 'recipes' => $recipes ));
    }

    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('PCPlatformBundle:Recipe');
        $recipe = $repo->find($id);

        if (null === $recipe) {
            throw new NotFoundHttpException('Recette n°"'.$id.'" inexistante.');

        }

        return $this->render('PCPlatformBundle:Recipe:view.html.twig',
                             array( 'recipe' => $recipe));
    }

    public function addAction(Request $request)
    {
        $recipe = new Recipe();
        $form = $this->get('form.factory')->create(RecipeType::class, $recipe);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($recipe);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Recette enregistrée.');

            return $this->redirectToRoute('pc_platform_view', array('id' => $recipe->getId()));
        }

        return $this->render('PCPlatformBundle:Recipe:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('PCPlatformBundle:Recipe');
        $recipe = $repo->find($id);
        if (null === $recipe) {
            throw new NotFoundHttpException("La recette n°".$id." n'existe pas.");
        }
        // supprimer l'ensemble des recipeIngredients
        foreach ($recipe->getRecipeIngredients() as $recipeIngredient) {
            $em->remove($recipeIngredient);
        }

        $em->remove($recipe);
        $em->flush();

        return $this->redirectToRoute('pc_platform_listRecipe');
    }

    public function editAction(Request $request, $id) {

        // récupère la recette
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('PCPlatformBundle:Recipe');
        $recipe = $repo->find($id);
        if (null === $recipe) {
            throw new NotFoundHttpException("La recette n°".$id." n'existe pas.");
        }

        // créé le formulaire
        $form = $this->get('form.factory')->create(RecipeType::class, $recipe);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($recipe);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Recette modifiée.');

            return $this->redirectToRoute('pc_platform_view', array('id' => $recipe->getId()));
        }

        return $this->render('PCPlatformBundle:Recipe:add.html.twig', array(
            'form' => $form->createView(),
        ));

    }
}
