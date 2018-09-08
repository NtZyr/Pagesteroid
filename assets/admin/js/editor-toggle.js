jQuery( document ).ready( function() {
    function editorToggle() {
        if( 'templates/pagesteroid.php' == $( '#page_template' ).val() ){
            $( '#postdivrich' ).hide();
            $( '#pagesteroid' ).show();
        }
        else{
            $( '#postdivrich' ).show();
            $( '#pagesteroid' ).hide();
        }
    }

    editorToggle();

    $('#page_template').change( function(e) {
        editorToggle();
    });
});