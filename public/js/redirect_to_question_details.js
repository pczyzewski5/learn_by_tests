class RedirectToQuestionDetails {
    constructor() {
        this.execute()
    }

    execute() {
        let $questionListItemContent = $('.list-group .list-group-item .question-content');

        if (typeof $questionListItemContent !== 'undefined' && $questionListItemContent !== false) {
            $questionListItemContent.on('mouseup', function ($event) {
                console.log($event.button);
                if ($event.button == 1) {
                    window.open($(this).attr('href'), '_blank');
                } else {
                    window.location.href = $(this).attr('href');
                }
            });
        }
    }
}

new RedirectToQuestionDetails();