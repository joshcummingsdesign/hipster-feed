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
