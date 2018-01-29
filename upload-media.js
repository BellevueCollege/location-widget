/* Based on https://vedmant.com/using-wordpress-media-library-in-widgets-options/ */
jQuery(document).ready(function ($) {
      $( document ).on( "click", ".clear_image_button", function( e ) {
            e.preventDefault();
            $(this).siblings( 'input' ).val( "" ).change();
      } );
      $(document).on("click", ".upload_image_button", function (e) {
         e.preventDefault();
         var $button = $(this);
    
         // Create the media frame
         var file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select or upload image',
            library: { // remove these to show all
               type: 'image' // specific mime
            },
            button: {
               text: 'Select' //Text for button in media uploader
            },
            multiple: false  // Set to true to allow multiple files to be selected
         });
    
         // When an image is selected, run a callback
         file_frame.on('select', function () {
    
            var attachment = file_frame.state().get('selection').first().toJSON();
    
            $button.siblings('input').val(attachment.id).change(); //.change() saves the changed image URL
    
         });
    
         // Finally, open the modal
         file_frame.open();
      });
   });