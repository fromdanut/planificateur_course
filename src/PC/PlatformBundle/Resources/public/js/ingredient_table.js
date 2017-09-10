$(document).ready(function(){

    // Change le titre du tableau en "Ingredient à trouver"
    $('#ingredient-table div:first').text('Reste à trouver');

    /**
      * Efface la première partie du tableau et affiche un message
      * 'fin des courses' si tous les ingrédients sont dans le caddies.
      */

    // Stock le nombre d'ingrédients à acheter.
    var nb_ing = $('tr[class="ingredient-table-row"]').length;
    var nb_ing_in_caddie = 0;

    var shoppingIsOver = function() {
        if (nb_ing_in_caddie === nb_ing) {
            // Efface la permière partie du tableau avec la liste des ingrédients.
            $('#ingredient-table').hide();
            // Message de félicitation
            $('<img class="img-responsive" src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Toiletpapier_%28Gobran111%29.jpg/1024px-Toiletpapier_%28Gobran111%29.jpg">').appendTo($('#img-pq-container'));
            $('<p class="text-center">Bravo vous avez fini vos courses ! N\'oubliez pas le...</p>').insertAfter($('#ingredient-table'));
            //$('<img class="img-responsive" src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Toiletpapier_%28Gobran111%29.jpg/330px-Toiletpapier_%28Gobran111%29.jpg"></img>').after($('#ingredient-table div:first'));
        }
    }



    /**
      * Ajoute un span avec inscrit "rien" dans le caddie s'il est vide.
      */
    var checkCaddie = function() {
        var nb_item = $('#caddie > span').length;

        if (nb_item === 1) {
            $('#caddie_is_empty').show('fast');
        }
        else {
            // Efface le span 'rien', s'il existe.
            $('#caddie_is_empty').hide('fast');
        }
    }

    /*
        Ajoute la deuxième partie du tableau qui contiendra un caddie où
        l'ensemble des ingrédients trouvés seront stockés.
        Ajoute un span d'une couleur différente avec "Rien", pour mettre en
        avant la présence du caddie.
    */
    var caddie = '<div class="panel-heading text-center">Dans mon caddie</div>\
    <table class="table table-bordered table-striped table-condensed"><tbody><tr><td id="caddie">\
    <span id="caddie_is_empty" class="label label-warning ingredient-caddie">Rien</span>\
    </td></tr></tbody></table>';

    $(caddie).insertAfter('#ingredient-table table');

    /*
        Efface l'ingredient de la liste de courses et l'ajoute au caddie.
    */
    $('.ingredient-table-row').click(function(e){
        nb_ing_in_caddie += 1;              // Met à jour le compteur.
        e.preventDefault();
        $(this).fadeOut('fast');
        // Attrape le nom de l'ingrédient (correspond à son attribut id).
        var html = '<span class="label label-success ingredient-caddie">' +
        $(this).attr('id') + '<span class="glyphicon glyphicon-remove"></span></span>'
        // Créé l'élément span et ajoute le gestionnaire d'événement.
        var $span = $(html).click(function(e) {
            e.preventDefault();
            $(this).remove();
            var sel = '#' + $(this).text();  // l'id correspond au text du span.
            $(sel).fadeIn();                 // affiche l'élément dans le tableau.
            checkCaddie();
            nb_ing_in_caddie -= 1;           // Met à jour le compteur.
        });

        // Animation du span.
        $span.hide();                   // Cache le span.
        $('#caddie').append($span);     // Ajoute le span au caddie.
        $span.show('fast');             // Afficher le span.
        checkCaddie();
        shoppingIsOver();
    });

    checkCaddie();
});
