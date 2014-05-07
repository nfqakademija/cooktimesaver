$(function () {
    var time_input = $('.time-input');

    var specialKeys = new Array();
    specialKeys.push(8, 13); // Backspace
    $(document).on('click', '.time-input', function () {
        this.select();
    });
    time_input.bind("keypress", function (e) {
        var keyCode = e.which ? e.which : e.keyCode;
        var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
        return ret;
    });
    time_input.bind("keyup", function () {
        var dhis = $(this);
        var value = parseInt(dhis.val());
        if ((value < 0) || (value > 59)) {
            dhis.val('00');
            this.select();
        }
    });

    time_input.focusout(function() {
        var val = $(this).val();
        if(val.length == 1)
            $(this).val('0' + val);
        else if(val.length == 0)
            $(this).val('00');
    });

    time_input.bind("paste", function () {
        return false;
    });

    time_input.bind("drop", function () {
        return false;
    });
});


$('body').on('click','#search-results-container .result',function (e) {
    e.preventDefault();
    var recipe_id = $(this).find('a').data('recipe-id');
    showRecipeDescription(recipe_id);
});

function showRecipeDescription(recipe_id) {
    $.ajax({
        type: "POST",
        url: "recipe_description/"+recipe_id,
        data: {id: recipe_id},
        success: function (data) {
            BootstrapDialog.show({
                title: 'Recepto aprašymas',
                message: data
            });
        }
    });
}

function updateSearchResults(hours, minutes, products, antiProducts) {
    var result_container = $('#search-results-container');
    result_container.append('<div class="search-ajax-loading"></div>');
    $.ajax({
        type: "POST",
        url: "search_results/"+hours+"/"+minutes,
        data: {products: products, antiProducts: antiProducts},
        cache: false,
        success: function (data) {
            result_container.html(data);
        }
    });
}

$('.searchpage-time-chooser input').on('keypress', function(e) {
    if(e.which == 13) {
        doUSR();
    }
});

$('#search-button').click(function(e) {
    e.preventDefault();
    doUSR();
});

$('#have-in-fridge, #not-eating, .time-chooser-hours input, .time-chooser-mins input').on("change", function(){
    doUSR();
});


function doUSR() {
    var hrs          = $('.time-chooser-hours input').val();
    var mins         = $('.time-chooser-mins input').val();
    var products     = $('#have-in-fridge').val();
    var antiProducts = $('#not-eating').val();
    updateSearchResults(hrs, mins, products, antiProducts);
}