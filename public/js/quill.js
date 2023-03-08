let $container = $('#quill-editor-container');
let $dataContainer = $('#quill-data-container');

if ($container.length != 0 && $dataContainer.length != 0) {
    $quill = new Quill($container.get(0), {
        theme: 'snow'
    });

    $quill.clipboard.addMatcher(Node.ELEMENT_NODE, function(node) {
        var Delta = Quill.import('delta');
        var plaintext = $(node).text ();
        console.log(plaintext);
        return new Delta().insert(plaintext);
    });

    $quill.on('text-change', function($delta, $oldDelta, $source) {
        if ($source == 'api') {
            console.log("An API call triggered this change.");
        }
        if ($source == 'user') {
            $dataContainer.val(JSON.stringify($quill.getContents()));
        }
    });

    if ($dataContainer.val().length != 0) {
        $quill.setContents(JSON.parse($dataContainer.val()));
    }
}
