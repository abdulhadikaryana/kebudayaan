<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - POST VIEWS

		1.1 - Register JS

*/

/*===============================================

	P O S T   V I E W S
	Register postviews

===============================================*/

	/*-------------------------------------------
		1.1 - Register JS
	-------------------------------------------*/

	function st_postviews_register() {

		wp_enqueue_script( 'st-postviews-js', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.postviews.js', array('jquery'), null, true );

	}
	
	add_action( 'wp_enqueue_scripts', 'st_postviews_register' );

?>