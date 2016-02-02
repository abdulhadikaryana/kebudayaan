<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - GLOBAL

		1.1 - Post formats

	2 - FILTERS

		2.1 - Google Analytics
		2.2 - Remove admin bar
		2.3 - Excerpt lenght
		2.4 - Stop breaking shortcodes
		2.5 - Install Google font
		2.6 - Include post formats to RSS-feed

	3 - ACTIONS

		3.1 - Theme Panel links on Admin Bar
		3.2 - Do shortcodes on...
		3.3 - Alt classes body class
		3.4 - Attachments update
		3.5 - Dequeue WP-Pagenavi stiles

	4 - FUNCTIONS
		
		4.1 - Post views
		4.2 - Nice time
		4.3 - Icons the Social
		4.4 - Path of custom.css file
		4.5 - Get a first image from post
		4.6 - Write Custom CSS
		4.7 - Get 2x image URL
		4.8 - Get post format icon
		4.9 - Custom Background Callback
		4.10 - Adjust Color Brightness
		4.11 - Related posts

	5 - WOOCOMMERCE

		5.1 - Add WooCommerce support
		5.2 - Remove WooCommerce prettyPhoto
		5.3 - Re-define number of products per row
		5.4 - Define image sizes
		5.5 - Define number of products per page
		5.6 - Define number of related products
		5.7 - Register CSS
		5.8 - Remove JS & CSS from irrelevant pages

*/

/*= 1 ===========================================

	G L O B A L
	Required WordPress settings

===============================================*/

	global
		$st_Options,
		$st_Settings;



	/*-------------------------------------------
		1.1 - Post formats
	-------------------------------------------*/

	if ( $st_Options['global']['post-formats']['enabled'] ) {

		foreach ( $st_Options['global']['post-formats'] as $st_['format'] => $key ) {
			if ( $key['status'] )
				$st_['post-formats'][] = $st_['format'];

		}

		add_theme_support( 'post-formats', $st_['post-formats'] );

	}



