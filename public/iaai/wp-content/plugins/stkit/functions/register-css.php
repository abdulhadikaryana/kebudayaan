<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - REGISTER CSS

		1.1 - Responsive styles
			- /assets/css/responsive.css

		1.2 - Alternative style
			- /assets/css/alt/dark.css

		1.3 - Custom styles
			- ../../themename_custom.css

*/

	if ( !is_admin() ) {

		function st_other_styles() {
	
			global
				$st_Options,
				$st_Settings;


				/*-------------------------------------------
					1.1 - Responsive styles
				-------------------------------------------*/
	
				if ( !isset( $st_Settings['layout_type'] ) || $st_Options['panel']['style']['general']['responsive'] && !empty( $st_Settings['layout_type'] ) && $st_Settings['layout_type'] != 'standard' )
					wp_enqueue_style( 'st-responsive', get_template_directory_uri() . '/assets/css/responsive.css', false, null, 'all' );
	
	
				/*-------------------------------------------
					1.2 - Alternative style
				-------------------------------------------*/
				$alt = !empty( $st_Settings['style'] ) ? $st_Settings['style'] : '';

				if ( $alt && $alt != 'light' )
					wp_enqueue_style( 'st-' . $alt, get_template_directory_uri() . '/assets/css/alt/' . $alt . '.css', false, null, 'screen' );


				/*-------------------------------------------
					1.3 - RTL
				-------------------------------------------*/
	
				if ( isset( $st_Options['global']['rtl'] ) && $st_Options['global']['rtl'] == true && is_rtl() )
					wp_enqueue_style( 'st-rtl', get_template_directory_uri() . '/rtl.css', false, null, 'all' );


				/*-------------------------------------------
					1.4 - Custom styles
				-------------------------------------------*/
	
				if (
					!empty( $st_Settings['tab_st_fonts_settings'] ) && $st_Settings['tab_st_fonts_settings'] || 
					!empty( $st_Settings['tab_st_style_settings'] ) && $st_Settings['tab_st_style_settings'] ) // Check the 'Style' or 'Fonts' tabs have been updated at least ones
						wp_enqueue_style( 'st-custom', st_get_custom_css('url'), false, null, 'screen' );

		
		}

		add_action( 'wp_enqueue_scripts', 'st_other_styles', 100 );

	}


?>