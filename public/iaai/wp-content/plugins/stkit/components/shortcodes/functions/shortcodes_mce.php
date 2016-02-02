<?php if ( !defined( 'ABSPATH' ) ) exit;

	function st_shortcodes_add_mce_button() {

		if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) )
			return;

		if ( 'true' == get_user_option( 'rich_editing' ) ) {

			add_filter( 'mce_external_plugins', 'st_shortcodes_add_tinymce_plugin' );
			add_filter( 'mce_buttons', 'st_shortcodes_register_mce_button' );

		}

	}

	add_action('admin_head', 'st_shortcodes_add_mce_button');

	function st_shortcodes_add_tinymce_plugin( $plugin_array ) {

		$plugin_array['st_shortcodes_mce_button'] = plugins_url( '/stkit/components/shortcodes/assets/js/jquery.shortcodes.mce.js' );

		return $plugin_array;

	}

	function st_shortcodes_register_mce_button( $buttons ) {

		array_push( $buttons, 'st_shortcodes_mce_button' );

		return $buttons;

	}

?>