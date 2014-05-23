/**
 * Created by lukas on 11/05/14.
 */

var timers = {};
var st_done = 0;

$(function() {
    var recipe_id = $("#make-recipe").data('recipe-id');
    var first_img = 1;
    var last_img = 4;
    var random_img = Math.floor(Math.random() * (last_img - first_img + 1)) + first_img;

    var bg_image = '/assets/images/make-step-bg-' + random_img + '.jpg';
    $('body').css('background','url('+bg_image+') top center fixed').addClass('make-food-bg');
    loadSteps(recipe_id);

    clockWork();
    updateMakingStepsClocks();
});

// Mygtukas "Baigti"
$('#currently-making-steps .steps-container').on('click','.control-button',function(e) {
    e.preventDefault();
    var step_id    = $(this).data('step-id');
    var recipe_id  = $("#make-recipe").data('recipe-id');
    var step_count = $("#progress-bar-span").data('steps-count');
    endStep(step_id, recipe_id, step_count);
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
            var queue_block = $('#currently-making-steps .steps-container');
            queue_block.append(data).children(':last').hide().fadeIn(500).find('.recipe-step-timepanel img').tooltipster({
                animation: 'fade',
                delay: 200,
                theme: 'tooltipster-light',
                touchDevices: false,
                trigger: 'hover'
            });
            checkMakingStepsEmpty();
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
}

function endStep(step_id, recipe_id, step_count) {
    var curr_step = $('#currently-making-steps .steps-container div[data-step-id="'+step_id+'"]');
    curr_step.fadeOut(500);
    setTimeout(function() {
        curr_step.remove();
        loadSteps(recipe_id, step_id, timers[step_id]);
    }, 500);

    delete timers[step_id];
    updateProgressBar(step_count);
    checkMakingStepsEmpty();
}

function checkMakingStepsEmpty() {
    var st_container = $('#currently-making-steps .steps-container');
    st_container.find('.no-steps').remove();
    if(st_container.is(':empty')) {
        st_container.html('<div class="no-steps">Šiuo metu ruošiamų žingsnių nėra.</div>');
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