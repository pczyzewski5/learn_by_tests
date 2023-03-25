class SelectValidAnswer {
    constructor() {
        this.execute()
    }

    execute() {
        let $answer = $('.answer');
        let $attr = $answer.attr('answer-id');

        if (typeof $attr !== 'undefined' && $attr !== false) {
            $answer.click(function () {
                $('.answer').removeClass('selected-answer');
                $(this).addClass('selected-answer');
                $('#select_answer_form_selected_answer').val(
                    $(this).attr('answer-id')
                );
                $('#select_answer_form_submit').removeAttr('disabled');
            });
        }
    }
}

new SelectValidAnswer();