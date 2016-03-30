<?php
/*****************************************
* Saves user access toekn to database
/****************************************/

require HIPSTR_DIR . '/classes/Instagram.php';

use MetzWeb\Instagram\Instagram;

// Get options
$options = get_option( 'hipstr_options' );

if (!empty($options['client_id']) && !empty($options['client_secret'])) {

  // Initialize class
  $instagram = new Instagram(array(
    'apiKey'      => $options['client_id'],
    'apiSecret'   => $options['client_secret'],
    'apiCallback' => WEBSITE_URL
  ));

  // Check whether the user has granted access
  if ( isset( $_GET['code'] ) ) {

    // Receive OAuth token object
    $data = $instagram->getOAuthToken( $_GET['code'] );

    // Save user access token to database
    $options['token'] = $data;
    update_option( 'hipstr_options', $options );

  }

}
