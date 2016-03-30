<?php

/*****************************************
* Add shortcode
/****************************************/

function hipstr_print() {

	include ( 'partials/hipstr-public-content.php' );

}
add_shortcode( 'hipster-feed', 'hipstr_print' );
