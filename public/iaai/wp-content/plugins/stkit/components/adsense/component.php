<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - ADSENSE

		1.1 - Register JS
		1.2 - Include functions

*/

/*===============================================

	A D S E N S E
	Ad Units for Google AdSense

===============================================*/

	/*-------------------------------------------
		1.1 - Register JS
	-------------------------------------------*/

	function st_adsense_define() {

		echo '<script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>' . "\n";

	}

	add_action('wp_footer', 'st_adsense_define');

	function st_adsense_register() {

		wp_enqueue_script( 'st-adsense-js', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.adsense.js', array('jquery'), null, true );

	}

	add_action( 'wp_enqueue_scripts', 'st_adsense_register' );


	/*-------------------------------------------
		1.2 - Include functions
	-------------------------------------------*/

	include ( plugin_dir_path( __FILE__ ) . '/functions/adsense.php' );


?>