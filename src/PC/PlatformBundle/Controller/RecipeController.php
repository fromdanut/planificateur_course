<?php

namespace PC\PlatformBundle\Controller;

use PC\PlatformBundle\Form\RecipeType;
use PC\PlatformBundle\Form\RecipeListOptionType;
use PC\PlatformBundle\Entity\Recipe;
use PC\PlatformBundle\Entity\RecipeListOption;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class RecipeController extends Controller
{
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction(Request $request, $page)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $option = $em
            ->getRepository('PCPlatformBundle:RecipeListOption')
            ->findOneByUser($user);

        // case the user hasn't yet a RecipeListOption, create a new one.
        if ($option === null) {
            $option = new RecipeListOption();
            $option->setUser($user);
        }

        $form = $this->get('form.factory')->create(RecipeListOptionType::class, $option);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($option);
            $em->flush();
            $page = 1; // Always returns the first page.
        }

        // use a parameter to get the nb of recipe per page.
        $nbPerPage = $this->container->getParameter('nb_recipe_per_page_index');

        // Find recipe by options.
        $recipeRepository = $em->getRepository('PCPlatformBundle:Recipe');
        $recipes = $recipeRepository->findByOptionPaginated($option, $page, $nbPerPage);

        // compute the nb of page, at least 1.
        $nbPages = (count($recipes) == 0) ? 1 : ceil(count($recipes) / $nbPerPage);

        // return 404 error if the page doesn't exist.
        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        return $this->render('PCPlatformBundle:Recipe:index.html.twig', array(
             'recipes'     => $recipes,
             'form'        => $form->createView(),
             'nbPages'     => $nbPages,
             'page'        => $page,
          ));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function viewAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $recipeRepo = $em->getRepository('PCPlatformBundle:Recipe');
        $recipe = $recipeRepo->findOneWithImageCatAndIngredients($slug);

        if (null === $recipe) {
            throw new NotFoundHttpException('Recette "'.$slug.'" inexistante.');
        }

        $nb_sug = $this->getParameter('nb_small_recipe_view_menu');
        $suggestions = $recipeRepo->findWithImageAndCat($nb_sug);

        // Check if the recipe is in the shopping list of the user (to enable/disable the "retire" button)
        $shoppingListRepo = $em->getRepository('PCPlatformBundle:ShoppingList');
        $isInUserShoppingList = $shoppingListRepo->findIfRecipeIsInList($recipe, $this->getUser());

        return $this->render('PCPlatformBundle:Recipe:view.html.twig', array(
            'recipe' => $recipe,
            'suggestions' => $suggestions,
            'isInUserShoppingList' => $isInUserShoppingList
        ));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function addAction(Request $request)
    {
        $recipe = new Recipe();
        $form = $this->get('form.factory')->create(RecipeType::class, $recipe);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $antispam = $this->container->get('pc_platform.antispam');
            $nbMaxIngredient = $this->getParameter('nb_max_ingredient');

            // if not spam and not with too many ingredient
            if (!$antispam->isSpam($recipe) && count($recipe->getRecipeIngredients()) < $nbMaxIngredient )
            {
                foreach ($recipe->getRecipeIngredients() as $recipeIngredient) {
                    $recipeIngredient->setRecipe($recipe);
                }
                $recipe->setUser($this->getUser());
                // alt is set to recipe's name.
                $recipe->getImage()->setAlt($recipe->getName());
                // Add 20 first char from long description to short description if empty.
                if (strlen($recipe->getShortDescription()) == 0) {
                    $recipe->setShortDescription(substr($recipe->getLongDescription(), 0, 30) . "...");
                }
                $em->persist($recipe);
                $em->flush();

                // Use the moderation service to moderate the new recipe.
                $moderation = $this->container->get('pc_platform.moderation');
                $moderation->moderate($recipe);

                $request->getSession()->getFlashBag()->add('notice', 'Votre recette sera disponible après modération par l\'admin.');

                return $this->redirectToRoute('pc_platform_recipe_index');
            }

            $request->getSession()->getFlashBag()->add('notice', 'Attendre un peu avant d\'ajouter une recette.');
        }

        return $this->render('PCPlatformBundle:Recipe:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * Function used to moderate new recipes. It validates the url sended to
     * the admin by addAction.
     */
    public function moderateAction($sha, $id, $action)
    {
        $sha1ed_secret = sha1($this->container->getParameter('secret'));
        if ($sha == $sha1ed_secret) {

            $em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository('PCPlatformBundle:Recipe');
            $recipe = $repo->find($id);

            // Valide the recipe (enables it to be viewed on the siteweb)...
            if ($action == 'valide') {
                $recipe->setValid(true);
                $em->persist($recipe);
                // Redirect to the view of the moderated recipe
                $response = $this->forward('PCPlatformBundle:Recipe:view', array(
                    'slug'  => $recipe->getSlug()
                ));
            }
            // ...if the recipe is not valide it's removed from bdd.
            elseif ($action == 'delete') {
                $em->remove($recipe);
                $response = $this->redirectToRoute('pc_platform_recipe_index');
            }
            $em->flush();
        }
        else {
            throw new NotFoundHttpException("sha incorrect");
        }

        return $response;
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('PCPlatformBundle:Recipe');
        $recipe = $repo->find($id);

        // Check if the recipe exists.
        if (null === $recipe) {
            throw new NotFoundHttpException("La recette n°".$id." n'existe pas.");
        }

        $this->checkUser($recipe, $this->getUser(), "C'est pas cool d'essayer de supprimer les recettes des autres...");

        // Delete all recipeIngredients.
        foreach ($recipe->getRecipeIngredients() as $recipeIngredient) {
            $em->remove($recipeIngredient);
        }

        $em->remove($recipe);
        $em->flush();

        return $this->redirectToRoute('pc_platform_recipe_index');
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('PCPlatformBundle:Recipe');
        $recipe = $repo->find($id);

        if (null === $recipe) {
            throw new NotFoundHttpException("La recette n°".$id." n'existe pas.");
        }

        $this->checkUser($recipe, $this->getUser(), "Pas touche aux recettes des autres !");
        $form = $this->get('form.factory')->create(RecipeType::class, $recipe);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            foreach ($recipe->getRecipeIngredients() as $recipeIngredient) {
                $recipeIngredient->setRecipe($recipe);
            }


            $em->persist($recipe);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Recette modifiée.');
            return $this->redirectToRoute('pc_platform_view', array('slug' => $recipe->getSlug()));

        }

        return $this->render('PCPlatformBundle:Recipe:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    // Check if the author is the current authenficated user.
    private function checkUser($recipe, $user, $message) {
        $user = $this->getUser();
        if ($recipe->getUser() != $user) {
            throw new AccessDeniedException($message);
        }
    }
}
