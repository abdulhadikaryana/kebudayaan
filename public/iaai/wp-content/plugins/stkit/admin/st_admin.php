<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - REGISTER JS & CSS

		1.1 - Admin JS file
		1.2 - UI Slider
		1.3 - Colorpicker

	2 - THEME PANEL

		2.1 - Actions
		2.2 - Menu

	3 - CONTROLS

		3.1 - Major settings
		3.2 - Projects
		3.3 - Layout
		3.4 - Style
		3.5 - Fonts
		3.6 - Misc
		3.7 - Demo
		3.8 - Import / Export
		3.9 - Update

*/

/*===============================================

	R E G I S T E R   J S   &   C S S
	Required scripts & styles

===============================================*/

	function st_panel_scripts() {
	
		global
			$pagenow;


		/*-------------------------------------------
			1.1 - Admin JS file
		-------------------------------------------*/

		wp_enqueue_script( 'st-jquery-admin', plugins_url() . '/stkit/assets/js/jquery.admin.js', array('jquery'), null, true );
		wp_enqueue_style( 'st-admin.css', plugins_url() . '/stkit/assets/css/admin.css', false, null );


		/*-------------------------------------------
			1.2 - UI Slider
		-------------------------------------------*/

		wp_enqueue_script( 'jquery-ui-slider', null, array('jquery') );
		wp_enqueue_style( 'jquery-ui.css', plugins_url() . '/stkit/assets/css/jquery-ui.css', false, null );


		/*-------------------------------------------
			1.3 - Colorpicker
		-------------------------------------------*/

		if ( isset($_GET['page']) && $_GET['page'] == 'st-style-settings' ) {

			wp_enqueue_script( 'st-jquery-colorpicker', plugins_url() . '/stkit/assets/plugins/colorpicker/js/colorpicker.js', array('jquery'), null, true );
			wp_enqueue_script( 'st-admin-colors', plugins_url() . '/stkit/assets/plugins/colorpicker/js/st-admin-colors.js', array('jquery'), null, true );
			wp_enqueue_style( 'st-colorpicker.css', plugins_url() . '/stkit/assets/plugins/colorpicker/css/colorpicker.css', false, null );

		}

	
	}
	
	add_action( 'admin_enqueue_scripts', 'st_panel_scripts' );



