class RedirectToQuestionDetails {
    constructor() {
        this.execute()
    }

    execute() {
        let $questionListItemContent = $('.list-group .list-group-item .question-content');

        if (typeof $questionListItemContent !== 'undefined' && $questionListItemContent !== false) {
            $questionListItemContent.click(function () {
                window.location.href = $(this).attr('href');
            });
        }
    }
}

new RedirectToQuestionDetails();