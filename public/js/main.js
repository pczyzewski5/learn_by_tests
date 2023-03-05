$('.answer').click(function() {
    $('.answer').removeClass('selected-answer');
    $(this).addClass('selected-answer');
    $('#valid_answer_form_valid_answer').val(
        $(this).attr('answer-id')
    );
    $('#valid_answer_form_save').removeAttr('disabled');
});