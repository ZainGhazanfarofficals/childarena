jQuery(document).ready(function($){
	"use strict";
	var kossy_upload;
	var kossy_selector;

	function kossy_add_file(event, selector) {

		var upload = $(".uploaded-file"), frame;
		var $el = $(this);
		kossy_selector = selector;

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( kossy_upload ) {
			kossy_upload.open();
			return;
		} else {
			// Create the media frame.
			kossy_upload = wp.media.frames.kossy_upload =  wp.media({
				// Set the title of the modal.
				title: "Select Image",

				// Customize the submit button.
				button: {
					// Set the text of the button.
					text: "Selected",
					// Tell the button not to close the modal, since we're
					// going to refresh the page when the image is selected.
					close: false
				}
			});

			// When an image is selected, run a callback.
			kossy_upload.on( 'select', function() {
				// Grab the selected attachment.
				var attachment = kossy_upload.state().get('selection').first();

				kossy_upload.close();
				kossy_selector.find('.upload_image').val(attachment.attributes.url).change();
				if ( attachment.attributes.type == 'image' ) {
					kossy_selector.find('.kossy_screenshot').empty().hide().prepend('<img src="' + attachment.attributes.url + '">').slideDown('fast');
				}
			});

		}
		// Finally, open the modal.
		kossy_upload.open();
	}

	function kossy_remove_file(selector) {
		selector.find('.kossy_screenshot').slideUp('fast').next().val('').trigger('change');
	}
	
	$('body').on('click', '.kossy_upload_image_action .remove-image', function(event) {
		kossy_remove_file( $(this).parent().parent() );
	});

	$('body').on('click', '.kossy_upload_image_action .add-image', function(event) {
		kossy_add_file(event, $(this).parent().parent());
	});

});