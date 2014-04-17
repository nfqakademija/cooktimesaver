$(function () {
    var time_input = $('.time-input');

    var specialKeys = new Array();
    specialKeys.push(8); // Backspace
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

    $('#search-results-container').on('click','.result-title a',function (e) {
        e.preventDefault();
        var recipe_id = $(this).data('recipe-id');
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
    });
});

function updateSearchResults(hours, minutes) {
    var result_container = $('#search-results-container');
    result_container.append('<div class="search-ajax-loading"></div>');
    $.ajax({
        type: "POST",
        url: "search_results/"+hours+"/"+minutes,
        data: '',
        cache: false,
        success: function (data) {

            result_container.html(data);
        }
    });
}

$('#search-button').click(function(e) {
    e.preventDefault();
    var hrs = $('.time-chooser-hours input').val();
    var mins = $('.time-chooser-mins input').val();
    updateSearchResults(hrs, mins);
});