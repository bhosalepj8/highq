

jQuery(document).ready(function($){

    // Uploading files
    var file_frame;
    
    $('.uploader .button').live( 'click', function ( event ) {
        var $this = $(this);        
        uploadAction( $this, event, file_frame );
    });
    
    
    function uploadAction( $this, event, file_frame){
        $parent = $this.parent();

        var name = $this.attr('name');
        
        // If the media frame already exists, reopen it.
        if ( file_frame ) {
            file_frame.open();
            return;
        }
        
        event.preventDefault();
        
        // Create the media frame.
        file_frame = wp.media.frames.file_frame = wp.media({
            title: jQuery( this ).data( 'uploader_title' ),
            button: {
                text: jQuery( this ).data( 'uploader_button_text' ),
            },
            multiple: false
        });
        
        // When an image is selected, run a callback.
        file_frame.on( 'select', function() {
            attachment = file_frame.state().get('selection').first().toJSON();
            
            $( '#' + name ).val( attachment.url );
            $( '#' + name + '_preview').html( '<br /><img src="' + attachment.url + '" alt="Logo" width="250px"/> ' );    
        });

        // Finally, open the modal
        file_frame.open();

    }
});