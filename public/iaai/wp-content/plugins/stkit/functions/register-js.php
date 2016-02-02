<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - REGISTER JS

		1.1 - HiDPI script
			- jquery.hidpi.js

*/

	if ( !is_admin() ) {

		function st_kit_scripts() {
	
			global
				$st_Options,
				$st_Settings;


			/*-------------------------------------------
				1.1 - HiDPI script
			-------------------------------------------*/

			if ( $st_Options['panel']['misc']['hidpi'] && !isset( $st_Settings['hidpi'] ) || !empty( $st_Settings['hidpi'] ) != 'no' )
				wp_enqueue_script( 'st-jquery-hidpi', plugins_url() . '/stkit/assets/js/jquery.hidpi.js', array('jquery'), null, true );


		}
	
		add_action( 'wp_enqueue_scripts', 'st_kit_scripts' );

	}


?>