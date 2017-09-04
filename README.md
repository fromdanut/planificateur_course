Planificateur de courses
========================

A Symfony project created on June 15, 2017, 10:34 pm.

## Presentation :

It's a "marmiton" like website. User can stock/create/edit recipes and ingredients. Plus, the user can create a shopping list from a list of recipes. The shopping list is ordered by ingredients (with total price).

See the result on [website](https://fromdanut.hd.free.fr/pc)

## Improvement for next version :

- add a service to send the shopping list via mail.
- add a User and Categories filter for recipe search.
- translate in english.
- use slug for recipe instead of recipe number.
- add a button remove all filter in the recipe search menu.
- add an attribute 'number of preson' in recipe entity.


## 1rst test

- faire la bdd pour les ingrédients... (ne pas laisser les utilisateurs faie ça)
- recette add :
    - pas de alt (automatiquement écrire le nom de la recette)
    - ne pas limiter à 500 char pour description longue (Préparation) et augmenter la taille par défault !
    - pas de minimum pour description courte (min 10)
    -
- traduire shopping list en "liste de course"
- dans menu modifier : ajouter à la liste -> ajouter à la liste de courses.
- index recipe trié par date création desc
- enlever mail (rajouter un mail automatiquement si nécessaire).
- ajouter author dans widget_small_view.
- modifier "save" dans les formulaire par "chercher".
- dernière pagination -> rendre non-clickable !
- modifier "rating" -> "note" + ajouter js pour les étoiles du rating.
- mettre le login dans un conteneur ! (pb d'affichage pour l'isntant).
