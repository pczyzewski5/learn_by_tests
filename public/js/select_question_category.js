let $questionCategory = $('.question-category');
let $attr = $questionCategory.attr('question-category');

if (typeof $attr !== 'undefined' && $attr !== false) {
    $questionCategory.click(function () {
        $('.question-category').removeClass('selected-category');
        $(this).addClass('selected-category');
        $('#question_category_form_question_category').val(
            $(this).attr('question-category')
        );
        $('#question_category_form_save').removeAttr('disabled');
    });
}