Planificateur de courses
========================

A Symfony project created on June 15, 2017, 10:34 pm.

# Fonctionnement

Ce site permet de stocker des recettes de cuisine, à partir desquelles il va générer une liste de course.

On peut donc ajouter des ingrédients, des recettes, les sélectionner et enfin exporter une liste de courses.

A voir sur le [site](www.fromdanut.hd.free.fr/pc)

# Amélioration prévue pour la version suivante :
- lien pour envoyer la liste de course.
- ajouter filtre User et Categories à findByOption pour les recettes.
- version bilingue.
- ajouter slug à recipe et l'utiliser dans les url.
- ajouter un bouton "supprimer tous les filtres".
- faire en sorte de pouvoir ajouter plusieurs fois la meme recette à la shopping list.
- faire la méthode findSuggestionsWithImageAndCat du RecipeRepository.


## En vrac:

- ajouter sécutité sur l'ajout d'ingrédient.
- informer l'utilisateur sur la procédure à suivre s'il ne trouve pas son ingrédient (rediriger vers ingredient_add)
-
