$(document).ready(function() {
    $('select[class*=".chosen"]').chosen({
        no_results_text: "Oups, aucune catégorie trouvée pour : ",
        placeholder_text_multiple: "catégorie",
    });
});
