//Set up the color pickers to work with our text input field
jQuery( document ).ready(function(){
    "use strict";
 
    //This if statement checks if the color picker widget exists within jQuery UI
    //If it does exist then we initialize the WordPress color picker on our text input field
    if( typeof jQuery.wp === 'object' && typeof jQuery.wp.wpColorPicker === 'function' ){
        jQuery( '#color' ).wpColorPicker();
    }
    else {
        //We use farbtastic if the WordPress color picker widget doesn't exist
        jQuery( '#colorpicker' ).farbtastic( '#color' );
    }
});
jQuery(document).ready(function($){
    var custom_uploader;
    $('#upload_image_button').click(function(e) {
 
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#upload_image').val(attachment.url);
        });
        //Open the uploader dialog
        custom_uploader.open();
    });
});