/*= 2 ===========================================

	F I L T E R S
	Permanent custom filters

===============================================*/

	/*-------------------------------------------
		2.1 - Google Analytics
	-------------------------------------------*/

	function st_ga() {

		global
			$st_Settings;

			if ( !empty( $st_Settings['google_analytics'] ) ) {

				$ga = explode( 'script>', $st_Settings['google_analytics'] );

				if ( $ga[1] )
					echo $st_Settings['google_analytics'];
				else
					echo '<script>' . $st_Settings['google_analytics'] . '</script>' . "\n";

			}

	}

	add_filter( 'wp_head', 'st_ga', 100 );



	/*-------------------------------------------
		2.2 - Remove admin bar
	-------------------------------------------*/

	if ( !empty( $st_Settings['admin_bar'] ) && $st_Settings['admin_bar'] == 'no' ) {

		function st_function_admin_bar() { return false; }

		add_filter( 'show_admin_bar' , 'st_function_admin_bar' );

	}



	/*-------------------------------------------
		2.3 - Excerpt lenght
	-------------------------------------------*/

	function st_excerpt_length( $length = NULL ) {

		global
			$st_Options;

			$length = $length ? $length : $st_Options['global']['excerpt'];

		return
			$length;

	}

	add_filter( 'excerpt_length', 'st_excerpt_length' );



	/*-------------------------------------------
		2.4 - Stop breaking shortcodes
	-------------------------------------------*/

	function st_shortcode_fix( $content ) {

		$array = array (
			'<p>['		=> '[', 
			']</p>'		=> ']', 
			']<br />'	=> ']'
			);

		$content = strtr( $content, $array );

		return $content;

	}

	add_filter( 'the_content', 'st_shortcode_fix' );



	/*-------------------------------------------
		2.5 - Install Google font
	-------------------------------------------*/

	function st_google_font() {

		global
			$st_Settings;

			if ( !empty( $st_Settings['font_type'] ) && $st_Settings['font_type'] == 'custom' )
				echo $st_Settings['font_custom_code'] . "\n";

	}

	add_filter( 'wp_head', 'st_google_font', 100 );



	/*-------------------------------------------
		2.6 - Include post formats to RSS-feed
	-------------------------------------------*/

	function st_feed_post_format( $content ) {

		global
			$post,
			$st_Options,
			$st_Settings;

			$content_width = $st_Options['global']['images']['project-medium']['width'];

			$st_ = array();

			// Post format
			$st_['format'] = get_post_format( $post->ID ) ? get_post_format( $post->ID ) : 'standard';

			// Format: Standard, Image
			if ( $st_['format'] == 'standard' || $st_['format'] == 'image' ) {

				if ( has_post_thumbnail( $post->ID ) )
					$content = '<div>' . get_the_post_thumbnail( $post->ID, 'post-image' ) . '</div>' . $content;

			}

			// Format: Gallery
			if ( $st_['format'] == 'gallery' ) {

				if ( empty( $st_Settings['shortcodes'] ) || isset( $st_Settings['shortcodes'] ) && $st_Settings['shortcodes'] != 'no' ) {
		
					$st_['ids'] = st_get_post_meta( $post->ID, 'gallery_value', true, '' );
			
					if ( $st_['ids'] ) {
						$st_['gallery'] = str_replace( '/>', '/><br />', do_shortcode( '[st-gallery ids="' . $st_['ids'] . '"]' ) ); }

					$content = '<div>' . $st_['gallery'] . '</div>' . $content;

				}

			}

			// Format: Audio
			if ( $st_['format'] == 'audio' ) {

				$st_['mp3'] = st_get_post_meta( $post->ID, 'mp3_value', true, '' ) ? ' mp3="' . st_get_post_meta( $post->ID, 'mp3_value', true, '' ) . '"' : '';
				$st_['ogg'] = st_get_post_meta( $post->ID, 'ogg_value', true, '' ) ? ' ogg="' . st_get_post_meta( $post->ID, 'ogg_value', true, '' ) . '"' : '';
				$st_['audio'] = st_get_post_meta( $post->ID, 'audio_value', true, '' );

				if ( $st_['audio'] )
					$content = '<div>' . $st_['audio'] . '</div>' . $content;
		
				elseif ( $st_['mp3'] || $st_['ogg'] )
					$content = '<div>' . do_shortcode('[audio' . $st_['mp3'] . $st_['ogg'] . ' preload=none]') . '</div>' . $content;

			}

			// Format: Video
			if ( $st_['format'] == 'video' ) {

				$st_['mp4'] = st_get_post_meta( $post->ID, 'mp4_value', true, '' ) ? ' mp4="' . st_get_post_meta( $post->ID, 'mp4_value', true, '' ) . '"' : '';
				$st_['ogv'] = st_get_post_meta( $post->ID, 'ogv_value', true, '' ) ? ' ogv="' . st_get_post_meta( $post->ID, 'ogv_value', true, '' ) . '"' : '';
				$st_['webm'] = st_get_post_meta( $post->ID, 'webm_value', true, '' ) ? ' webm="' . st_get_post_meta( $post->ID, 'webm_value', true, '' ) . '"' : '';
				$st_['video'] = st_get_post_meta( $post->ID, 'video_value', true, '' );
		
				if ( $st_['video'] ) {
					$content = '<div>' . $st_['video'] . '</div>' . $content; }
		
				elseif ( $st_['mp4'] || $st_['ogv'] || $st_['webm'] ) {
		
					$st_['poster'] = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
						$st_['poster'] = $st_['poster'] ? ' poster=' . $st_['poster'][0] : '';
		
					$content = '<div>' . do_shortcode('[video' . $st_['mp4'] . $st_['ogv'] . $st_['webm'] . ' preload=none ' . $st_['poster'] . ']') . '</div>' . $content;
		
				}

			}

			// Format: Link
			if ( $st_['format'] == 'Link' ) {

				$st_['link'] = st_get_post_meta( $post->ID, 'link_value', true, '' );

				if ( $st_['link'] ) {
			
					$st_['link_title'] = st_get_post_meta( $post->ID, 'link_title_value', true, $st_['link'] );
			
					$content = '<div><p style="font-size: 120%;"><a href="' . $st_['link'] . '">' . $st_['link_title'] . '</a></p></div>' . $content;
		
				}

			}

			// Format: Quote
			if ( $st_['format'] == 'quote' ) {

				$st_['quote'] = st_get_post_meta( $post->ID, 'quote_value', true, '' );
			
				if ( $st_['quote'] )
					$content = '<blockquote><p style="font-size: 120%;">' . $st_['quote'] . '</p></blockquote>' . $content;

			}

		return $content;

	}

	add_filter( 'the_excerpt_rss', 'st_feed_post_format', 1000, 1 );
	add_filter( 'the_content_feed', 'st_feed_post_format', 1000, 1 );



