$(document).ready(function() {
    // Add the chosen-select on left menu.
    $('select[class*=".chosen"]').chosen({
        no_results_text: "Oups, aucune catégorie trouvée pour : ",
        placeholder_text_multiple: "catégorie",
    });

    // Change color on hover on small recipe.
    $('div[class="row SmallRecipeContainer"]').mouseenter(function() {
        $(this).css('background-color', 'rgb(255,165,0)');
    })
    $('div[class="row SmallRecipeContainer"]').mouseleave(function() {
        $(this).css('background-color', '#485563');
    })

});
