<?php

/*****************************************
* Admin data processing
/****************************************/


function hipstr_data() {

  check_ajax_referer( 'hipstr-nonce', 'security' );

  update_option( 'hipstr_options', array() );

  die();
}
add_action( 'wp_ajax_hipstr_data', 'hipstr_data' );


function hipstr_sign_in() {

  check_ajax_referer( 'hipstr-nonce', 'security' );

  $output = get_option( 'hipstr_options' );
  $output['client_id'] = $_POST['id'];
  $output['client_secret'] = $_POST['secret'];

  // Validate input

  update_option( 'hipstr_options', $output );

  die();
}
add_action( 'wp_ajax_hipstr_sign_in', 'hipstr_sign_in' );
