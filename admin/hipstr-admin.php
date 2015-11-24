<?php

require HIPSTR_DIR . 'setup.php';

/*****************************************
* Add admin menu
/****************************************/

function hipstr_add_admin_menu() {

  add_menu_page(
    'HipsterFeed',
    'HipsterFeed',
    'manage_options',
    'hipster-feed',
    'hipstr_display_admin_content'
  );

}
add_action( 'admin_menu', 'hipstr_add_admin_menu' );

/*****************************************
* Register scripts and styles
/****************************************/

function hipstr_admin_scripts() {

  wp_register_script( 'hipstr_admin_script', plugins_url( 'js/hipstr-admin-script.js', __FILE__ ), array( 'jquery' ) );

  wp_localize_script( 'hipstr_admin_script', 'hipstr_obj', array(
    'nonce' =>  wp_create_nonce( 'hipstr-nonce' ),
    'logout_error' => esc_attr__('There was a problem logging out.', 'hipstr'),
    'url' => esc_url( WEBSITE_URL )
  ));

}
add_action( 'admin_enqueue_scripts', 'hipstr_admin_scripts' );

/*****************************************
* Data processing
/****************************************/

include ( 'includes/hipstr-data-processing.php' );

/*****************************************
* Display admin content
/****************************************/

function hipstr_display_admin_content() {

  wp_enqueue_script( 'hipstr_admin_script' );

  include ( 'partials/hipstr-admin-content.php' );

}
