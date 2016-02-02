<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - SHORTCODES

		1.1 - Columns
		1.2 - Lists
		1.3 - Button
		1.4 - Alerts & Messages
		1.5 - Highlight
		1.6 - Dropcap
		1.7 - Pull Quotes
		1.8 - Toggle
		1.9 - Accordion
		1.10 - Tabs
		1.11 - Tooltip
		1.12 - Google map
		1.13 - Pricing Table
		1.14 - Sidebar
		1.15 - Clear
		1.16 - Notice
		1.17 - Skill
		1.18 - Icon Box
		1.19 - ST Gallery
		1.20 - ST Gravatar

*/

/*===============================================

	S H O R T C O D E S
	Common shortcodes

===============================================*/

	global
		$st_Framework,
		$st_Options;


	/*-------------------------------------------
		1.1 - Columns
	-------------------------------------------*/

	if ( $st_Options['shortcodes']['column'] ) {

		function st_column( $atts, $content = null ) {
	
			extract(
				shortcode_atts(
					array(
						'size'		=> '1/2',
						'margin'	=> 'default'
					),
					$atts
				)
			);

			$size = 'column-' . str_replace( '/', '-', $size );

			$margin = $margin != 'default' ? ' style="margin-right: ' . $margin . 'px;"' : '';

			return '<div class="column ' . $size . '"><div' . $margin . '>' . wpautop( do_shortcode( $content ) ) . '</div></div>';

		}
	
		add_shortcode( 'column', 'st_column' );

	}


	/*-------------------------------------------
		1.2 - Lists
	-------------------------------------------*/

	if ( $st_Options['shortcodes']['ul'] ) {

		function st_ul( $atts, $content = null ) {
	
			extract(
				shortcode_atts(
					array(
						'type' => 'arrow-right'
					),
					$atts
				)
			);
	
			return str_replace( '<ul>', '<ul class="list list-' . $type . '">', do_shortcode( $content ) );
	
		}
	
		add_shortcode( 'ul', 'st_ul' );

	}


	/*-------------------------------------------
		1.3 - Button
	-------------------------------------------*/

	if ( $st_Options['shortcodes']['button'] ) {

		function st_button( $atts, $content = null ) {
	
			extract(
				shortcode_atts(
					array(
						'url'			=> '#',
						'color'			=> '',
						'size'			=> '',
						'radius'		=> '',
						'target'		=> 'parent',
						'icon'			=> '',
						'icon_size'		=> '16',
						'class'			=> '',
					),
					$atts
				)
			);

			$style = '';

			global
				$st_Options;

				// Select classes
				if ( empty( $st_Options['font-st'] ) || $st_Options['font-st'] == false )
					$class .= ' button';
	
				else
					$class .= ' button-st';
	
				if ( $color || $size || $radius || $icon ) {
	
					// Prepare style
					$style .= ' style="';
		
						$style .= $color ? 'background-color: #' . $color . ';' : '';
			
						$style .= $size ? ' font-size:' . $size . 'px;' : '';
			
						$style .= $radius ? ' border-radius:' . $radius . 'px;' : '';
	
						if ( empty( $st_Options['font-st'] ) || $st_Options['font-st'] == false )
							$style .= $icon ? ' background-image: url(' . plugins_url() . '/stkit/assets/images/icons/' . $icon_size . '/glyphs/white/' . $icon . '.png);' : '';
	
					$style .= '"';
	
					// Add classes
					if ( $icon ) {
						$class .= ' button-with-icon button-with-icon-' . $icon_size;
	
						if ( empty( $st_Options['font-st'] ) || $st_Options['font-st'] == false )
							$class .= ' button-with-icon-' . $icon_size;
	
						else
							$class .= ' ico-st ico-' . $icon;
	
					}
	
					if ( $color )
						$class .= ' button-custom-color';
	
				}

			return '<a class="' . $class . '" href="' . $url . '" target="_' . $target . '"' . $style . '>' . $content . '</a>';
	
		}
	
		add_shortcode( 'button', 'st_button' );

	}


	/*-------------------------------------------
		1.4 - Alerts & Messages
	-------------------------------------------*/

	if ( $st_Options['shortcodes']['alert'] ) {

		function st_alert ( $atts, $content = null ) {
	
			extract(
				shortcode_atts(
					array(
						'type'		=> 'notice'
					),
					$atts
				)
			);
	
			$pre = array(
				'notice'	=> __( 'Notice this:', 'stkit' ),
				'warning'	=> __( 'Warning!', 'stkit' ),
				'success'	=> __( 'Well done!', 'stkit' ),
				'error'		=> __( 'Oh snap!', 'stkit' ),
				'info'		=> __( 'Heads up!', 'stkit' )
			);
	
			return '<div class="alert alert-' . $type . '"><strong>' . $pre[$type] . '</strong> ' . $content . '<span class="ico-st alert-close"><!-- --></span><div class="clear"><!-- --></div></div>';
	
		}
	
		add_shortcode( 'alert', 'st_alert' );

	}


	/*-------------------------------------------
		1.5 - Highlight
	-------------------------------------------*/

	if ( $st_Options['shortcodes']['highlight'] ) {

		function st_highlight( $atts = null, $content = null ) {
	
			return '<span class="highlight">' . $content . '</span>';
	
		}
	
		add_shortcode( 'highlight', 'st_highlight' );

	}


	/*-------------------------------------------
		1.6 - Dropcap
	-------------------------------------------*/

	if ( $st_Options['shortcodes']['dropcap'] ) {

		function st_dropcap( $atts = null, $content = null ) {
	
			return '<div class="dropcap">' . $content . '</div>';
	
		}
	
		add_shortcode( 'dropcap', 'st_dropcap' );

	}


	/*-------------------------------------------
		1.7 - Pull Quotes
	-------------------------------------------*/

	if ( $st_Options['shortcodes']['pullquote'] ) {

		function st_pullquote( $atts, $content = null ) {
	
			extract(
				shortcode_atts(
					array(
						'align'		=> 'left'
					),
					$atts
				)
			);
	
			return '<div class="pullquote pullquote-' . $align . '">' . $content . '</div>';
	
		}
	
		add_shortcode( 'pullquote', 'st_pullquote' );

	}


	/*-------------------------------------------
		1.8 - Toggle
	-------------------------------------------*/

	if ( $st_Options['shortcodes']['toggle'] ) {

		function st_toggle( $atts, $content = null ) {
	
			extract(
				shortcode_atts(
					array(
						'title'		=> 'Toggle',
						'status'	=> 'closed'
					),
					$atts
				)
			);
	
			$class = $status == 'opened' ? 'toggle-opened' : 'toggle-closed';
	
			$out = '<div class="toggle ' . $class . '">';
	
				$out .= '<div class="toggle-title"><span class="ico-st"><!-- --></span>' . $title . '</div>';
		
				$out .= '<div class="toggle-holder"><div class="toggle-box">' . do_shortcode( $content ) . '</div></div>';
	
			$out .= '</div>';
	
			return $out;
	
		}
	
		add_shortcode( 'toggle', 'st_toggle' );

	}


	/*-------------------------------------------
		1.9 - Accordion
	-------------------------------------------*/

	if ( $st_Options['shortcodes']['accordion'] ) {

		function st_accordion( $atts = null, $content = null ) {
	
	
			return '<div class="accordion">' . wpautop( do_shortcode( $content ) ) . '</div>';
	
		}
	
		add_shortcode( 'accordion', 'st_accordion' );

	}


	/*-------------------------------------------
		1.10 - Tabs
	-------------------------------------------*/

	if ( $st_Options['shortcodes']['tabs'] ) {

		function st_tabs( $atts, $content = null ) {
	
			extract(
				shortcode_atts(
					array(
						'labels' => ''
					),
					$atts
				)
			);
	
			if ( $labels ) :
	
	
				// Tabs
				$out = '<div class="st-tabs-holder"><ul class="st-ul">';
	
					$labels = explode(",", $labels);
		
						foreach ( $labels as $key ) {
		
							if ( $key && $key != ' ' )
								$out .= '<li>' . $key . '</li>';
		
						}
	
				$out .= '</ul>';
	
	
				// Content
				$out .= '<div class="st-tabs">' . do_shortcode( $content ) . '</div></div>';
	
	
			else :
	
				$out = '<p>' . __('The labels have not been selected.','stkit') . '</p>';
	
			endif;
	
	
			return $out;
	
		}
	
		function st_t( $atts, $content = null ) {
	
			return '<div>' . wpautop( do_shortcode( $content ) ) . '</div>';
	
		}
	
		add_shortcode( 'tabs', 'st_tabs' );
		add_shortcode( 't', 'st_t' );

	}


	/*-------------------------------------------
		1.11 - Tooltip
	-------------------------------------------*/

	/* N/A */


	/*-------------------------------------------
		1.12 - Google maps
	-------------------------------------------*/

	if ( $st_Options['shortcodes']['googlemap'] ) {

		function st_googleMap( $atts, $content = null ) {
	
			extract(
				shortcode_atts(
					array(
						'width'		=> '100%',
						'height'	=> '300px',
						'address'	=> 'New York, United States',
						'zoom'		=> 10
					),
					$atts
				)
			);
	
		   return '<div id="googlemaps" class="google-map google-map-full" style="height:' . $height . '; width:' . $width . '"></div>
				<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
				<script src="' . plugins_url() . '/stkit/components/shortcodes/assets/js/jquery.gmap.min.js"></script>
				<script type="text/javascript">
				   jQuery("#googlemaps").gMap({
					maptype: "ROADMAP",
					scrollwheel: false,
					zoom: ' . $zoom . ',
					markers: [
					{
						address: \''.$address.'\',
						html: "",
						popup: false,
					}
					],
				});
				</script>';
	
		}
	
		add_shortcode( 'googlemap', 'st_googleMap' );

	}


	/*-------------------------------------------
		1.13 - Pricing Table
	-------------------------------------------*/

	if ( $st_Options['shortcodes']['pricing-table'] ) {

		function st_pricing_table( $atts, $content = null ) {
	
			extract(
				shortcode_atts(
					array(
						'size'		=> '1/2',
						'style'		=> 'dark', // gray, dark, featured
						'title'		=> '&nbsp;',
						'price'		=> '$0',
						'comment'	=> '&nbsp;',
						'button'	=> 'Purchase',
						'link'		=> '#',
						'target'	=> 'parent'
					),
					$atts
				)
			);

			global
				$st_Options;

			$table = '<div class="pricing-table pricing-table-' . $style . '">';
	
				// Title
				$table .= '<div class="pricing-table-title">' . $title . '</div>';
	
				// Price & Comment
				$table .= '<div class="pricing-table-price">' . $price . '<div class="pricing-table-comment">' . $comment . '</div></div>';
	
				// Content
				$table .= '<div class="pricing-table-content">' . $content . '</div>';
	
				// Button
				$table .= '<div class="pricing-table-button"><a class="' . ( !empty( $st_Options['font-st'] ) == true ? 'button-st' : 'button' ) . '" href="' . $link . '" target="_' . $target . '">' . $button . '</a></div>';
	
			$table .= '</div>';
	
			$out = do_shortcode('[column margin=0 size=' . $size . ']' . $table . '[/column]');
	
			return $out;
	
		}
	
		add_shortcode( 'pricing-table', 'st_pricing_table' );

	}


	/*-------------------------------------------
		1.14 - Sidebar
	-------------------------------------------*/

	if ( $st_Options['shortcodes']['sidebar'] ) {

		function st_sidebar( $atts ) {
	
			extract(
				shortcode_atts(
					array(
						'label' => ''
					),
					$atts
				)
			);
	
			ob_start();
	
				dynamic_sidebar( $label );
				$sidebar = ob_get_contents();
	
			ob_end_clean();
	
			return '<div class="sidebar sidebar-shortcode">' . $sidebar . '</div>';
	
		}
	
		add_shortcode ( 'sidebar', 'st_sidebar' );

	}


	/*-------------------------------------------
		1.15 - Clear
	-------------------------------------------*/

	if ( $st_Options['shortcodes']['clear'] ) {

		function st_clear( $atts, $content = null ) {
	
			extract(
				shortcode_atts(
					array(
						'h' => ''
					),
					$atts
				)
			);
	
			$out = $h ? '<div class="clear" style="height:' . $h . 'px !important;"><!-- --></div>' : '<div class="clear"><!-- --></div>';
	
			return $out;
	
		}
	
		add_shortcode( 'clear', 'st_clear' );

	}


	/*-------------------------------------------
		1.16 - Notice
	-------------------------------------------*/

	if ( $st_Options['shortcodes']['notice'] ) {

		function st_notice( $atts, $content = null ) {

			extract(
				shortcode_atts(
					array(
						'align'		=> '',
						'class'		=> '',
					),
					$atts
				)
			);

			$align = $align ? 'align-' . $align : '';

			return '<div class="notice ' . $align . ' ' . $class . '">' . do_shortcode( $content . '[clear]' ) . '</div>';
	
		}
	
		add_shortcode ( 'notice', 'st_notice' );

	}


	/*-------------------------------------------
		1.17 - Skill
	-------------------------------------------*/

	if ( $st_Options['shortcodes']['skill'] ) {

		function st_skill( $atts, $content = null ) {
	
			extract(
				shortcode_atts(
					array(
						'progress'	=> '90',
						'start'		=> 'scroll', // auto, scroll
					),
					$atts
				)
			);
	
			$out = '<div class="skill">';
	
				$out .= '<div class="skill-bar skill-' . $start . '" data-progress="' . $progress . '"><!-- progress bar --></div>';
	
				$out .= '<div class="skill-label">' . $content . ' <span>' . $progress . '%</span></div>';
	
			$out .= '</div>';
	
			return $out;
	
		}
	
		add_shortcode ( 'skill', 'st_skill' );

	}


	/*-------------------------------------------
		1.18 - Icon Box
	-------------------------------------------*/

	if ( $st_Options['shortcodes']['icon-box'] ) {

		function st_icon_box( $atts, $content = null ) {

			extract(
				shortcode_atts(
					array(
						'icon'	=> 'check',
						'color'	=> 'gray',
						'size'	=> 32,
						'width'	=> '1/2',
					),
					$atts
				)
			);

			global
				$st_Options;

				$style = '';

				// Prepare style
				if ( empty( $st_Options['font-st'] ) || $st_Options['font-st'] == false ) {
					$style = ' style="background-image: url(' . plugins_url() . '/stkit/assets/images/icons/' . $size . '/glyphs/' . $color . '/' . $icon . '.png)"';
					$class = '';
				}
				else {
					$class = ' ico-st ico-' . $icon;
				}
	
				return do_shortcode( '[column size=' . $width . ']<div class="st_icon_box st_icon_box_' . $size . $class . '"' . $style . '>' . wpautop( do_shortcode( $content ) ) . '</div>[/column]' );
	
		}
	
		add_shortcode ( 'icon-box', 'st_icon_box' );

	}


	/*-------------------------------------------
		1.19 - ST Gallery
	-------------------------------------------*/

	if ( $st_Options['shortcodes']['gallery'] ) {

		function st_gallery( $atts, $content = null ) {

			extract(
				shortcode_atts(
					array(
						'ids'		=> '',
						'size'		=> '',
						'location'	=> 'main',
						'class'		=> ''
					),
					$atts
				)
			);
	
			if ( $ids ) {
	
				global
					$st_Options,
					$st_Settings,
					$content_width;

					$ids = explode( ',', $ids );
					$sizes = array();
					$images = "\n";
					$image = '';
					$image2x = '';

					if ( $location == 'main' ) {

						if ( $size == '' ) {

							$names = array( 'post-image', 'archive-image', 'large' );
		
							foreach ( $names as $key )
								$sizes[] = $st_Options['global']['images'][$key]['width'];
		
							foreach ( $sizes as $value ) {
		
								if ( $content_width <= $value ) {
		
									$size = $value;
		
									break;
		
								}
		
							}

						}

						foreach ( $ids as $id ) {

							$image = wp_get_attachment_image_src( $id, array( $size, 9999 ) );
	
							if ( $st_Options['panel']['misc']['hidpi'] && !isset( $st_Settings['hidpi'] ) || !empty( $st_Settings['hidpi'] ) != 'no' ) {
	
								$src2x = wp_get_attachment_image_src( $id, array( $size * 2, 9999 ) );
	
								$image2x = ' data-hidpi="' . $src2x[0] . '"';
	
							}
	
							$images .= '<img class="st-gallery-pending" src="' . $image[0] . '"' . $image2x . ' alt="" />' . "\n";
	
						}
	
					}

					return "\n" . '<div class="st-gallery' . ( $class ? ' ' . $class : '' ) . '">' . $images . '</div>';

			}
	
			return;

		}

		add_shortcode ( 'st-gallery', 'st_gallery' );

	}


	/*-------------------------------------------
		1.20 - ST Gravatar
	-------------------------------------------*/

	if ( !empty( $st_Options['shortcodes']['gravatar'] ) ) {

		function st_gravatar( $atts, $content = null ) {
	
			extract(
				shortcode_atts(
					array(
						'size'	=> '100',
						'email'	=> get_option( 'admin_email', 'doe@strictthemes.com' ),
						'class'	=> '',
					),
					$atts
				)
			);
	
			return '<div class="shortcode-gravatar ' . $class . '">' . get_avatar( $email, $size ) . '</div>';
	
		}
	
		add_shortcode ( 'st-gravatar', 'st_gravatar' );

	}


?>