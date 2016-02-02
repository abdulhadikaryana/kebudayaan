<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	version 1.1

	ST Sharrre WordPress widget based on Sharrre jQuery plugin 
	created by Julien Hany, http://sharrre.com

*/

	function widget_sharrre_multi_register() {
		
		$prefix = 'sharrre-multi';

		$name = 'ST Sharrre';

		$widget_ops = array(
			'classname'		=> 'widget_sharrre_multi',
			'description'	=> __( 'ST Sharrre is a nice widgets sharing for Facebook, Twitter, Google Plus (with PHP script) and more.', 'stkit' )
			);

		$control_ops = array(
			'width'			=> 200,
			'height'		=> 200,
			'id_base'		=> $prefix
			);
		
		$options = get_option( 'widget_sharrre_multi' );

		if ( isset( $options[0] ) )
			unset( $options[0] );
		
		if ( !empty( $options ) ) {

			foreach ( array_keys( $options ) as $widget_number ) {

				wp_register_sidebar_widget( $prefix . '-' . $widget_number, $name, 'widget_sharrre_multi', $widget_ops, array( 'number' => $widget_number ) );
				wp_register_widget_control( $prefix . '-' . $widget_number, $name, 'widget_sharrre_multi_control', $control_ops, array( 'number' => $widget_number ) );
	
			}

		} else {

			$options = array();
			$widget_number = 1;

			wp_register_sidebar_widget( $prefix . '-' . $widget_number, $name, 'widget_sharrre_multi', $widget_ops, array( 'number' => $widget_number ) );
			wp_register_widget_control( $prefix . '-' . $widget_number, $name, 'widget_sharrre_multi_control', $control_ops, array( 'number' => $widget_number ) );

		}

	}
	add_action( 'widgets_init', 'widget_sharrre_multi_register' );



/*===============================================

	C O N T R O L S
	Widget controls

===============================================*/

	function widget_sharrre_multi_control( $args ) {
	
		$prefix = 'sharrre-multi';
		
		$options = get_option('widget_sharrre_multi');

		if ( empty( $options ) )
			$options = array();

		if ( isset( $options[0] ) )
			unset( $options[0] );
			
		// update options array
		if ( !empty( $_POST[$prefix] ) && is_array( $_POST ) ) {

			foreach ( $_POST[$prefix] as $widget_number => $values ) {

				if ( empty( $values ) && isset( $options[$widget_number] ) ) // user clicked cancel
					continue;
				
				if ( !isset( $options[$widget_number] ) && $args['number'] == -1 ) {

					$args['number'] = $widget_number;
					$options['last_number'] = $widget_number;

				}

				$options[$widget_number] = $values;

			}
			
			// update number
			if ( $args['number'] == -1 && !empty($options['last_number'] ) )
				$args['number'] = $options['last_number'];

			// clear unused options and update options in DB. return actual options array
			$options = st_smart_multiwidget_update( $prefix, $options, $_POST[$prefix], $_POST['sidebar'], 'widget_sharrre_multi' );

		}
		
		$number = ( $args['number'] == -1 ) ? '%i%' : $args['number'];
	
		// Vars
		$opts = @$options[$number];
		$title = @$opts['title'];
		$networks = array(
			'googlePlus',
			'facebook',
			'twitter',
			'digg',
			'delicious',
			'stumbleupon',
			'linkedin',
			'pinterest'
		);

		foreach ( $networks as $key )
			$$key = @$opts[$key];

		?>

			<fieldset class="panel-fieldset metabox-fieldset"><legend><?php _e( 'Title', 'stkit' ) ?></legend>

				<input type="text" name="<?php echo $prefix . '[' . $number; ?>][title]" value="<?php echo $title; ?>" />
				<small><?php _e( 'Widget title.', 'stkit' ); ?></small>

			</fieldset>

			<fieldset class="panel-fieldset metabox-fieldset"><legend><?php _e( 'Buttons', 'stkit' ) ?></legend>

				<?php
	
					foreach ( $networks as $key ) {

						$checked = $$key == 'yes' ? 'checked' : '';

						echo '<p><label><input type="checkbox" name="' . $prefix . '[' . $number . '][' . $key . ']" value="yes"' . $checked . ' /> ' . ucwords( $key ) . '</label></p>';

					}
	
				?>

			</fieldset>

		<?php
	}



