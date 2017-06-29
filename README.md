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

## Amélioration par page (essentiellement du frontend):

- /login : améliorer l'incrustation du login en haut + améliorer le contenu du Jumbotron

- /home : ajouter des éléments ("mes dernières recettes ajoutés", "mes dernières courses")

- /recipes :
    - améliorer le formulaire : rating en nb d'étoile, diet/quick/eco sous forme de bouton on/off

- /shoppingListOption/editAction : Modifier l'affichage des options (liste dans des btn ?) + un bouton "créer une liste de recette".

    **---> réussir la transition entre ces deux étape, le redirectToRoute ne fonctionne pas mais manuellement on peut aller à l'url 'shoppingList/add'**

- /shoppingList/addShoppingListAction :
    - **Modifier l'affichage des recettes** -> en utilisant le viewList + des boutons (supprimer/modifier).
    - ajouter un bouton "voir ma liste de couses" qui update / ajoute si n'existe pas encore la shopping liste de l'utilisateur et redirige vers shoppingList/view.

- /shoppingList/view/{id}, affiche les recettes via viewList mais sans les boutons (supprimer/modifier car la liste est déjà créée). En dessous la liste des courses: sous forme de tableau groupé par cat d'ingrédient avec les sous-totaux.
