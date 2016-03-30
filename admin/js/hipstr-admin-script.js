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

	// Sign in
	$('#hipstr-login').click(function(){
		var client_id = $('#hipstr-client-id').val();
		var client_secret = $('#hipstr-client-secret').val();
		var data = {
			action: 'hipstr_sign_in',
			security: hipstr_obj.nonce,
			id: client_id,
			secret: client_secret
		};
		$.post(ajaxurl, data)
			.done(function(){
				window.location.href = hipstr_obj.url;
			})
			.fail(function(){
				alert(hipstr_obj.logout_error);
			});
	});

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
