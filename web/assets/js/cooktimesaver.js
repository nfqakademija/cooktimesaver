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

$('#search-button').click(function(e) {
    e.preventDefault();
    var hrs          = $('.time-chooser-hours input').val();
    var mins         = $('.time-chooser-mins input').val();
    var products     = $('#have-in-fridge').val();
    var antiProducts = $('#not-eating').val();
    updateSearchResults(hrs, mins, products, antiProducts);
});

function countDown(hours, mins, secs, container) {
    var time_left = hours * 3600 +  mins * 60 + secs;

    setTimeout(function() {
        time_left--;
        var hours_left = Math.floor(time_left / 3600);
        var mins_left = Math.floor(((time_left - hours_left * 60) / 60));
        var secs_left = time_left - hours_left * 3600 - mins_left * 60;

        var output_hours = hours_left;
        if(output_hours.toString().length == 1)
            output_hours = '0' + output_hours;

        var output_mins = mins_left;
        if(output_mins.toString().length == 1)
            output_mins = '0' + output_mins;

        var output_secs = secs_left;
        if(output_secs.toString().length == 1)
            output_secs = '0' + output_secs;

        container.html(output_hours + ':' + output_mins + ':' + output_secs);
        countDown(hours_left, mins_left, secs_left, container);

    }, 1000);
}

// Maisto gaminimas
$('#start-clock button').click(function(e) {
    e.preventDefault();
    $(this).hide();
    var countdown_cont = $('#start-clock h1 span');
    countDown(0, 20, 15, countdown_cont);
    countdown_cont.parent().show();
});