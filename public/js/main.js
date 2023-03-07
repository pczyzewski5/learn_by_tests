$quill = new Quill('#quill-editor-container', {
    theme: 'snow'
});

$quillData = $('#quill-data-container');
if ($quillData.val().length != 0) {
    $quill.setContents(JSON.parse($quillData.val()));
}

$quill.on('text-change', function($delta, $oldDelta, $source) {
    if ($source == 'api') {
        console.log("An API call triggered this change.");
    }
    if ($source == 'user') {
        $('#quill-data-container').val(JSON.stringify($quill.getContents()));
    }
});

$('.answer').click(function() {
    $('.answer').removeClass('selected-answer');
    $(this).addClass('selected-answer');
    $('#correct_answer_form_is_correct_answer_field').val(
        $(this).attr('answer-id')
    );
    $('#correct_answer_form_save').removeAttr('disabled');
});