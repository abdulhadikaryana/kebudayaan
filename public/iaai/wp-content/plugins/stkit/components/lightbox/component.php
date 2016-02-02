<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - LIGHTBOX

		1.1 - Register CSS & JS

*/

/*===============================================

	L I G H T B O X
	PrettyPhoto

===============================================*/

	/*-------------------------------------------
		1.1 - Register CSS & JS
	-------------------------------------------*/

	function st_register_lightbox() {

		wp_enqueue_style( 'st-prettyPhoto', plugins_url() . '/stkit/components/lightbox/assets/css/prettyPhoto.css', false, null, 'screen' );
	
		wp_enqueue_script( 'st-jquery-prettyPhoto', plugins_url() . '/stkit/components/lightbox/assets/js/jquery.prettyPhoto.js', array('jquery'), null, true );

	}

	add_action( 'wp_enqueue_scripts', 'st_register_lightbox' );


?>