/*===============================================

	O U T P U T
	Widget output

===============================================*/

	function widget_sharrre_multi( $args, $vars = array() ) {

		extract( $args );

		$widget_number = (int)str_replace( 'sharrre-multi-', '', @$widget_id );

		$options = get_option('widget_sharrre_multi');

		if( !empty( $options[$widget_number] ) )
			$vars = $options[$widget_number];

		// Vars
		global
			$wp_query;

		$title = $vars['title'];
		$networks = array(
			'googlePlus',
			'facebook',
			'twitter',
			'digg',
			'delicious',
			'stumbleupon',
			'linkedin',
			'pinterest'
		);

		foreach ( $networks as $key )
			if ( isset( $vars[$key] ) )
				$$key = $vars[$key];

		$lang = get_bloginfo( 'language' );
		$lang_ = str_replace('-', '_', $lang );
		$la = explode( '-', $lang );
		$data_url = '';
		$data_text = '';
		$image = '';
		$desc = '';
		$is = false;

		// Post or Page
		if ( is_page() || is_single() ) {

			$is = true;
			$data_url = get_permalink( $wp_query->post->ID );
			$data_text = wptexturize( wp_kses( $wp_query->post->post_title, array() ) );
			$featured = wp_get_attachment_image_src( get_post_thumbnail_id( $wp_query->post->ID ), 'large' );
			$image = $featured[0] ? $featured[0] : st_get_first_image( $wp_query->post->ID );
			$desc = wptexturize( wp_kses( $wp_query->post->post_excerpt, array() ) );

		}

		// Term
		elseif ( !empty( $wp_query->queried_object->taxonomy ) ) {

			$is = true;
			$term = get_term( $wp_query->queried_object->term_id, $wp_query->queried_object->taxonomy );
			$data_url = get_term_link ( $term->term_id, $term->taxonomy );
			$data_text = wptexturize( wp_kses( $term->name, array() ) );
			$desc = wptexturize( wp_kses( $term->description, array() ) );

		}

		if ( $is == false )
			return;

			// Script on footer
			if ( !wp_script_is( 'sharrre', $list = 'registered' ) ) {
	
				wp_register_script( 'sharrre', plugins_url() . '/stkit/components/widgets/assets/plugins/sharrre/jquery.sharrre.min.js', false, null, true, true );
				wp_enqueue_script( array('sharrre'), false, null, true, true );
	
			}

			// Make a custom $before_widget
			$before_widget = '<div class="widget widget-sharrre">';

			// Output
			echo $before_widget;
	
				if( !empty( $vars['title'] ) )
					echo $before_title . $title . $after_title ;

				echo '<div class="sharrre_wrapper">';

					foreach ( $networks as $key )
						if ( isset( $$key ) && $$key == 'yes' )
							echo "\n" .
								'<div id="sharrre_' . $key . '" class="sharrre" data-url="' . $data_url . '" data-text="' . $data_text . '" data-title="' . ucwords( $key ) . '">' .
									'<a href="#" class="box"><div class="count">0</div><div class="share"><span></span>' . ucwords( $key ) . '</div></a>' .
								'</div>';

					?>
	
					<script type="text/javascript">
					
						var sh = jQuery.noConflict();
						
						sh(function(){
	
							<?php
	
								foreach ( $networks as $key ) {
									if ( isset( $vars[$key] ) && $$key == 'yes' ) {	?>

										sh('#sharrre_<?php echo $key; ?>').sharrre({
											share: { <?php echo $key; ?>: true },
											template: '<a class="box" href="#"><div class="count" href="#">{total}</div><div class="share"><span></span><?php echo ucwords( $key ); ?></div></a>',
											enableHover: false,
											click: function( api, options ){
												api.simulateClick();
												api.openPopup('<?php echo $key; ?>');
											},
											<?php if ( $key == 'googlePlus' ) { ?>
												urlCurl: '<?php echo plugins_url(); ?>/stkit/components/widgets/assets/plugins/sharrre/sharrre.php',
											<?php } ?>
											buttons: {
												<?php
													if ( $key == 'googlePlus' ) { ?>
														googlePlus : {
															url: '<?php echo $data_url ?>',
															urlCount: false,
															size: 'medium',
															lang: '<?php echo $lang ?>',
															annotation: '<?php echo $desc ?>'
														}, <?php
													}
													if ( $key == 'facebook' ) { ?>
														facebook: {
															url: '<?php echo $data_url ?>',
															urlCount: false,
															action: 'like',
															layout: 'button_count',
															width: '',
															send: 'false',
															faces: 'false',
															colorscheme: '',
															font: '',
															lang: '<?php echo $lang_ ?>'
														}, <?php
													}
													if ( $key == 'twitter' ) { ?>
														twitter: {
															url: '<?php echo $data_url ?>',
															urlCount: false,
															count: 'horizontal',
															hashtags: '',
															via: '',
															related: '',
															lang: '<?php echo $la[0] ?>'
															}, <?php
													}
													if ( $key == 'digg' ) { ?>
														digg: {
															url: '<?php echo $data_url ?>',
															urlCount: false,
															type: 'DiggCompact'
														}, <?php
													}
													if ( $key == 'delicious' ) { ?>
														delicious: {
															url: '<?php echo $data_url ?>',
															urlCount: false,
															size: 'medium'
														}, <?php
													}
													if ( $key == 'stumbleupon' ) { ?>
														stumbleupon: {
															url: '<?php echo $data_url ?>',
															urlCount: false,
															layout: '1'
														}, <?php
													}
													if ( $key == 'linkedin' ) { ?>
														linkedin: {
															url: '<?php echo $data_url ?>',
															urlCount: false,
															counter: ''
														}, <?php
													}
													if ( $key == 'pinterest' ) { ?>
														pinterest: {
															url: '<?php the_permalink() ?>',
															media: '<?php echo $image ?>',
															description: '<?php echo $desc ?>',
															layout: 'horizontal'
														} <?php
													}
												?>
											}
										});<?php
	
									}
	
								}
	
							?>
	
						});
					
					</script><?php

				echo '</div>';
	
			echo $after_widget;

	}


	/*-------------------------------------------
		Helper Function
	-------------------------------------------*/

	if ( !function_exists('st_smart_multiwidget_update') ) :

		function st_smart_multiwidget_update( $id_prefix, $options, $post, $sidebar, $option_name = '' ) {

			global
				$wp_registered_widgets;

			static $updated = false;
	
			$sidebars_widgets = wp_get_sidebars_widgets();

			if ( isset( $sidebars_widgets[$sidebar] ) ) :

				$this_sidebar =& $sidebars_widgets[$sidebar];

			else :

				$this_sidebar = array();

			endif;
			
			foreach ( $this_sidebar as $_widget_id ) :

				if ( preg_match( '/' . $id_prefix . '-([0-9]+)/i', $_widget_id, $match ) ) :

					$widget_number = $match[1];
					
					if ( !in_array( $match[0], $_POST['widget-id'] ) ) :

						unset( $options[$widget_number] );

					endif;

				endif;

			endforeach;
			
			if ( !empty($option_name) ) :

				update_option($option_name, $options);

				$updated = true;

			endif;
			
			return $options;

		}

	endif;


?>