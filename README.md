PlanificateurCourses
====================

A Symfony project created on June 15, 2017, 10:34 pm.

# # Amélioration pour la version 2.0:
- ajouter filtre User et Categories à findByOption pour les recettes.
- version bilingue
- ajouter slug à recipe (et l'utiliser dans l'url pour view_recipe)
- ajouter un bouton "supprimer tous les filtres"
- faire en sorte de pouvoir ajouter plusieurs fois la meme recette à la shopping list.

## En vrac:

- améliorer le getGroupedIngredientList de l'entity ShoppingList !!! Elle est très moche il doit y a voir un moyen plus simple de faire un objet qui soit facilement utilisable par twig.
- améliorer la création d'un compte (pou l'instant c'est moche, ca marche mais ca renvoit plusieurs fois vers l'accueil alors qu'on s'attend à être renvoyé directement dans l'espace membre).
- refaire un datafixtures (avec des users pour shoppingList, recipe notamment !) https://symfony.com/doc/current/bundles/FOSUserBundle/overriding_templates.html
- /home : ajouter des éléments (ex: "mes dernières recettes ajoutés", "mes dernières courses")
