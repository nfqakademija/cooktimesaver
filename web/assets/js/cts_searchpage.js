/**
 * Created by lukas on 08/05/14.
 */
$(function () {
    var hours = $('#search-page-hours-input').val();
    var mins = $('#search-page-mins-input').val();


    updateSearchResults(hours, mins);

    $('#have-in-fridge, #not-eating').select2({
        width: '210px',
        multiple: true,
        minimumInputLength: 2,
        ajax: {
            url: "ajax_autocomplete",
            dataType: 'json',
            data: function (term, page) {
                var products = $('#have-in-fridge').val();
                var antiProducts = $('#not-eating').val();
                return {
                    q: term,
                    excludedIds: products + ',' + antiProducts
                };
            },
            results: getFoodTag
        },
        formatResult: tagFormatResult,
        formatSelection: tagFormatSelection,
        dropdownCssClass: "bigdrop"
    });

    function tagFormatResult(food) {
        var markup = "<div class='food-title'>" + food.title + "</div>";
        return markup;
    }

    function tagFormatSelection(food) {
        return food.title;
    }

    function getFoodTag(data) {
        var foodTagResults = [];
        $.each(data, function (index, item) {
            foodTagResults.push({
                id: item.id,
                title: item.title
            });
        });
        return {
            results: foodTagResults
        };
    }
});