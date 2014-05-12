/**
 * Created by lukas on 11/05/14.
 */
$(function() {
    var recipe_img = $("#make-recipe").data('recipe-image');
    var recipe_id = $("#make-recipe").data('recipe-id');

    $('body').css('background','url('+recipe_img+') top center').addClass('make-food-bg');
    loadSteps(recipe_id);
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
function loadSteps(recipe_id, step_id) {
    if(step_id == undefined)
        step_id = '';

    var request_url = '../get_steps/'+recipe_id;

    if(step_id != '')
        request_url += '/' + step_id;

    $.ajax({
        type: "GET",
        url: request_url,
        success: function (data) {
            var queue_block = $('#steps-queue .steps-container');
            queue_block.append(data);
        }
    });
}

function startStep(step_id) {
    var curr_step = $('#steps-queue .steps-container div[data-step-id="'+step_id+'"]');
    var st_html = '<div class="col-md-6" data-step-id="'+step_id+'">';
    st_html += curr_step.html();
    st_html += '</div>';

    $('#currently-making-steps .steps-container').append(st_html);

    curr_step.remove();
}

function endStep(step_id, recipe_id) {
    var curr_step = $('#currently-making-steps .steps-container div[data-step-id="'+step_id+'"]');
    curr_step.fadeOut(1000);
    loadSteps(recipe_id, step_id);
}