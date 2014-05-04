$(function () {

    var products = $('#have-in-fridge').val();

    if(products){
        $('.ingredients li').each(function(){
            var ingredientId = $(this).attr('id');
            if(products.split(',').indexOf(ingredientId) > -1){
                $(this).css("color", "green");
            }
        });
    }
});