/*= 3 ===========================================

	A C T I O N S
	Permanent custom actions

===============================================*/

	/*-------------------------------------------
		3.1 - Theme Panel links on Admin Bar
	-------------------------------------------*/

	function st_admin_bar_init() {

		if ( current_user_can( 'edit_theme_options' ) ) {
	
			function st_admin_bar( $admin_bar ) {
		
				global
					$st_Options;
		
		
					$args = array(
						'id'		=> 'st-panel',
						'title'		=> __( 'Theme Panel', 'stkit' ),
						'href'		=> admin_url( 'admin.php?page=st-major-settings'),
						'parent'	=> 'site-name',
					);
					$admin_bar->add_menu( $args);
			
						// Main Settings
						$args = array(
							'id'		=> 'st-panel-major',
							'title'		=> __( 'Main Settings', 'stkit' ),
							'href'		=> admin_url( 'admin.php?page=st-major-settings'),
							'parent'	=> 'st-panel',
						);
						if ( $st_Options['panel']['major']['status'] )
							$admin_bar->add_menu( $args);
			
						// Projects
						$args = array(
							'id'		=> 'st-panel-projects',
							'title'		=> __( 'Projects', 'stkit' ),
							'href'		=> admin_url( 'admin.php?page=st-projects-settings'),
							'parent'	=> 'st-panel',
						);
						if ( $st_Options['panel']['projects']['status'] )
							$admin_bar->add_menu( $args);
			
						// Layout
						$args = array(
							'id'		=> 'st-panel-layout',
							'title'		=> __( 'Layout', 'stkit' ),
							'href'		=> admin_url( 'admin.php?page=st-layout-settings'),
							'parent'	=> 'st-panel',
						);
						if ( $st_Options['panel']['layout']['status'] )
							$admin_bar->add_menu( $args);
			
						// Fonts
						$args = array(
							'id'		=> 'st-panel-fonts',
							'title'		=> __( 'Fonts', 'stkit' ),
							'href'		=> admin_url( 'admin.php?page=st-fonts-settings'),
							'parent'	=> 'st-panel',
						);
						if ( $st_Options['panel']['fonts']['status'] )
							$admin_bar->add_menu( $args);
			
						// Style
						$args = array(
							'id'		=> 'st-panel-style',
							'title'		=> __( 'Style', 'stkit' ),
							'href'		=> admin_url( 'admin.php?page=st-style-settings'),
							'parent'	=> 'st-panel',
						);
						if ( $st_Options['panel']['style']['status'] )
							$admin_bar->add_menu( $args);
			
						// Miscellaneous
						$args = array(
							'id'		=> 'st-panel-misc',
							'title'		=> __( 'Miscellaneous', 'stkit' ),
							'href'		=> admin_url( 'admin.php?page=st-misc-settings'),
							'parent'	=> 'st-panel',
						);
						if ( $st_Options['panel']['misc']['status'] )
							$admin_bar->add_menu( $args);
			
						// Import Export
						$args = array(
							'id'		=> 'st-panel-import',
							'title'		=> __( 'Import / Export', 'stkit' ),
							'href'		=> admin_url( 'admin.php?page=st-import-settings'),
							'parent'	=> 'st-panel',
						);
						if ( $st_Options['panel']['import']['status'] )
							$admin_bar->add_menu( $args);
			
						// Update
						$args = array(
							'id'		=> 'st-panel-update',
							'title'		=> __( 'Update', 'stkit' ),
							'href'		=> admin_url( 'admin.php?page=st-update-settings'),
							'parent'	=> 'st-panel',
						);
						if ( $st_Options['panel']['update']['status'] )
							$admin_bar->add_menu( $args);
		
			}
			
			add_action( 'admin_bar_menu', 'st_admin_bar', 100 );
	
		}

	}

	add_action( 'init', 'st_admin_bar_init', 100 );



	/*-------------------------------------------
		3.2 - Do shortcodes on..
	-------------------------------------------*/

	add_filter( 'widget_text', 'do_shortcode' );
	add_filter( 'the_excerpt', 'do_shortcode' );



	/*-------------------------------------------
		3.3 - Alt classes body class
	-------------------------------------------*/

	function st_body_class( $classes ) {
	
		global
			$st_Options,
			$st_Settings;
	
			// Alt styles
			$alt = !empty( $st_Settings['style'] ) ? $st_Settings['style'] : '';

			if ( $alt && $alt != 'light' )
				$classes[] = $alt;

			// StrictThemes font enabled
			if ( !empty( $st_Options['font-st'] ) == true )
				$classes[] = 'font-st';

			// Boxed layout
			if ( !empty( $st_Settings['layout_design'] ) && $st_Settings['layout_design'] == 'boxed' )
				$classes[] = 'boxed';

		return $classes;
	
	}
	
	add_filter( 'body_class', 'st_body_class' );



	/*-------------------------------------------
		3.4 - Attachments update
	-------------------------------------------*/

	function st_attachments_ajax_update( $ids = '' ) {

		if ( $ids )
			$ids = explode( ',', $ids );

		elseif ( !empty( $_POST['ids'] ) )
			$ids = wp_kses( $_POST['ids'], array() );

			if ( $ids ) {

				$return = '';
	
				$args = array(
					'post_type'			=> 'attachment',
					'post_status'		=> 'inherit',
					'post__in'			=> $ids,
					'post_mime_type'	=> 'image',
					'posts_per_page'	=> '-1',
					'orderby'			=> 'post__in'
				);
	
				$query = new WP_Query( $args );
		
				if ( $query->have_posts() ) {
		
					while ( $query->have_posts() ) {
		
						$query->the_post();
	
						$return .= '<li>';
	
							$thumbnail = wp_get_attachment_image_src( $query->post->ID, 'thumbnail');
							$return .= '<img src="' . $thumbnail[0] . '" width="60" height="60" />';
	
						$return .= '</li>';
		
					}
				
				}
				
				else {
		
					$return .= __( 'Nothing Found', 'stkit' );
		
				}

				echo $return;
	
				if ( !empty( $_POST['ids'] ) )
					exit();
		
			}

		return;

	}
	
	add_action( 'wp_ajax_attachments_update', 'st_attachments_ajax_update' );



	/*-------------------------------------------
		3.5 - Dequeue WP-Pagenavi stiles
	-------------------------------------------*/

	function st_pagenavi_dequeue_assets() {
	
		wp_deregister_style( 'wp-pagenavi' );
	
	}
	add_action( 'wp_print_styles', 'st_pagenavi_dequeue_assets', 100 );



