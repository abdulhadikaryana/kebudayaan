<?php

/*

	1 - WIDGET

		- Function
		- Widget Controls
		- Widget Output
		- Widget Helper Function

	2 - SHORTCODE

*/


/*===============================================

	W I D G E T
	AdSense widget

===============================================*/

	/*-------------------------------------------
		Function
	-------------------------------------------*/

	function widget_adsense_multi_register() {
		
		$prefix = 'adsense-multi';
	
		$name = 'ST AdSense';
	
		$widget_ops = array(
			'classname'		=> 'widget_adsense_multi',
			'description'	=> __( 'Responsive AdSense units.', 'stkit' )
			);
	
		$control_ops = array(
			'width'			=> 200,
			'height'		=> 200,
			'id_base'		=> $prefix
			);
		
		$options = get_option( 'widget_adsense_multi' );
	
		if ( isset( $options[0] ) )
			unset( $options[0] );
		
		if ( !empty( $options ) ) {
	
			foreach ( array_keys( $options ) as $widget_number ) {
	
				wp_register_sidebar_widget( $prefix . '-' . $widget_number, $name, 'widget_adsense_multi', $widget_ops, array( 'number' => $widget_number ) );
				wp_register_widget_control( $prefix . '-' . $widget_number, $name, 'widget_adsense_multi_control', $control_ops, array( 'number' => $widget_number ) );
	
			}
	
		} else {
	
			$options = array();
			$widget_number = 1;
	
			wp_register_sidebar_widget( $prefix . '-' . $widget_number, $name, 'widget_adsense_multi', $widget_ops, array( 'number' => $widget_number ) );
			wp_register_widget_control( $prefix . '-' . $widget_number, $name, 'widget_adsense_multi_control', $control_ops, array( 'number' => $widget_number ) );
	
		}
	
	}
	add_action('init', 'widget_adsense_multi_register');


	/*-------------------------------------------
		Widget Controls
	-------------------------------------------*/

	function widget_adsense_multi_control($args) {

		$prefix = 'adsense-multi';
		
		$options = get_option('widget_adsense_multi');

		if ( empty( $options ) )
			$options = array();

		if ( isset( $options[0] ) )
			unset($options[0]);
			
		if ( !empty($_POST[$prefix]) && is_array($_POST) ) {

			foreach ($_POST[$prefix] as $widget_number => $values) {

				if ( empty( $values ) && isset( $options[$widget_number] ) ) // user clicked cancel
					continue;
				
				if ( !isset( $options[$widget_number] ) && $args['number'] == -1 ) {

					$args['number'] = $widget_number;
					$options['last_number'] = $widget_number;

				}

				$options[$widget_number] = $values;

			}

			// update number
			if ( $args['number'] == -1 && !empty($options['last_number']) )
				$args['number'] = $options['last_number'];

			// clear unused options and update options in DB. return actual options array
			$options = st_smart_multiwidget_update( $prefix, $options, $_POST[$prefix], $_POST['sidebar'], 'widget_adsense_multi' );

		}
		
		$number = ($args['number'] == -1) ? '%i%' : $args['number'];
	
		// Vars
		$opts = @$options[$number];
		$slot = @$opts['slot'];
		$type = @$opts['type'] ? @$opts['type'] : array();

		// Sizes
		$sizes = array(
				'980x120',
				'970x90',
				'930x180',
				'750x300',
				'750x200',
				'750x100',
				'728x90',
				'580x400',
				'468x60',
				'336x280',
				'320x100',
				'320x50',
				'300x600',
				'300x250',
				'250x360',
				'250x250',
				'240x400',
				'234x60',
				'200x200',
				'180x150',
				'160x600',
				'125x125',
				'120x600',
				'120x240',
			);

		?>

			<fieldset class="panel-fieldset metabox-fieldset">
				<legend><?php _e( 'Slot', 'stkit' ) ?></legend>

					<input type="text" name="<?php echo $prefix . '[' . $number; ?>][slot]" value="<?php echo $slot; ?>" />
					<small><?php _e( 'Ad unit slot.', 'stkit' ); ?></small>

				<div class="clear"><!-- --></div>
			</fieldset>

			<fieldset class="panel-fieldset metabox-fieldset">
				<legend><?php _e( 'Sizes', 'stkit' ) ?></legend>

					<select multiple="multiple" name="<?php echo $prefix . '[' . $number; ?>][type][]">
						<?php
							foreach( $sizes as $size ) {

								$selected = '';

								foreach( $type as $value )
									if ( $size == $value )
										$selected = ' selected';

								echo '<option value="' . $size . '"' . $selected . '>' . $size . '</option>';

							}
						?>
						<?php // if ( $type == 'horiz' ) echo 'selected'; ?>
					</select>

					<small><?php _e( 'Select the sizes.', 'stkit' ); ?></small>

				<div class="clear"><!-- --></div>
			</fieldset>

		<?php

	}


	/*-------------------------------------------
		Widget Output
	-------------------------------------------*/

	function widget_adsense_multi( $args, $vars = array() ) {

		extract($args);
	
		$widget_number = (int)str_replace('adsense-multi-', '', @$widget_id);
	
		$options = get_option('widget_adsense_multi');
	
		if ( !empty( $options[$widget_number] ) )
			$vars = $options[$widget_number];

		global $st_Settings;

		$client = !empty( $st_Settings['adsense_id'] ) ? str_replace( ' ', '', $st_Settings['adsense_id'] ) : false;
		$slot = $vars['slot'];
		$type = !empty( $vars['type'] ) ? $vars['type'] : array();
		$types = '';

		foreach( $type as $value )
			$types .= $types ? '|' . $value : $value;

		// Make a custom $before_widget
		$before_widget = '<div class="widget widget-adsense">';

		echo $before_widget;
	
			// Ad Unit
			if ( $client && $types ) {

				if ( !empty( $vars['slot'] ) )
					echo '<div class="st-adsense" data-client="' . $client . '" data-slot="' . $slot . '" data-type="' . $types . '"><ins class="adsbygoogle"></ins></div>';

			}
			else
				_e( 'Enter your AdSense client ID on Theme Panel, and select a sizes of Ad Unit.', 'stkit' );


		echo $after_widget;
	
	}


	/*-------------------------------------------
		Widget Helper Function
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


/*===============================================

	S H O R T C O D E
	AdSense shortcode

===============================================*/

	function st_adsense_shortcode( $atts, $content = null ) {

		extract(
			shortcode_atts(
				array(
					'slot'		=> '',
					'sizes'		=> '',
				),
				$atts
			)
		);

		global
			$st_Settings;

			$client = !empty( $st_Settings['adsense_id'] ) ? $st_Settings['adsense_id'] : false;

			if ( $client && $slot && $sizes )
				return '<div class="st-adsense" data-client="' . $client . '" data-slot="' . $slot . '" data-type="' . $sizes . '"><ins class="adsbygoogle"></ins></div>';
	
			else
				return _( 'Make sure the slot number, client ID, and sizes of ad unit.', 'stkit' );

	}

	add_shortcode( 'adsense', 'st_adsense_shortcode' );


?>