PlanificateurCourses
====================

A Symfony project created on June 15, 2017, 10:34 pm.

# # Amélioration pour la version 2.0:
- ajouter filtre User et Categories à findByOption pour les recettes.

## En vrac:

- améliorer le getGroupedIngredientList de l'entity ShoppingList !!! Elle est très moche il doit y a voir un moyen plus simple de faire un objet qui soit facilement utilisable par twig.
- mettre à jour le schema uml...
- améliorer la création d'un compte (pour l'instant c'est moche, ca marche mais ca renvoit plusieurs fois vers l'accueil alors qu'on s'attend à être renvoyé directement dans l'espace membre).
- frontend améliorer le rendu des smallView recipe en small device sur la page view.
- refaire un datafixtures (avec des users pour shoppingList, recipe notamment !)
- /login : améliorer l'incrustation du login en haut + améliorer le contenu du Jumbotron
- /home : ajouter des éléments (ex: "mes dernières recettes ajoutés", "mes dernières courses")
- pagination recipe/index.html.twig
