let $answer = $('.answer');
let $attr = $answer.attr('answer-id');

if (typeof $attr !== 'undefined' && $attr !== false) {
    $answer.click(function () {
        $('.answer').removeClass('selected-answer');
        $(this).addClass('selected-answer');
        $('#correct_answer_form_is_correct_answer_field').val(
            $(this).attr('answer-id')
        );
        $('#correct_answer_form_save').removeAttr('disabled');
    });
}