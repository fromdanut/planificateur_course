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
- add an attribute 'number of person' in recipe entity.


## 1rst test

- index recipe trié par date création desc : ne fonctionne pas voir https://openclassrooms.com/forum/sujet/symfony-3-order-by-error-paginator
- agrandir la bdd pour les ingrédients.
- qd l'utilisateur n'a pas encore crée de shopping list il y a un bug s'il appui sur 'ajouter aux courses' dans la vue d'une recette.
