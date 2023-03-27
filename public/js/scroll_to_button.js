class ScrollToButton {
    constructor() {
        this.execute()
    }

    execute() {
        let $button = $('#next-question');

        if (typeof $button !== 'undefined' && $button !== false) {
            $('html, body').animate({
                scrollTop: $button.offset().top
            }, 200);
        }
    }
}

new ScrollToButton();