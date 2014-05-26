/**
 * Created by lukas on 11/05/14.
 */

var timers = {};
var st_done = 0;
var timer = 0;

$(function() {
    var recipe_id = $("#make-recipe").data('recipe-id');
    var first_img = 1;
    var last_img = 4;
    var random_img = Math.floor(Math.random() * (last_img - first_img + 1)) + first_img;

    var bg_image = '/assets/images/make-step-bg-' + random_img + '.jpg';
    $('body').css('background','url('+bg_image+') top center fixed').addClass('make-food-bg');
    loadSteps(recipe_id);

    clockWork();
    globalClock();
    updateMakingStepsClocks();
});

function recipeDone() {
    var st_cont = $('#make-recipe .container');
    st_cont.hide();
    st_cont.parent().find('.skanaus').fadeIn(600);
}

// Mygtukas "Baigti"
$('#currently-making-steps .steps-container').on('click','.control-button',function(e) {
    e.preventDefault();
    var step_id    = $(this).data('step-id');
    var recipe_id  = $("#make-recipe").data('recipe-id');
    var step_count = $("#progress-bar-span").data('steps-count');

    endStep(step_id, recipe_id, step_count);

    if(step_count == st_done)
        recipeDone();
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
    c_mst.append(st_html).find('.recipe-step-timepanel span').text('0 min.').find('.panel-body').stop().css("background-color", "#FFFED9")
        .animate({ backgroundColor: "#f7f8fa"}, 1500);
    curr_step.remove();
}

function endStep(step_id, recipe_id, step_count) {
    var curr_step = $('#currently-making-steps .steps-container div[data-step-id="'+step_id+'"]');
    curr_step.fadeOut(500);
    setTimeout(function() {
        curr_step.remove();
        loadSteps(recipe_id, step_id, timer);
    }, 500);

    console.log(timer);
    timer = 0;

    delete timers[step_id];
    updateProgressBar(step_count);

}


$('#currently-making-steps .steps-container').on('click','.start-clock', function(e) {
    e.preventDefault();
    var step_id    = $(this).data('step-id');
    console.log(step_id);
    var curr_step = $('#currently-making-steps .steps-container div[data-step-id="'+step_id+'"]');
    timers[step_id] = 0;
    var timer_cont = curr_step.find('.recipe-step-timepanel .step-timer');
    timer_cont.html('');
    timer_cont.append('<img src="/assets/images/clock_icon.png" alt="" />');
    timer_cont.append($('<span>00:00</span>'));
    updateMakingStepsClocks();

});

//Sukam laikrodukus:
function clockWork() {
    setTimeout(function () {
        for (var key in timers) {
            timers[key] += 1;
            if(timers[key] == 15)
                show_reminder();
        }
        clockWork();
    }, 1000);
}

function globalClock() {
    setTimeout(function () {
        timer += 1;
        globalClock();
    }, 60000);
}

function show_reminder() {
    var remind = $('.reminder');

    if(!remind.is(':visible')) {
        var alert = new Audio('/assets/sounds/reminder.mp3');
        alert.play();
        remind.fadeIn(300);
    }
}

function updateMakingStepsClocks() {
    setTimeout(function() {
        for (var key in timers) {
            var curr_step = $('#currently-making-steps .steps-container div[data-step-id="' + key + '"]');
            var time_s = timers[key];

            var mins = Math.floor(time_s / 60);
            var seconds = (time_s - mins * 60);

            if(mins.toString().length == 1)
                mins = '0' + mins.toString();

            if(seconds.toString().length == 1)
                seconds = '0' + seconds.toString();

            curr_step.find('.recipe-step-timepanel .step-timer span').text(mins + ':' + seconds);
        }
        updateMakingStepsClocks();
    }, 1000);
}

function updateProgressBar(st_count) {
    st_done++;
    var percentage = (st_done / st_count) * 100;
    $('#steps-progress .progress-line').animate({
        width: percentage + "%"
    }, 800 );
    $('.progress-row span').text(st_done + '/' + st_count);
}

$('#recipe-desc-trigger').click(function(e) {
    e.preventDefault();
    var dhis = $(this);
    var desc = $('.desc');
    console.log(desc.height());

    if(desc.height() == 0) {
        desc.css('height', 'auto');
        var a_height = desc.height();
        desc.height(0).animate({height: a_height},400);
        dhis.rotate({animateTo:180});
    }
    else {
        dhis.rotate({animateTo:0});
        desc.animate({height: 0}, 400);
    }
});

$('.reminder .close-btn').click(function(e) {
    e.preventDefault();
    $(this).parent().fadeOut(300);
});

