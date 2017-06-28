<?php

namespace PC\PlatformBundle\Controller;

use PC\PlatformBundle\Form\RecipeType;
use PC\PlatformBundle\Form\RecipeListOptionType;
use PC\PlatformBundle\Entity\Recipe;
use PC\PlatformBundle\Entity\RecipeListOption;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class RecipeController extends Controller
{
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction(Request $request)
    {
        // Récupère l'utilisateur courant.
        $user = $this->getUser();

        // Créé l'entity manager et récupère l'option de recette de l'utilisateur.
        $em = $this->getDoctrine()->getManager();
        $option = $em
            ->getRepository('PCPlatformBundle:RecipeListOption')
            ->findOneByUser($user);

        // Si l'utilisateur n'avait pas déjà d'option de recette, en créer une nouvelle.
        if ($option === null) {
            $option = new RecipeListOption();
            $option->setUser($user);
        }

        // Créé le formulaire à partir d'$option.
        $form = $this->get('form.factory')->create(RecipeListOptionType::class, $option);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            // Persiste la nouvelle recipeListOption
            $em->persist($option);
            $em->flush();
        }

        // génère la liste de recipes à partir des options.
        $recipeRepository = $em->getRepository('PCPlatformBundle:Recipe');
        $recipes = $recipeRepository->findByOption($option);
        return $this->render('PCPlatformBundle:Recipe:index.html.twig', array(
             'recipes' => $recipes,
             'form' => $form->createView()
          ));
    }

    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('PCPlatformBundle:Recipe');
        $recipe = $repo->find($id);

        if (null === $recipe) {
            throw new NotFoundHttpException('Recette n°"'.$id.'" inexistante.');
        }

        // rechercher 3 recettes similaires pour les suggérer (affiche en small_view)
        $nb = 3; # a parametrer !
        $suggestions = $repo->findSuggestions($id, $nb);

        return $this->render('PCPlatformBundle:Recipe:view.html.twig', array(
            'recipe' => $recipe,
            'suggestions' => $suggestions,
        ));
    }

    public function addAction(Request $request)
    {
        $recipe = new Recipe();
        $form = $this->get('form.factory')->create(RecipeType::class, $recipe);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            foreach ($recipe->getRecipeIngredients() as $recipeIngredient) {
                $recipeIngredient->setRecipe($recipe);
            }
            $recipe->setUser($this->getUser());
            $em->persist($recipe);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Recette enregistrée.');

            return $this->redirectToRoute('pc_platform_view', array(
                'id' => $recipe->getId(),
            ));
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

        // Vérifie si la recette existe.
        if (null === $recipe) {
            throw new NotFoundHttpException("La recette n°".$id." n'existe pas.");
        }
        // Vérifie que l'auteur de la recette correspond au user authetifié.
        $this->checkUser($recipe, $this->getUser(), "C'est pas cool d'essayer de supprimer les recettes des autres...");

        // Supprime l'ensemble des recipeIngredients.
        foreach ($recipe->getRecipeIngredients() as $recipeIngredient) {
            $em->remove($recipeIngredient);
        }

        $em->remove($recipe);
        $em->flush();

        return $this->redirectToRoute('pc_platform_recipe_index');
    }

    public function editAction(Request $request, $id)
    {

        // récupère la recette
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('PCPlatformBundle:Recipe');
        $recipe = $repo->find($id);
        // Vérifie que la recette existe.
        if (null === $recipe) {
            throw new NotFoundHttpException("La recette n°".$id." n'existe pas.");
        }
        // Vérifie que l'auteur de la recette correspond au user authetifié.
        $this->checkUser($recipe, $this->getUser(), "Pas touche aux recettes des autres !");

        // créé le formulaire
        $form = $this->get('form.factory')->create(RecipeType::class, $recipe);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            foreach ($recipe->getRecipeIngredients() as $recipeIngredient) {
                $recipeIngredient->setRecipe($recipe);
            }

            $em->persist($recipe);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Recette modifiée.');

            return $this->redirectToRoute('pc_platform_view', array('id' => $recipe->getId()));

        }

        return $this->render('PCPlatformBundle:Recipe:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    /*
        Vérifie si un utilisateur est bien l'auteur d'une recette.
        Lève une erreur avec un message si ce n'est pas le cas.
    */
    public function checkUser($recipe, $user, $message) {
        $user = $this->getUser();
        if ($recipe->getUser() != $user) {
            throw new AccessDeniedHttpException($message);
        }
    }
    // Vérifie si l'utilisateur souhaitant effacer la recette en est l'auteur.


}
