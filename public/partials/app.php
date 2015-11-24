<?php

/*****************************************
* Public content
/****************************************/

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
if ( isset( $options['token'] ) ) {
  // Pass user access token to API
  $instagram->setAccessToken( $options['token'] );
  // Get the most recent media published by a user
  $media = $instagram->getUserMedia( 'self', 8 ); //Returns 8 entries for the logged in user
  //Store URLs into an array
  $urls = array();
  $links = array();
  foreach ( $media->data as $entry ) {
    $url = $entry->images->standard_resolution->url;
    array_push( $urls, $url );
    $link = $entry->link;
    array_push( $links, $link );
  }
  $image_data = array_combine($links, $urls);
}