/*= 4 ===========================================

	F U N C T I O N S
	Permanent custom functions

===============================================*/


	/*-------------------------------------------
		4.1 - Post views
	-------------------------------------------*/

	if ( !empty( $st_Settings['post_views'] ) && $st_Settings['post_views'] == 'yes' ) {

		// Display views
		function st_getPostViews( $postID ) {
	
			$count_key = 'post_views_count';
			$count = get_post_meta($postID, $count_key, true);
	
			if ( $count == '' ) {
	
				delete_post_meta( $postID, $count_key );
				add_post_meta( $postID, $count_key, '0' );
	
				return '';
	
			}
	
			return number_format( $count );
	
		}
	
		// Count views
		function st_setPostViews( $postID ) {
	
			$count_key = 'post_views_count';
			$count = get_post_meta( $postID, $count_key, true );
	
			if ( $count == '' ) {
	
				$count = 0;
	
				delete_post_meta( $postID, $count_key );
				add_post_meta( $postID, $count_key, '0' );
	
			} else {
	
				$count++;
	
				update_post_meta( $postID, $count_key, $count );
	
			}
	
		}

	}



	/*-------------------------------------------
		4.2 - Nice time
	-------------------------------------------*/

	if ( !empty( $st_Settings['nice_time'] ) && $st_Settings['nice_time'] == 'yes' ) {

		function st_niceTime( $time ) {
	
			$time = strtotime( str_replace( '+0000', '', $time ) );
			
			$delta = time() - $time;

			switch ( $delta ) {

				case ( $delta < 60  ) : return __( 'less than 1 minute ago', 'stkit' );
				case ( $delta < 120 ) : return __( '1 minute ago', 'stkit' );

				case ( $delta < ( 60  * 60 ) ) : return sprintf( __( '%d minutes ago', 'stkit' ), floor( $delta / 60 ) );
				case ( $delta < ( 120 * 60 ) ) : return __( '1 hour ago', 'stkit' );

				case ( $delta < ( 24 * 60 * 60 ) ) : return sprintf( __( '%d hours ago', 'stkit' ), floor( $delta / 3600 ) );
				case ( $delta < ( 48 * 60 * 60 ) ) : return __( '1 day ago', 'stkit' );

				case ( $delta < ( 30 * 24 * 60 * 60 ) ) : return sprintf( __( '%d days ago', 'stkit' ), floor( $delta / 86400 ) );
				case ( $delta < ( 60 * 24 * 60 * 60 ) ) : return __( '1 month ago', 'stkit' );

				case ( $delta < ( 12 * 30 * 24 * 60 * 60 ) ) : return sprintf( __( '%d months ago', 'stkit' ), floor( $delta / 2592000 ) );
				case ( $delta < ( 24 * 30 * 24 * 60 * 60 ) ) : return __( '1 year ago', 'stkit' );

				case ( $delta < ( 100 * 12 * 30 * 24 * 60 * 60 ) ) : return sprintf( __( '%d years ago', 'stkit' ), floor( $delta / 31104000 ) );

				default :

					if ( ( $delta / 86400 ) < 3650 )
						return sprintf( __( '%d days ago', 'stkit' ), floor( $delta / 86400 ) );
					else
						return '&mdash;';

			}
	
		}

	}



	/*-------------------------------------------
		4.3 - Icons the Social
	-------------------------------------------*/

	if ( !empty( $st_Settings['lifestream'] ) && $st_Settings['lifestream'] == 'yes' || !empty($st_Options['widgets']['social-icons']) ) {

		function st_icons_social() {
	
			global
				$st_Options,
				$st_Settings;
	
				$out = '<div class="icons-social">';
				
					// Icons selected
					foreach ( $st_Options['networks'] as $value ) {
						if ( $st_Settings[$value] ) {

							$value = substr( $value, 5 );

							$out .= "\n";
							$out .= '<a id="icon-' . $value . '" class="tooltip" title="' . $value . '" href="' . st_get_redirect_page_url() . esc_url( $st_Settings['life_' . $value] ) . '" target="_blank"><!-- --></a>';

						}
					}
	
					// Icons custom
					if ( !empty( $st_Settings['lifestream_custom'] ) && $st_Settings['lifestream_custom'] )
						$out .= $st_Settings['lifestream_custom'];
	
				$out .= '</div>';

				echo $out;
		
			return;
	
		}

	}



	/*-------------------------------------------
		4.4 - Path of custom.css file
	-------------------------------------------*/

	function st_get_custom_css( $type ) {

		global
			$st_Options;

			$upload = wp_upload_dir();

			if ( $type == 'path' )
				$path = $upload['basedir'] . '/' . $st_Options['general']['name'] . 'custom.css';

			if ( $type == 'url' )
				$path = $upload['baseurl'] . '/' . $st_Options['general']['name'] . 'custom.css';

		return $path;

	}



	/*-------------------------------------------
		4.5 - Get a first image from post
	-------------------------------------------*/

	function st_get_first_image( $id = 0 ) {

		if ( $id == 0 )
			global $post;

		else
			$post = get_post( $id );
	
			$src = '';
		
			ob_start();
		
			ob_end_clean();
		
			$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );
		
			if ( $matches[1] )
				$src = $matches[1][0] ? $matches[1][0] : '';
			
		return
			$src;

	}



	/*-------------------------------------------
		4.6 - Write Custom CSS
	-------------------------------------------*/

	function st_custom_css() {

		include ( plugin_dir_path( __FILE__ ) . '/write-custom-css.php' );

	}



	/*-------------------------------------------
		4.7 - Get 2x image URL
	-------------------------------------------*/

	function st_get_2x( $post_id, $image, $output = 'array', $class = '' ) {

		global
			$st_Options,
			$st_Settings;

			if ( $st_Options['panel']['misc']['hidpi'] && !isset( $st_Settings['hidpi'] ) || !empty( $st_Settings['hidpi'] ) != 'no' ) {
	
				$image2x = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $image . '-2x' );

				if ( $image2x ) {

					if ( $output == 'array' )
						return array( 'data-hidpi' => $image2x[0], 'class' => $class );

					if ( $output == 'url' )
						return $image2x[0];

					if ( $output == 'attr' )
						return 'data-hidpi="' . $image2x[0] . '"';

				}	

				else
					return;

			}

			else
				return;

	}



	/*-------------------------------------------
		4.8 - Get post format icon
	-------------------------------------------*/

	function st_get_format_icon( $post_id, $size = 16, $class = '', $color = 'white', $return = 'image' ) {

		global
			$st_Options,
			$st_Settings;

			$output = '';

			// Post type names
			$st_['st_post'] = !empty( $st_Settings['ctp_post'] ) ? $st_Settings['ctp_post'] : $st_Options['ctp']['post'];

			// Project format
			if ( get_post_type( $post_id ) == $st_['st_post'] ) {
				$format = st_get_post_meta( $post_id, 'format_value', true, 'gallery' ); }

			// Post format
			else {
				$format = ( get_post_format( $post_id ) && $st_Options['global']['post-formats'][get_post_format( $post_id )]['status'] ) ? get_post_format( $post_id ) : 'standard'; }

			$icons = array(
				'standard'	=> 'file-2',
				'image'		=> 'image',
				'gallery'	=> 'gallery',
				'audio'		=> 'audio',
				'video'		=> 'video',
				'link'		=> 'link',
				'quote'		=> 'quote',
				'status'	=> 'user'
			);

			foreach ( $icons as $key => $icon ) {
				if ( $format == $key ) {

					if ( $return == 'image' ) {

						$src = plugins_url() . '/stkit/assets/images/icons/' . $size . '/glyphs/' . $color . '/' . $icon . '.png';
	
						if ( $st_Options['panel']['misc']['hidpi'] && !isset( $st_Settings['hidpi'] ) || !empty( $st_Settings['hidpi'] ) != 'no' )
							$hidpi = 'data-hidpi="' . plugins_url() . '/stkit/assets/images/icons/' . $size * 2 . '/glyphs/' . $color . '/' . $icon . '.png"';
						else
							$hidpi = '';

						$output = '<img src="' . $src . '" width="' . $size . '" height="' . $size . '" ' . $hidpi . ' class="' . $class . '" alt="" />';

					}

					elseif ( $return == 'text' ) {

						$output = $icon;

					}

				}
			}

			return $output;

	}



	/*-------------------------------------------
		4.9 - Custom Background Callback
	-------------------------------------------*/

	function st_custom_background_cb() {

		global $st_;

		if ( is_single() ) {

			global
				$post;

				$st_['bg-image'] = wp_get_attachment_image_src( st_get_post_meta( $post->ID, 'bg-image_value', true, 0 ), 'full' );
				$st_['bg-color'] = st_get_post_meta( $post->ID, 'bg-color_value', true, false );

		}
		
		$background = !empty( $st_['bg-image'][0] ) ? $st_['bg-image'][0] : set_url_scheme( get_background_image() );
	
		$color = !empty( $st_['bg-color'] ) && $st_['bg-image'][0] ? $st_['bg-color'] : get_theme_mod( 'background_color' );
	
		if ( ! $background && ! $color ) {
			return; }
	
		$style = $color ? "background-color: #$color;" : '';
	
		if ( $background ) {
	
			$image = " background-image: url('$background');";
	
	
			$repeat = get_theme_mod( 'background_repeat', 'no-repeat' );
	
			if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) ) {
				$repeat = 'no-repeat';
			}
			$repeat = " background-repeat: $repeat;";
	
	
			$position = get_theme_mod( 'background_position_x', 'center' );
	
			if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) ) {
				$position = 'center';
			}
			$position = " background-position: top $position;";
	
	
			$attachment = get_theme_mod( 'background_attachment', 'fixed' );
	
			if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) ) {
				$attachment = 'fixed';
			}
			$attachment = " background-attachment: $attachment;";
	
	
			$style .= $image . $repeat . $position . $attachment;
	
		}
	
		echo '<style type="text/css" id="custom-background-css">body.custom-background { ' . trim( $style ) . ' }</style>' . "\n";
	
	}



	/*-------------------------------------------
		4.10 - Adjust Color Brightness
	-------------------------------------------*/

	function st_adjustBrightness( $hex, $steps ) {

		// Steps should be between -255 and 255. Negative = darker, positive = lighter
		$steps = max( -255, min( 255, $steps ) );
		
		// Format the hex color string
		$hex = str_replace( '#', '', $hex );

		if ( strlen($hex) == 3 )
			$hex = str_repeat( substr( $hex, 0, 1 ), 2 ).str_repeat( substr( $hex, 1, 1 ), 2 ).str_repeat( substr( $hex, 2, 1 ), 2 );
		
		// Get decimal values
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
		
		// Adjust number of steps and keep it inside 0 to 255
		$r = max( 0, min( 255, $r + $steps ) );
		$g = max( 0, min( 255, $g + $steps ) );  
		$b = max( 0, min( 255, $b + $steps ) );
		
		$r_hex = str_pad( dechex($r), 2, '0', STR_PAD_LEFT );
		$g_hex = str_pad( dechex($g), 2, '0', STR_PAD_LEFT );
		$b_hex = str_pad( dechex($b), 2, '0', STR_PAD_LEFT );
		
		return $r_hex . $g_hex . $b_hex;

	}



	/*-------------------------------------------
		4.11 - Related posts
	-------------------------------------------*/

	function st_related_posts( $qty = 4, $title = '', $h = 'h6', $image_size = 'project-thumb', $class = 'posts-related-wrapper' ) {

		global
			$post;

			$st_['args'] = array();
			$st_['postcount'] = 0;
			$st_['out'] = '';

			// if standard post (for non-CTP)
			if ( get_post_type( $post->ID ) == 'post' ) {

				// by format & category (for non-Standard format)
				if ( get_post_format( $post->ID ) ) {
	
					$st_['args'] = array(
						'post_type'				=>	'post',
						'posts_per_page'		=>	$qty,
						'order'					=>	'DESC',
						'orderby'				=>	'rand',
						'paged'					=>	1,
						'post_status'			=>	'publish',
						'post__not_in'			=>	array( $post->ID ),
						'ignore_sticky_posts'	=>	1,
						'tax_query'				=>	array(
														'relation'		=>	'AND',
														array(
															'taxonomy'	=>	'category',
															'field'		=>	'id',
															'terms'		=>	wp_get_post_categories( $post->ID ),
														),
														array(
															'taxonomy'	=>	'post_format',
															'field'		=>	'slug',
															'terms'		=>	array( 'post-format-' . get_post_format( $post->ID ) ),
														),
													),
					);
	
				}

				// get the query
				$st_query = get_transient( 'st_related_posts_' . $post->ID );

				if ( $st_query == false ) {
		
					$st_query = new WP_Query( $st_['args'] );
		
					set_transient( 'st_related_posts_' . $post->ID, $st_query, 60 * 60 * 24 );
		
				}
	
				// if query result is false -> get a posts (any format) by category
				if ( $st_query->found_posts == 0 ) {

					$st_['args'] = array(
						'post_type'				=>	'post',
						'posts_per_page'		=>	$qty,
						'order'					=>	'DESC',
						'orderby'				=>	'rand',
						'paged'					=>	1,
						'post_status'			=>	'publish',
						'post__not_in'			=>	array( $post->ID ),
						'ignore_sticky_posts'	=>	1,
						'tax_query'				=>	array(
														'relation'		=>	'AND',
														array(
															'taxonomy'	=>	'category',
															'field'		=>	'id',
															'terms'		=>	wp_get_post_categories( $post->ID ),
														),
														/*array(
															'taxonomy'	=>	'post_format',
															'field'		=>	'slug',
															'terms'		=>	array( 'post-format-aside', 'post-format-chat', 'post-format-gallery', 'post-format-link', 'post-format-image', 'post-format-quote', 'post-format-status', 'post-format-video', 'post-format-audio' ),
															'operator'	=> 'NOT IN',
														),*/
													),
					);

					// re-get the query
					$st_query = new WP_Query( $st_['args'] );

					set_transient( 'st_related_posts_' . $post->ID, $st_query, 60*60*24 );

				}



				while ( $st_query->have_posts() ) : $st_query->the_post();  
	
	
					// Post format
					$st_['format'] = get_post_format( $post->ID ) ? get_post_format( $post->ID ) : 'standard';
	
					$st_['postcount']++;
	
	
					// Feat image
					if ( has_post_thumbnail() ) {
				
						$st_['id'] = get_post_thumbnail_id( $post->ID );
						$st_['thumb'] = wp_get_attachment_image_src( $st_['id'], $image_size );
						$st_['thumb'] = $st_['thumb'][0];
				
					}
				
					else {
				
						$st_['thumb'] = get_template_directory_uri() . '/assets/images/placeholder.png';
				
					}
	
	
					// Compose post
					$st_['out'] .=  '<td><div class="posts-related-post-wrapper">';
			
						// Compose thumb
						$st_['out'] .=  '<a href="' . get_permalink() . '" class="post-thumb post-thumb-' . $st_['format'] . '" ' . ( function_exists( 'st_get_2x' ) ? st_get_2x( $post->ID, $image_size, 'attr' ) : '' ) . ' style="background-image: url(' . $st_['thumb'] . ')" data-format="' . $st_['format'] . '">&nbsp;</a>';
			
						// Other
						$st_['out'] .=  '<div class="posts-related-details-wrapper"><div>' .
	
							'<h5><a href="' . get_permalink() . '">' . get_the_title() . '</a></h5>';
	
						$st_['out'] .=  '</div></div>';
			
					$st_['out'] .=  '</div></td>' . "\n";
	
	
				endwhile;
	
				wp_reset_query();
	
	
				// Out
				if ( $st_['out'] ) {
	
					$title = $title ? "\n<" . $h . ">" . $title . "</" . $h . ">\n" : '';
	
					return '<div class="' . $class . ' posts-related-' . $qty . '-wrapper">' . $title . '<table><tbody><tr>' . $st_['out'] . '</tr></tbody></table><div class="clear"><!-- --></div></div>';
	
				}
				else
					return;


			}

	}



