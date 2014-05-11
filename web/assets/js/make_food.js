/**
 * Created by lukas on 11/05/14.
 */
$(function() {
    var recipe_img = $("#make-recipe").data('recipe-image');
    $('body').css('background','url('+recipe_img+') top center').addClass('make-food-bg');
});