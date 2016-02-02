<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - SHORTCODES

		1.1 - Register JS & CSS
		1.2 - Include shortcodes
		1.3 - Include MCE

*/

/*===============================================

	S H O R T C O D E S
	Register shortcodes

===============================================*/

	/*-------------------------------------------
		1.1 - Register JS & CSS
	-------------------------------------------*/

	function st_shortcodes_register() {

		wp_enqueue_style( 'st-shortcodes-css', get_template_directory_uri() . '/assets/css/shortcodes.css', false, null, 'all' );
		wp_enqueue_script( 'st-shortcodes-js', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.shortcodes.js', array('jquery'), null, true );

	}
	
	add_action( 'wp_enqueue_scripts', 'st_shortcodes_register' );


	/*-------------------------------------------
		1.2 - Include shortcodes
	-------------------------------------------*/

	include ( plugin_dir_path( __FILE__ ) . '/functions/shortcodes.php' );


	/*-------------------------------------------
		1.3 - Include MCE
	-------------------------------------------*/

	include ( plugin_dir_path( __FILE__ ) . '/functions/shortcodes_mce.php' );


?>