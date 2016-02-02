<?php if ( !defined( 'ABSPATH' ) ) exit;
/*
Plugin Name: ST Kit
Plugin URI: http://strictthemes.com
Description: Extended functionality for Premium WordPress themes.
Author: StrictThemes
Author URI: http://strictthemes.com
Version: 1.5.0
License: GPL-compatible
License URI: http://strictthemes.com/licensing/
Text Domain: stkit
Domain Path: /assets/lang/



	1 - SCREENING

		1.1 - Function
		1.2 - Checking

	2 - RETRIEVE DATA

		2.1 - Kit Options
		2.2 - Theme Options
		2.3 - Theme Settings

	3 - LOCALIZATION

	4 - THEME PANEL

	5 - INCLUDINGS

		5.1 - Functions
		5.2 - Register: CSS
		5.3 - Register: JS
		5.4 - Update Checker

	6 - COMPONENTS

		6.1 - Shortcodes
		6.2 - Metaboxes
		6.3 - Breadcrumbs
		6.4 - Widgets
		6.5 - Projects
		6.6 - Lightbox
		6.7 - Post Views
		6.8 - AdSense



/*= 1 ============================================

	S C R E E N I N G
	Check the theme compatibility

===============================================*/

	/*-------------------------------------------
		1.1 - Function
	-------------------------------------------*/

	function st_fallback_notice() {

		global
			$kit_; ?>

			<div class="updated">
				<p>
					<?php echo !empty($kit_['fallback_notice']) ? $kit_['fallback_notice'] : ':)' ?>
				</p>
			</div><?php

	}

	/*-------------------------------------------
		1.2 - Checking
	-------------------------------------------*/

	$kit_ = array();

	$kit_['theme'] = wp_get_theme();

	if ( $kit_['theme']->get('Template') )
		$kit_['root'] = wp_get_theme( $kit_['theme']->get('Template') );

	else
		$kit_['root'] = $kit_['theme'];

	if ( $kit_['root']->get('TextDomain') != 'strictthemes' && $kit_['root']->get('TextDomain') != 'dankov' ) {

		if ( is_admin() ) {
			$kit_['fallback_notice'] = __( "Current theme isn't compatible with ST Kit plugin.", 'stkit' ) . ' ' . '<a href="http://strictthemes.com/to/portfolio" target="_blank"><strong>' . __( 'Get a compatible theme', 'stkit' ) . ' &raquo;</strong></a>';
			add_action( 'admin_notices', 'st_fallback_notice' );
		}

		return;

	}

	else {
		function st_kit() {}; }



/*= 2 ============================================

	R E T R I E V E   D A T A
	Get a required data

===============================================*/

	/*-------------------------------------------
		2.1 - Kit Options
	-------------------------------------------*/

	include ( plugin_dir_path( __FILE__ ) . '/options.php' );



	/*-------------------------------------------
		2.2 - Theme Options
	-------------------------------------------*/

	require_once ( get_template_directory() . '/options.php' );



	/*-------------------------------------------
		2.3 - Theme Settings
	-------------------------------------------*/

	$st_Settings = get_option( $st_Options['general']['name'] . 'settings' );



/*= 3 ============================================

	L O C A L I Z A T I O N
	Load plugin textdomain

===============================================*/

	function st_plugin_textdomain() {
	
		load_plugin_textdomain( 'stkit', false, dirname( plugin_basename( __FILE__ )) . '/assets/lang' );

	}
	
	add_action( 'init', 'st_plugin_textdomain' );



/*= 4 ===========================================

	T H E M E   P A N E L
	Theme Controls

===============================================*/

	if ( is_admin() ) {

		require_once ( plugin_dir_path( __FILE__ ) . '/admin/st_admin.php' );

		$st_ControlPanel = new st_ControlPanel();

	}



/*= 5 ===========================================

	I N C L U D I N G S
	Required includings

===============================================*/

	/*-------------------------------------------
		5.1 - Functions
	-------------------------------------------*/

	require_once ( plugin_dir_path( __FILE__ ) . '/functions/global.php' );


	/*-------------------------------------------
		5.2 - Register: CSS
	-------------------------------------------*/

	require_once ( plugin_dir_path( __FILE__ ) . '/functions/register-css.php' );


	/*-------------------------------------------
		5.3 - Register: JS
	-------------------------------------------*/

	require_once ( plugin_dir_path( __FILE__ ) . '/functions/register-js.php' );


	/*-------------------------------------------
		5.4 - Update Checker
	-------------------------------------------*/

	require ( plugin_dir_path( __FILE__ ) . '/assets/plugins/update-checker/plugin-update-checker.php' );

	$MyUpdateChecker = PucFactory::buildUpdateChecker( 'http://repo.strictthemes.com/?action=get_metadata&slug=stkit', __FILE__, 'stkit' );



/*= 6 ===========================================

	C O M P O N E N T S
	Includings

===============================================*/

	/*-------------------------------------------
		6.1 - Shortcodes
	-------------------------------------------*/

	if ( $st_Options['shortcodes']['status'] )
		if ( empty( $st_Settings['shortcodes'] ) || isset( $st_Settings['shortcodes'] ) && $st_Settings['shortcodes'] != 'no' )
			require_once ( plugin_dir_path( __FILE__ ) . '/components/shortcodes/component.php' );



	/*-------------------------------------------
		6.2 - Metaboxes
	-------------------------------------------*/

	require_once ( plugin_dir_path( __FILE__ ) . '/components/metaboxes/component.php' );



	/*-------------------------------------------
		6.3 - Breadcrumbs
	-------------------------------------------*/

	if ( !is_admin() && $st_Options['breadcrumbs'] )
		require_once ( plugin_dir_path( __FILE__ ) . '/components/breadcrumbs/component.php' );



	/*-------------------------------------------
		6.4 - Widgets
	-------------------------------------------*/

	require_once ( plugin_dir_path( __FILE__ ) . '/components/widgets/component.php' );



	/*-------------------------------------------
		6.5 - Projects
	-------------------------------------------*/

	if ( !empty( $st_Settings['projects_status'] ) == 'yes' )
		require_once ( plugin_dir_path( __FILE__ ) . '/components/ctp/component.php' );



	/*-------------------------------------------
		6.6 - Lightbox
	-------------------------------------------*/

	if (
		$st_Options['js']['prettyPhoto'] && empty( $st_Settings['prettyPhoto'] ) ||
		$st_Options['js']['prettyPhoto'] && !empty( $st_Settings['prettyPhoto'] ) && $st_Settings['prettyPhoto'] != 'no' ) {

			require_once ( plugin_dir_path( __FILE__ ) . '/components/lightbox/component.php' );

	}



	/*-------------------------------------------
		6.7 - Post Views
	-------------------------------------------*/

	if ( !empty( $st_Settings['post_views'] ) && $st_Settings['post_views'] == 'yes' )
		require_once ( plugin_dir_path( __FILE__ ) . '/components/postviews/component.php' );



	/*-------------------------------------------
		6.8 - AdSense
	-------------------------------------------*/

	if ( !empty( $st_Settings['adsense'] ) && $st_Settings['adsense'] == 'yes' )
		require_once ( plugin_dir_path( __FILE__ ) . '/components/adsense/component.php' );



?>