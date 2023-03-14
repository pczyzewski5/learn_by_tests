class SelectQuestionCategory {
    constructor() {
        this.execute()
    }

    execute() {
        let $questionSubCategory = $('.question-subcategory');
        let $attr = $questionSubCategory.attr('question-subcategory');

        if (typeof $attr !== 'undefined' && $attr !== false) {
            $questionSubCategory.click(function () {
                $('.question-subcategory').removeClass('selected-subcategory');
                $(this).addClass('selected-subcategory');
                $('#category_form_category').val(
                    $(this).attr('question-subcategory')
                );
                $('#category_form_zapisz').removeAttr('disabled');
            });
        }
    }
}

new SelectQuestionCategory();
