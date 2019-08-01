(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	jQuery(".roleLabel").live("click",function(e){
		jQuery(this).closest('[type=checkbox]').prop('checked', true);
		// jQuery(this).closest('[type=checkbox]').prop('checked', true);
	});
	    


	 jQuery("#submit_roles").live("click",function(e){
	 		
	 	// 

	 	var UserRoles = new Array();
        jQuery("input:checked").each(function() {
           UserRoles.push(jQuery(this).val());
        });
        var caps = jQuery("#capabilties").val();

		if ( jQuery('#hide_for_all').is(":checked") ) {
		  var disableForAll = 'yes';
		} else {
			var disableForAll = 'no';
		}

	 	var data = {
			action: 'save_user_roles',
			UserRoles: UserRoles,
			caps: caps,
			disableForAll: disableForAll,
		};
		// the_ajax_script.ajaxurl is a variable that will contain the url to the ajax processing file
	 	$.post(ajaxVar.url, data, function(response) {
	 		// console.log(response);
			window.location.reload();
	 	});


	 });

})( jQuery );
