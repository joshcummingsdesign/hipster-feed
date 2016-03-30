<?php

/*****************************************
* Builds the image_data array
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

  // Build the image_data array
  if ( !empty( $options['token'] ) ) {

    // Pass user access token to API
    $instagram->setAccessToken( $options['token'] );

    // Get the most recent media published by a user
    $media = $instagram->getUserMedia( 'self', 8 ); //Returns 8 entries for the logged in user

    // Create an array with just the links and img_urls
    $links = array();
    $img_urls = array();

    foreach ( $media->data as $entry ) {

      $link = $entry->link;
      array_push( $links, $link );

      $img_url = $entry->images->standard_resolution->url;
      array_push( $img_urls, $img_url );

    }

    $image_data = array_combine($links, $img_urls);

  }

}
