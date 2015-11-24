<?
/*
Plugin Name: HipsterFeed
Plugin URI:  http://www.joshcummingsdesign.com
Description: Display your most recent instagram photos in a responsive slider.
Version:     1.0
Author:      Josh Cummings
Author URI:  http://www.joshcummingsdesign.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: hipstr
Domain Path: /languages
*/

/*****************************************
* Contstants
/****************************************/

define('HIPSTR_DIR', plugin_dir_path( __FILE__ ) );

/*****************************************
* Installation
/****************************************/

function hipstr_install() {

	$default_options = array();

	update_option( 'hipstr_options', $default_options );
}
register_activation_hook( __FILE__, 'hipstr_install' );

/*****************************************
* Includes
/****************************************/

include ( 'public/hipstr-public.php' );
include ( 'admin/hipstr-admin.php' );
