<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - BREADCRUMBS

		- yoast_breadcrumb
		- breadcrumb_trail

*/

/*===============================================

	B R E A D C R U M B S
	Breadcrumbs call

===============================================*/

	function st_breadcrumbs() {

		global
			$st_Options;

	/*-------------------------------------------
		1.1 - yoast_breadcrumb
	-------------------------------------------*/

		if ( !empty( $st_Options['compatibility']['yoast'] ) == true && function_exists( 'yoast_breadcrumb' ) ) {

			yoast_breadcrumb('<div class="breadcrumb breadcrumbs"><div class="breadcrumb-yoast">','</div></div>');

		}

	/*-------------------------------------------
		1.2 - breadcrumb_trail
	-------------------------------------------*/

		elseif ( function_exists( 'breadcrumb_trail' ) ) {

			// Remove Auto Drafts
			function st_breadcrumb_trail_autodraft_fix( $trail ) {
			
				foreach ( $trail as $key => $value )
					if ( strpos( $value, 'Auto Draft' ) !== false )
						unset( $trail[$key] );
			
				return $trail;
			
			}
			add_filter( 'breadcrumb_trail_items', 'st_breadcrumb_trail_autodraft_fix' );

			// Call
			breadcrumb_trail(
				array(
					'before'		=> '',
					'show_home'		=> __( 'Home', 'stkit' ),
					'separator'		=> ' '
				)
			);

		}

	}

?>