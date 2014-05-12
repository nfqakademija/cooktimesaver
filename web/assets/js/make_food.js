/**
 * Created by lukas on 11/05/14.
 */

var timers = {};
var st_done = 0;

$(function() {

    var recipe_img = $("#make-recipe").data('recipe-image');
    var recipe_id = $("#make-recipe").data('recipe-id');

    $('body').css('background','url('+recipe_img+') top center fixed').addClass('make-food-bg');
    loadSteps(recipe_id);

    clockWork();
    updateMakingStepsClocks();
});

// Mygtukas "Pradeti"
$('#steps-queue .steps-container').on('click','.control-button',function(e) {
    e.preventDefault();
    var step_id = $(this).data('step-id');
    $(this).removeClass('btn-primary');
    $(this).addClass('btn-danger');
    $(this).text('Baigti');

    startStep(step_id);
});

// Mygtukas "Baigti"
$('#currently-making-steps .steps-container').on('click','.control-button',function(e) {
    e.preventDefault();
    var step_id = $(this).data('step-id');
    var recipe_id = $("#make-recipe").data('recipe-id');

    endStep(step_id, recipe_id);

});

// Užkraunami žingsniai pagal buvusio ID ir recepto ID
function loadSteps(recipe_id, step_id, time_spent) {
    if(step_id == undefined)
        step_id = '';

    var request_url = '../get_steps/'+recipe_id;

    if(step_id != '')
        request_url += '/' + step_id + '/' + time_spent;

    $.ajax({
        type: "GET",
        url: request_url,
        success: function (data) {
            var queue_block = $('#steps-queue .steps-container');
            queue_block.append(data).find('.panel-body')
                .stop().css("background-color", "#FFFED9")
                .animate({ backgroundColor: "#f7f8fa"}, 1500);
            checkMakingStepsEmpty();
            checkQueueStepsEmpty();
        }
    });
}

function startStep(step_id) {
    var curr_step = $('#steps-queue .steps-container div[data-step-id="'+step_id+'"]');
    var st_html = '<div class="col-md-6" data-step-id="'+step_id+'">';
    st_html += curr_step.html();
    st_html += '</div>';
    timers[step_id] = 0;

    var c_mst = $('#currently-making-steps .steps-container');
    //c_mst.find('.recipe-step-timepanel span').text('0 min.');
    c_mst.append(st_html).find('.recipe-step-timepanel span').text('0 min.').find('.panel-body').stop().css("background-color", "#FFFED9")
        .animate({ backgroundColor: "#f7f8fa"}, 1500);
    checkMakingStepsEmpty();
    curr_step.remove();
    checkQueueStepsEmpty();
}

function endStep(step_id, recipe_id) {
    var curr_step = $('#currently-making-steps .steps-container div[data-step-id="'+step_id+'"]');
    curr_step.fadeOut(1000).remove();
    loadSteps(recipe_id, step_id, timers[step_id]);
    delete timers[step_id];
    updateProgressBar(5);
    checkMakingStepsEmpty();
}

function checkMakingStepsEmpty() {
    var st_container = $('#currently-making-steps .steps-container');
    st_container.find('.no-steps').remove();
    if(st_container.is(':empty')) {
        st_container.html('<div class="no-steps">Šiuo metu ruošiamų žingsnių nėra.</div>');
    }
}

function checkQueueStepsEmpty() {
    var st_container = $('#steps-queue .steps-container');
    st_container.find('.no-steps').remove();
    if(st_container.html().trim() == '') {
        st_container.html('<div class="no-steps">Tam kad galėtumėte pradėti kitus žingsnius, reikia baigti jau pradėtus.</div>');
    }
}

//Sukam laikrodukus:
function clockWork() {
    setTimeout(function () {
        for (var key in timers) {
            timers[key] += 1;
        }
        clockWork();
    }, 60000);
}

function updateMakingStepsClocks() {
    setTimeout(function() {
        for (var key in timers) {
            var curr_step = $('#currently-making-steps .steps-container div[data-step-id="' + key + '"]');
            curr_step.find('.recipe-step-timepanel span').text(timers[key] + ' min.');
        }
        updateMakingStepsClocks();
    }, 30000);
}

function updateProgressBar(st_count) {
    st_done++;
    var percentage = (st_done / st_count) * 100;
    $('#steps-progress .progress-line').animate({
        width: percentage + "%"
    }, 800 );
    $('.progress-row span').text(st_done + '/' + st_count);
}