/*===============================================

	T H E M E   P A N E L
	Controls of theme settings

===============================================*/

	class st_ControlPanel {
	

		/*-------------------------------------------
			2.1 - Actions
		-------------------------------------------*/

		function st_ControlPanel() {

			global
				$st_Options;

			// Theme Panel
			if ( $st_Options['panel']['major']['status'] )
				add_action( 'admin_menu', array( &$this, 'add_st_theme_panel_menu' ) );

				// Projects
				if ( $st_Options['panel']['projects']['status'] )
					add_action( 'admin_menu', array( &$this, 'add_st_projects_menu' ) );

				// Layout
				if ( $st_Options['panel']['layout']['status'] )
					add_action( 'admin_menu', array( &$this, 'add_st_layout_menu' ) );

				// Fonts
				if ( $st_Options['panel']['fonts']['status'] )
					add_action( 'admin_menu', array( &$this, 'add_st_fonts_menu' ) );

				// Style
				if ( $st_Options['panel']['style']['status'] )
					add_action( 'admin_menu', array( &$this, 'add_st_style_menu' ) );

				// Misc
				if ( $st_Options['panel']['misc']['status'] )
					add_action( 'admin_menu', array( &$this, 'add_st_misc_menu' ) );

				// Demo
				if ( !empty( $st_Options['panel']['demo']['status'] ) && $st_Options['panel']['demo']['status'] == true )
					add_action( 'admin_menu', array( &$this, 'add_st_demo_menu' ) );

				// Import
				if ( $st_Options['panel']['import']['status'] )
					add_action( 'admin_menu', array( &$this, 'add_st_import_menu' ) );

				// Update
				if ( $st_Options['panel']['update']['status'] )
					add_action( 'admin_menu', array( &$this, 'add_st_update_menu' ) );

		}


		/*-------------------------------------------
			2.2 - Menu
		-------------------------------------------*/

		function add_st_theme_panel_menu() {
			add_object_page( __( 'Theme Panel', 'stkit' ), __( 'Theme Panel', 'stkit' ), 'edit_theme_options', 'st-major-settings', array( &$this, 'st_major_settings' ) ); }

			function add_st_projects_menu() {
				add_submenu_page ( 'st-major-settings', __( 'Projects', 'stkit' ), __( 'Projects', 'stkit' ), 'edit_theme_options', 'st-projects-settings', array( &$this, 'st_projects_settings' ) ); }
	
			function add_st_layout_menu() {
				add_submenu_page ( 'st-major-settings', __( 'Layout', 'stkit' ), __( 'Layout', 'stkit' ), 'edit_theme_options', 'st-layout-settings', array( &$this, 'st_layout_settings' ) ); }
	
			function add_st_fonts_menu() {
				add_submenu_page ( 'st-major-settings', __( 'Fonts', 'stkit' ), __( 'Fonts', 'stkit' ), 'edit_theme_options', 'st-fonts-settings', array( &$this, 'st_fonts_settings' ) ); }
	
			function add_st_style_menu() {
				add_submenu_page ( 'st-major-settings', __( 'Style', 'stkit' ), __( 'Style', 'stkit' ), 'edit_theme_options', 'st-style-settings', array( &$this, 'st_style_settings' ) ); }
	
			function add_st_misc_menu() {
				add_submenu_page ( 'st-major-settings', __( 'Miscellaneous', 'stkit' ), __( 'Miscellaneous', 'stkit' ), 'edit_theme_options', 'st-misc-settings', array( &$this, 'st_misc_settings' ) ); }

			function add_st_demo_menu() {
				add_submenu_page ( 'st-major-settings', __( 'Setup Demo', 'stkit' ), __( 'Setup Demo', 'stkit' ), 'edit_theme_options', 'st-demo-settings', array( &$this, 'st_demo_settings' ) ); }
	
			function add_st_import_menu() {
				add_submenu_page ( 'st-major-settings', __( 'Import / Export', 'stkit' ), __( 'Import / Export', 'stkit' ), 'edit_theme_options', 'st-import-settings', array( &$this, 'st_import_settings' ) ); }

			function add_st_update_menu() {
				add_submenu_page ( 'st-major-settings', __( 'Update', 'stkit' ), __( 'Update', 'stkit' ), 'edit_theme_options', 'st-update-settings', array( &$this, 'st_update_settings' ) ); }



		/*===============================================
		
			C O N T R O L S
			Inputs & controls of the panel
		
		===============================================*/

			/*-------------------------------------------
				3.1 - Major settings
			-------------------------------------------*/

			function st_major_settings() {
	
				global
					$allowedtags,
					$st_Options,
					$st_Settings,
					$st_Kit; // needed

					$st_ = array();

					$st_['message'] = '';
	
					$key = 'st_major_settings_action';
					if ( isset($_POST[$key]) && $_POST[$key] == 'save' ) {

	
						// Load theme settings before updating
						$st_['array'] = array();
						$st_['array'] = get_option( $st_Options['general']['name'] . 'settings' );
	
	
						/*--- Tab id -----------------------------*/
		
						$key = 'tab_st_major_settings';		$st_['array'][$key] = wp_filter_nohtml_kses( !$_POST[$key] ? 'general' : $_POST[$key] );
		
		
						/*--- General -----------------------------*/
		
						// Logo
						$key = 'logo_type';					$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'logo';						$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'logo2x';					$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'sitename';					$st_['array'][$key] = wp_kses( isset($_POST[$key]) ? $_POST[$key] : '', $allowedtags );
		
						// Favicon
						$key = 'favicon';					$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );

						// Copyrights
						$key = 'copyrights';				$st_['array'][$key] = isset($_POST[$key]) ? stripslashes($_POST[$key]) : '';
																if ( !empty( $st_Settings['sanitization'] ) != 'no' ) $st_['array'][$key] = wp_kses( $st_['array'][$key], $st_Kit['tags_allowed'] );

						$key = 'dev_link';					$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );

						// GA
						$key = 'google_analytics';			$st_['array'][$key] = isset($_POST[$key]) ? stripslashes($_POST[$key]) : '';
																if ( !empty( $st_Settings['sanitization'] ) != 'no' ) $st_['array'][$key] = wp_kses( $st_['array'][$key], $st_Kit['tags_allowed'] );
		
		
						/*--- Blog -----------------------------*/
		
						// Templates
						$key = 'blog_template';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : 'default' );

						// Featured posts
						$key = 'sticky_qty';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '0' );
						$key = 'sticky_exclude';			$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'sticky_on_frontpage';		$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'sticky_on_archives';		$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'sticky_on_single';			$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'sticky_on_others';			$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'sticky_cache';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );


						/*--- Post -----------------------------*/
	
						$key = 'after_title';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'after_title_data';			$st_['array'][$key] = isset($_POST[$key]) ? stripslashes($_POST[$key]) : '';
																if ( !empty( $st_Settings['sanitization'] ) != 'no' ) $st_['array'][$key] = wp_kses( $st_['array'][$key], $st_Kit['tags_allowed'] );
	
						$key = 'before_post';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'before_post_data';			$st_['array'][$key] = isset($_POST[$key]) ? stripslashes($_POST[$key]) : '';
																if ( !empty( $st_Settings['sanitization'] ) != 'no' ) $st_['array'][$key] = wp_kses( $st_['array'][$key], $st_Kit['tags_allowed'] );
	
						$key = 'post_feat_image';			$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
		
						$key = 'excerpt';					$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );

						$key = 'post_meta';					$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'author_info';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'post_views';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'nice_time';					$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
	
						$key = 'after_post';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'after_post_data';			$st_['array'][$key] = isset($_POST[$key]) ? stripslashes($_POST[$key]) : '';
																if ( !empty( $st_Settings['sanitization'] ) != 'no' ) $st_['array'][$key] = wp_kses( $st_['array'][$key], $st_Kit['tags_allowed'] );

						$key = 'post_comments';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'website_on_comments';		$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'pingbacks';					$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );

						$key = 'related';					$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
	
	
						/*--- Page -----------------------------*/
		
						$key = 'page_comments';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );


						/*--- Sidebar -----------------------------*/
		
						$key = 'sidebar_qty';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );

	
						// Update settings
						update_option( $st_Options['general']['name'] . 'settings', $st_['array'] );
		
						$st_['message'] = __( 'Changes have been saved.', 'stkit' );
			
					}
	
	
				// Get updated settings
				$st_Settings = array();
				$st_Settings = get_option( $st_Options['general']['name'] . 'settings' );
	
				include( plugin_dir_path( __FILE__ ) . '/st_major_settings.php' );
	
	
			}



			/*===========================================
				3.2 - Projects
			-------------------------------------------*/

			function st_projects_settings() {
	
				global
					$st_Options,
					$st_Kit; // needed

					$st_ = array();

					$st_['message'] = '';
	
					$key = 'st_projects_settings_action';
					if ( isset($_POST[$key]) && $_POST[$key] == 'save' ) {
	
	
						// Load theme settings before updating
						$st_['array'] = array();
						$st_['array'] = get_option( $st_Options['general']['name'] . 'settings' );
	
	
						/*--- Tab id -----------------------------*/
		
						$key = 'tab_st_projects_settings';	$st_['array'][$key] = wp_filter_nohtml_kses( !$_POST[$key] ? 'general' : $_POST[$key] );


						/*--- General -----------------------------*/

						// Turn on projects
						$key = 'projects_status';			$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );

						// Slugs
						$key = 'slug_post';					$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'slug_category';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'slug_tag';					$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );


						/*--- Portfolio -----------------------------*/

						$key = 'projects_qty';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'projects_template';			$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );


						/*--- Taxonomy -----------------------------*/

						$key = 'ctp_post';					$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'ctp_category';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'ctp_tag';					$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );


						// Update settings
						update_option( $st_Options['general']['name'] . 'settings', $st_['array'] );
		
						$st_['message'] = __( 'Changes have been saved.', 'stkit' );
			
					}
	
	
				// Get updated settings
				$st_Settings = array();
				$st_Settings = get_option( $st_Options['general']['name'] . 'settings' );
	
				include( plugin_dir_path( __FILE__ ) . '/st_projects_settings.php' );


			}



			/*===========================================
				3.3 - Layout
			-------------------------------------------*/

			function st_layout_settings() {
	
				global
					$st_Options,
					$st_Kit; // needed

					$st_ = array();

					$st_['message'] = '';
	
					$key = 'st_layout_settings_action';
					if ( isset($_POST[$key]) && $_POST[$key] == 'save' ) {
	
	
						// Load theme settings before updating
						$st_['array'] = array();
						$st_['array'] = get_option( $st_Options['general']['name'] . 'settings' );
	
	
						/*--- Tab id -----------------------------*/
		
						$key = 'tab_st_layout_settings';	$st_['array'][$key] = wp_filter_nohtml_kses( !$_POST[$key] ? 'general' : $_POST[$key] );


						/*--- General -----------------------------*/

						// Layout
						$key = 'layout_type';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'layout_design';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );


						/*--- Footer -----------------------------*/

						// Scheme
						$key = 'footer_sidebars';			$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );


						/*--- Social -----------------------------*/

						$key = 'lifestream';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'lifestream_custom';			$st_['array'][$key] = isset($_POST[$key]) ? stripslashes($_POST[$key]) : '';
																if ( !empty( $st_Settings['sanitization'] ) != 'no' ) $st_['array'][$key] = wp_kses( $st_['array'][$key], $st_Kit['tags_allowed'] );

						// Icons
						foreach ( $st_Options['networks'] as $key )
							$st_['array'][$key] = wp_kses( isset($_POST[$key]) ? stripslashes($_POST[$key]) : '', $st_Kit['tags_allowed'] );


						// Update settings
						update_option( $st_Options['general']['name'] . 'settings', $st_['array'] );
		
						$st_['message'] = __( 'Changes have been saved.', 'stkit' );
			
					}
	
	
				// Get updated settings
				$st_Settings = array();
				$st_Settings = get_option( $st_Options['general']['name'] . 'settings' );
	
				include( plugin_dir_path( __FILE__ ) . '/st_layout_settings.php' );
	
	
			}



			/*===========================================
				3.4 - Style
			-------------------------------------------*/

			function st_style_settings() {
	
				global
					$allowedtags,
					$st_Options,
					$st_Kit; // needed

					$st_ = array();

					$st_['message'] = '';
	
					$key = 'st_style_settings_action';
					if ( isset($_POST[$key]) && $_POST[$key] == 'save' ) {
	
	
						// Load theme settings before updating
						$st_['array'] = array();
						$st_['array'] = get_option( $st_Options['general']['name'] . 'settings' );
	
	
						/*--- Tab id -----------------------------*/
		
						$key = 'tab_st_style_settings';		$st_['array'][$key] = wp_filter_nohtml_kses( !$_POST[$key] ? 'general' : $_POST[$key] );


						/*--- General -----------------------------*/

						// Style
						$key = 'style';						$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );

						// Colors
						$key = 'color-primary';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'color-secondary';			$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );


						/*--- Custom -----------------------------*/						

						$key = 'custom_css';				$st_['array'][$key] = isset($_POST[$key]) ? stripslashes($_POST[$key]) : '';


						// Update settings
						update_option( $st_Options['general']['name'] . 'settings', $st_['array'] );
		
						$st_['message'] = __( 'Changes have been saved.', 'stkit' );
			
					}

	
				// Get updated settings
				$st_Settings = array();
				$st_Settings = get_option( $st_Options['general']['name'] . 'settings' );
	
				include( plugin_dir_path( __FILE__ ) . '/st_style_settings.php' );

				// Write the custom.css file
				if ( function_exists( 'st_custom_css' ) )
					st_custom_css();
	
	
			}



			/*===========================================
				3.5 - Fonts
			-------------------------------------------*/

			function st_fonts_settings() {
	
				global
					$allowedtags,
					$st_Options,
					$st_Kit; // needed

					$st_ = array();

					$st_['message'] = '';
	
					$key = 'st_fonts_settings_action';
					if ( isset($_POST[$key]) && $_POST[$key] == 'save' ) {
	
	
						// Load theme settings before updating
						$st_['array'] = array();
						$st_['array'] = get_option( $st_Options['general']['name'] . 'settings' );
	
	
						/*--- Tab id -----------------------------*/
		
						$key = 'tab_st_fonts_settings';		$st_['array'][$key] = wp_filter_nohtml_kses( !$_POST[$key] ? 'general' : $_POST[$key] );


						/*--- General -----------------------------*/

						// Font size
						$key = 'font_size';					$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'font_type';					$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'font_system';				$st_['array'][$key] = wp_kses( isset($_POST[$key]) ? stripslashes($_POST[$key]) : '', $allowedtags );
						$key = 'font_custom_code';			$st_['array'][$key] = wp_kses( isset($_POST[$key]) ? stripslashes($_POST[$key]) : '', $st_Kit['tags_allowed'] );
						$key = 'font_custom_css';			$st_['array'][$key] = wp_kses( isset($_POST[$key]) ? stripslashes($_POST[$key]) : '', $allowedtags );


						// Update settings
						update_option( $st_Options['general']['name'] . 'settings', $st_['array'] );
		
						$st_['message'] = __( 'Changes have been saved.', 'stkit' );
			
					}
	
	
				// Get updated settings
				$st_Settings = array();
				$st_Settings = get_option( $st_Options['general']['name'] . 'settings' );
	
				include( plugin_dir_path( __FILE__ ) . '/st_fonts_settings.php' );

				// Write the custom.css file
				if ( function_exists( 'st_custom_css' ) )
					st_custom_css();

	
			}



			/*===========================================
				3.6 - Misc
			-------------------------------------------*/

			function st_misc_settings() {
	
				global
					$st_Options,
					$st_Kit; // needed

					$st_ = array();

					$st_['message'] = '';
	
					$key = 'st_misc_settings_action';
					if ( isset($_POST[$key]) && $_POST[$key] == 'save' ) {
	
	
						// Load theme settings before updating
						$st_['array'] = array();
						$st_['array'] = get_option( $st_Options['general']['name'] . 'settings' );
	
	
						/*--- Tab id -----------------------------*/
		
						$key = 'tab_st_misc_settings';		$st_['array'][$key] = wp_filter_nohtml_kses( !$_POST[$key] ? 'general' : $_POST[$key] );


						/*--- General -----------------------------*/

						// Sanitization
						$key = 'sanitization';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );

						// Admin bar
						$key = 'admin_bar';					$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
		
						// prettyPhoto
						$key = 'prettyPhoto';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );

						// HiDPI
						$key = 'hidpi';						$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );

						// Shortcodes
						$key = 'shortcodes';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );

						// Sticky Menu
						$key = 'stickymenu';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );

						// Sidebar Alt width
						$key = 'sidebar-alt';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );

						// WooCommerce
						$key = 'products_qty';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'wooc_assets';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );


						/*--- AsSense -----------------------------*/

						$key = 'adsense';					$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'adsense_id';				$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );


						// Update settings
						update_option( $st_Options['general']['name'] . 'settings', $st_['array'] );
		
						$st_['message'] = __( 'Changes have been saved.', 'stkit' );
			
					}
	
	
				// Get updated settings
				$st_Settings = array();
				$st_Settings = get_option( $st_Options['general']['name'] . 'settings' );
	
				include( plugin_dir_path( __FILE__ ) . '/st_misc_settings.php' );
	
	
			}



			/*===========================================
				3.7 - Demo
			-------------------------------------------*/

			function st_demo_settings() {

				global
					$st_Options,
					$st_Kit; // needed

					$key = 'st_demo_settings_action';

				include( plugin_dir_path( __FILE__ ) . '/st_demo_settings.php' );
	
			}



			/*===========================================
				3.8 - Import / Export
			-------------------------------------------*/

			function st_import_settings() {
	
				global
					$st_Options,
					$st_Kit; // needed

					$st_ = array();

					$st_['message'] = '';
	
					$key = 'st_import_settings_action';
					if ( isset($_POST[$key]) && $_POST[$key] == 'save' ) {
	
	
						/*--- General -----------------------------*/

						$st_['array'] = unserialize( base64_decode( wp_filter_nohtml_kses( $_POST['import_data'] ) ) );


						// Update settings
						update_option( $st_Options['general']['name'] . 'settings', $st_['array'] );
		
						$st_['message'] = __( 'Changes have been saved.', 'stkit' );
			
					}
	

				// Get updated settings
				$st_Settings = array();
				$st_Settings = get_option( $st_Options['general']['name'] . 'settings' );

				include( plugin_dir_path( __FILE__ ) . '/st_import_settings.php' );
	
	
			}



			/*===========================================
				3.9 - Update
			-------------------------------------------*/

			function st_update_settings() {
	
				global
					$st_Options,
					$st_Kit; // needed

					$st_ = array();

					$st_['message'] = '';
	
					$key = 'st_update_settings_action';
					if ( isset($_POST[$key]) && $_POST[$key] == 'save' ) {
	
	
						// Load theme settings before updating
						$st_['array'] = array();
						$st_['array'] = get_option( $st_Options['general']['name'] . 'settings' );
	
	
						/*--- Tab id -----------------------------*/
		
						$key = 'tab_st_update_settings';		$st_['array'][$key] = wp_filter_nohtml_kses( !$_POST[$key] ? 'general' : $_POST[$key] );


						/*--- General -----------------------------*/

						// HiDPI
						$key = 'username';						$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );
						$key = 'apikey';						$st_['array'][$key] = wp_filter_nohtml_kses( isset($_POST[$key]) ? $_POST[$key] : '' );


						// Update settings
						update_option( $st_Options['general']['name'] . 'settings', $st_['array'] );
		
						$st_['message'] = __( 'Changes have been saved.', 'stkit' );
			
					}
	
	
				// Get updated settings
				$st_Settings = array();
				$st_Settings = get_option( $st_Options['general']['name'] . 'settings' );
	
				include( plugin_dir_path( __FILE__ ) . '/st_update_settings.php' );
	
	
			}



	} // end st_ControlPanel



?>