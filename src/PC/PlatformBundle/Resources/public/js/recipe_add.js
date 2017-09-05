/*
    Script repris du cours OpenClassRoom sur Symfony.
    1. Il permet à l'utilisateur d'ajouter des ingrédients lors de la création
    de la recette.
    2. Il permet également le chosen-select (qui permet de faire une recherche sur l'input d'ingrédient)
    3. Enfin on a le chosen-select multiple sur les catégories.
*/

$(document).ready(function() {
  // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
  var $container = $('div#pc_platformbundle_recipe_recipeIngredients');

  // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
  var index = $container.find(':input').length;

  // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
  $('#add_ingredient').click(function(e) {
    addIngredient($container);

    e.preventDefault(); // évite qu'un # apparaisse dans l'URL
    return false;
  });

  // On ajoute un premier champ automatiquement s'il n'en existe pas déjà un (cas d'une nouvelle annonce par exemple).
  if (index == 0) {
    addIngredient($container);
  } else {
    // S'il existe déjà des catégories, on ajoute un lien de suppression pour chacune d'entre elles
    $container.children('div').each(function() {
      addDeleteLink($(this));
    });
  }

  // La fonction qui ajoute un formulaire CategoryType
  function addIngredient($container) {
    // Dans le contenu de l'attribut « data-prototype », on remplace :
    // - le texte "__name__label__" qu'il contient par le label du champ
    // - le texte "__name__" qu'il contient par le numéro du champ
    var template = $container.attr('data-prototype')
      .replace(/__name__label__/g, 'Ingrédient n°' + (index+1))
      .replace(/__name__/g,  index)
    ;

    // On crée un objet jquery qui contient ce template
    var $prototype = $(template);

    // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
    addDeleteLink($prototype);

    // 2. Ajoute le chosen-select au select d'option ingrédient.
    var chosenSelect = $prototype.find('select[class="form-control"]');
    chosenSelect.prepend('<option value=""></option>');


    chosenSelect.chosen({
        no_results_text: "Oups, aucun ingrédient trouvé pour : ",
        allow_single_deselect: true,
        placeholder_text_single: "Choisir un ingrédient",
        width: "95%"
    });

    // Grosse bidouille pour afficher "Choisir votre ingrédient" en première option.
    var bidouille = chosenSelect.next().find('a[class="chosen-single chosen-single-with-deselect"]');
    bidouille.attr('class', 'chosen-single chosen-single-with-deselect chosen-default');
    bidouille.find('span').text("Choisir un ingrédient");


    // On ajoute le prototype modifié à la fin de la balise <div>
    $container.append($prototype);

    // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
    index++;
  }

  // La fonction qui ajoute un lien de suppression d'une catégorie
  function addDeleteLink($prototype) {
    // Création du lien
    var $deleteLink = $('<a href="#" style="margin-right:30px" class="btn btn-danger pull-right"><span class="glyphicon glyphicon-trash"></span></a>');

    // Ajout du lien
    $prototype.append($deleteLink);

    // Ajout du listener sur le clic du lien pour effectivement supprimer la catégorie
    $deleteLink.click(function(e) {
      $prototype.remove();

      e.preventDefault(); // évite qu'un # apparaisse dans l'URL
      return false;
    });
  }

  // 3. Ajoute l'option chosen-select multiple sur catégorie.
  var categorieSelect = $('label[for="pc_platformbundle_recipe_categories"]').next().children();
  //categorieSelect.prepend('<option value=""> </option>');
  categorieSelect.chosen({
      no_results_text: "Oups, aucune catégorie trouvée pour : ",
      placeholder_text_multiple: "Ajouter une catégorie",
  });
});
