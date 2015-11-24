<?php

/*****************************************
* Register scripts and styles
/****************************************/

function hipstr_register_scripts() {

	wp_register_style( 'owl_carousel_css', plugin_dir_url( __FILE__ ) . 'js/vendor/owl-carousel/owl-carousel.css', '', '', false );
	wp_register_style( 'hipstr_styles', plugin_dir_url( __FILE__ ) . 'css/hipstr-styles.css',  '', '', false );
	wp_register_script( 'owl_carousel_js', plugin_dir_url( __FILE__ ) . 'js/vendor/owl-carousel/owl-carousel.js', array( 'jquery' ), '', true );
  wp_register_script( 'hipstr_script', plugin_dir_url( __FILE__ ) . 'js/hipstr-script.js', array( 'jquery', 'owl_carousel_js' ), '', true  );

}
add_action( 'wp_enqueue_scripts', 'hipstr_register_scripts' );

/*****************************************
* Add shortcode
/****************************************/

function hipstr_print() {

	wp_enqueue_style( 'owl_carousel_css' );
	wp_enqueue_style( 'hipstr_styles' );
	wp_enqueue_script( 'owl_carousel_js' );
	wp_enqueue_script( 'hipstr_script' );

	include ( 'partials/hipstr-public-content.php' );

}
add_shortcode( 'hipster-feed', 'hipstr_print' );