/*= 5 ===========================================

	W O O C O M M E R C E
	Custom things for WooCommerce

===============================================*/

function st_woocommerce() {

	if ( class_exists( 'WooCommerce' ) ) {

		global
			$st_Options,
			$st_Settings;


	/*-------------------------------------------
		5.1 - Add WooCommerce support
	-------------------------------------------*/

	add_theme_support( 'woocommerce' );


	/*-------------------------------------------
		5.2 - Remove WooCommerce prettyPhoto
	-------------------------------------------*/

	if (
		$st_Options['js']['prettyPhoto'] && empty( $st_Settings['prettyPhoto'] ) ||
		$st_Options['js']['prettyPhoto'] && !empty( $st_Settings['prettyPhoto'] ) && $st_Settings['prettyPhoto'] != 'no' ) {

		function st_remove_woo_lightbox() {
			remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'prettyPhoto-init' );
		}
	
		add_action( 'wp_enqueue_scripts', 'st_remove_woo_lightbox', 99 );

	}


	/*-------------------------------------------
		5.3 - Re-define number of products per row
	-------------------------------------------*/

	function st_loop_columns() {

		global
			$st_Options;

			return $st_Options['compatibility']['woocommerce']['per-row'];

	}

	add_filter( 'loop_shop_columns', 'st_loop_columns' );


	/*-------------------------------------------
		5.4 - Define image sizes
	-------------------------------------------*/

	global
		$pagenow;
	
	if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) {
		add_action( 'init', 'st_woocommerce_image_dimensions', 1 ); }
	
	function st_woocommerce_image_dimensions() {

		global
			$st_Options;

		$catalog = array(
			'width' 	=> $st_Options['compatibility']['woocommerce']['catalog'][0],
			'height'	=> $st_Options['compatibility']['woocommerce']['catalog'][1],
			'crop'		=> $st_Options['compatibility']['woocommerce']['catalog'][2],
		);

		$single = array(
			'width' 	=> $st_Options['compatibility']['woocommerce']['single'][0],
			'height'	=> $st_Options['compatibility']['woocommerce']['single'][1],
			'crop'		=> $st_Options['compatibility']['woocommerce']['single'][2],
		);

		$thumbnail = array(
			'width' 	=> $st_Options['compatibility']['woocommerce']['thumbnail'][0],
			'height'	=> $st_Options['compatibility']['woocommerce']['thumbnail'][1],
			'crop'		=> $st_Options['compatibility']['woocommerce']['thumbnail'][2],
		);
	 
		// Image sizes
		update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
		update_option( 'shop_single_image_size', $single ); 		// Single product image
		update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs

	}


	/*-------------------------------------------
		5.5 - Define number of products per page
	-------------------------------------------*/

	add_filter( 'loop_shop_per_page', create_function( '$cols', 'return ' . ( !empty( $st_Settings['products_qty'] ) ? $st_Settings['products_qty'] : $st_Options['compatibility']['woocommerce']['qty'] ) . ';' ), 20 );


	/*-------------------------------------------
		5.6 - Define number of related products
	-------------------------------------------*/

	function woo_related_products_limit() {
	
	  global
		$product,
		$st_Options;
		
		$args = array(
			'post_type'        		=> 'product',
			'posts_per_page'   		=> $st_Options['compatibility']['woocommerce']['related'],
			'ignore_sticky_posts' 	=> 1,
			'post__not_in'        	=> array( $product->id )
		);
	
		return $args;
	
	}
	
	add_filter( 'woocommerce_output_related_products_args', 'woo_related_products_limit' );


	/*-------------------------------------------
		5.7 - Register CSS
	-------------------------------------------*/

	if ( !is_admin() ) {

		function st_woocommerce_styles() {

			if ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() )
				wp_enqueue_style( 'st-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css', false, null, 'all' );
	
		}

		add_action( 'wp_enqueue_scripts', 'st_woocommerce_styles', 30 );

	}


	/*-------------------------------------------
		5.8 - Remove JS & CSS from irrelevant pages
	-------------------------------------------*/

	function st_woocommerce_dequeue_assets() {

		if ( function_exists( 'is_woocommerce' ) ) {

			if ( !is_woocommerce() && !is_cart() && !is_checkout() && !is_account_page() ) {

				wp_dequeue_style( 'woocommerce-layout' );
				wp_dequeue_style( 'woocommerce-smallscreen' );
				wp_dequeue_style( 'woocommerce-general' );

				wp_dequeue_script( 'wc-add-to-cart' );
				wp_dequeue_script( 'jquery-blockui' );
				wp_dequeue_script( 'jquery-placeholder' );
				wp_dequeue_script( 'woocommerce' );
				wp_dequeue_script( 'jquery-cookie' );
				wp_dequeue_script( 'wc-cart-fragments' );

			}

		}

	}
				
	if ( !empty( $st_Settings['wooc_assets'] ) && $st_Settings['wooc_assets'] == 'yes' )
		add_action( 'wp_enqueue_scripts', 'st_woocommerce_dequeue_assets', 100 );


	} // if ( class_exists( 'WooCommerce' ) )

} // function st_woocommerce()


?>