let $commentContainer = $('#quill-comment-editor-container');
let $commentDataContainer = $('#quill-comment-data-container');

if ($commentContainer.length != 0 && $commentDataContainer.length != 0) {
    $quillComment = new Quill($commentContainer.get(0), {
        theme: 'snow',
        placeholder: 'miejsce na komentarz do odpowiedzi',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                ['link', 'image'],
                [{ 'align': [] }, { 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'color': [] }, { 'background': [] }],
                ['clean']
            ]
        }
    });

    $quillComment.clipboard.addMatcher(Node.ELEMENT_NODE, function(node) {
        let Delta = Quill.import('delta');
        let plaintext = $(node).text ();

        return new Delta().insert(plaintext);
    });

    $quillComment.on('text-change', function($delta, $oldDelta, $source) {
        if ($source == 'api') {
            console.log("An API call triggered this change.");
        }
        if ($source == 'user') {
            $commentDataContainer.val(JSON.stringify($quillComment.getContents()));

            if ($commentDataContainer.val() == '{"ops":[{"insert":"\\n"}]}') {
                $commentDataContainer.val(null)
                $commentDataContainer.removeAttr('value')
            }
        }
    });

    if ($commentDataContainer.val().length != 0) {
        $quillComment.setContents(JSON.parse($commentDataContainer.val()));
    }
}
