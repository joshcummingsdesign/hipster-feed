<?php
/**
 * Instagram PHP API
 * Example for using the getUserMedia() method
 */
require HIPSTR_DIR . '/classes/Instagram.php';
use MetzWeb\Instagram\Instagram;
// Initialize class
$instagram = new Instagram(array(
  'apiKey'      => CLIENT_ID,
  'apiSecret'   => CLIENT_SECRET,
  'apiCallback' => WEBSITE_URL
));
// Get options
$options = get_option( 'hipstr_options' );
// Check whether the user has granted access
if ( isset( $_GET['code'] ) ) {
  // Receive OAuth token object
  $data = $instagram->getOAuthToken( $_GET['code'] );
  // Save user access token to database
  $options['token'] = $data;
  update_option( 'hipstr_options', $options );
}
