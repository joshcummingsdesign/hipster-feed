/*****************************************
* Admin script
/****************************************/

jQuery(document).ready(function($) {

	'use strict';

	// Redirect if the code is in the URL
	if(window.location.href.indexOf("code") > -1) {
			 window.location.href = hipstr_obj.url;
    } else {
			$('body').show();
		}

	// Logout
	$('#hipstr-logout').click(function(){
		var data = {
			action: 'hipstr_data',
			security: hipstr_obj.nonce
		};
		$.post(ajaxurl, data)
			.done(function(){
				window.location.href = hipstr_obj.url;
			})
			.fail(function(){
				alert(hipstr_obj.logout_error);
			});
	});

});
