<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - METABOXES

		1.1 - Metabox: Sidebar
		1.2 - Metabox: Post Options
		1.3 - Metabox: Post Formats
		1.4 - Metabox: CTP Formats

*/

/*===============================================

	M E T A B O X E S
	Include metaboxes

===============================================*/

	/*-------------------------------------------
		1.1 - Metabox: Sidebar
	-------------------------------------------*/

	if ( is_admin() && $st_Options['metaboxes']['sidebar'] )
		include ( plugin_dir_path( __FILE__ ) . '/functions/metabox-sidebar.php' );



	/*-------------------------------------------
		1.2 - Metabox: Post Options
	-------------------------------------------*/

	if ( is_admin() && $st_Options['metaboxes']['post-options'] )
		include ( plugin_dir_path( __FILE__ ) . '/functions/metabox-post-options.php' );



	/*-------------------------------------------
		1.3 - Metabox: Post Formats
	-------------------------------------------*/

	if ( is_admin() && $st_Options['global']['post-formats']['enabled'] ) {

		include ( plugin_dir_path( __FILE__ ) . '/functions/metabox-post-formats.php' );

		function st_post_formats_metaboxes_js_register() {
			wp_enqueue_script( 'st-metaboxes-js', plugin_dir_url( __FILE__ ) . '/assets/js/jquery.metaboxes.js' );
		}
		
		add_action( 'admin_enqueue_scripts', 'st_post_formats_metaboxes_js_register' );

	}



	/*-------------------------------------------
		1.4 - Metabox: CTP Formats
	-------------------------------------------*/

	if ( is_admin() && !empty( $st_Options['ctp']['ctp-formats']['enabled'] ) ) {

		include ( plugin_dir_path( __FILE__ ) . '/functions/metabox-ctp-formats.php' );

		function st_ctp_formats_metaboxes_js_register() {

			wp_enqueue_script( 'st-ctp-metaboxes-js', plugin_dir_url( __FILE__ ) . '/assets/js/jquery.metaboxes.ctp.js' );

			wp_enqueue_script( 'st-jquery-colorpicker', plugins_url() . '/stkit/assets/plugins/colorpicker/js/colorpicker.js', array('jquery'), null, true );
			wp_enqueue_script( 'st-admin-colors', plugins_url() . '/stkit/assets/plugins/colorpicker/js/st-admin-colors.js', array('jquery'), null, true );
			wp_enqueue_style( 'st-colorpicker.css', plugins_url() . '/stkit/assets/plugins/colorpicker/css/colorpicker.css', false, null );

		}
		
		add_action( 'admin_enqueue_scripts', 'st_ctp_formats_metaboxes_js_register' );

	}



?>