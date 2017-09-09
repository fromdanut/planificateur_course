$(document).ready(function(){

    // Ajoute un conteneur id "caddie" avec l'ensemble des ingrédients déjà pris.
    $('#caddie-title').after('<div class="row">\
    <div class="col-xs-12"><div id="caddie"></div></div></div>');

    // Efface l'ingredient de la liste de courses et l'ajoute au caddie.
    $('.ingredient-table-row').click(function(e){
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
        });

        // Animation du span.
        $span.hide();                   // Cache le span.
        $('#caddie').append($span);     // Ajoute le span au caddie.
        $span.show('fast');             // Afficher le span.
    });

});
