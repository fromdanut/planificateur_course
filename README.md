PlanificateurCourses
====================

A Symfony project created on June 15, 2017, 10:34 pm.

# A faire:

## En vrac:

- améliorer le getGroupedIngredientList de l'entity ShoppingList !!! Elle est très moche il doit y a voir un moyen plus simple de faire un objet qui soit facilement utilisable par twig.
- rendre parametrable les valeurs des clauses where dans la méthode findByOption de RecipeRepository (via parametre dans l'espace membre)
- findByOption de RecipeRepository doit permettre de trier par catégorie (style).
- ajouter auteur à la recette et ajouter filtre User à findByOption (visible de le side d'index recipes)
- mettre à jour le schema uml...
- améliorer la création d'un compte (pour l'instant c'est moche, ca marche mais ca renvoit plusieurs fois vers l'accueil alors qu'on s'attend à être renvoyé directement dans l'espace membre).
- améliorer findSuggestions.
- frontend améliorer le rendu des smallView recipe en small device sur la page view.
- refaire un datafixtures (avec des users pour shoppingList, recipe notamment !)
- /login : améliorer l'incrustation du login en haut + améliorer le contenu du Jumbotron
- /home : ajouter des éléments (ex: "mes dernières recettes ajoutés", "mes dernières courses")
