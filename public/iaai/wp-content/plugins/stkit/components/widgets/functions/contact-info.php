<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	version 1.0

*/

	function widget_contact_info_multi_register() {
		
		$prefix = 'contact_info-multi';
	
		$name = 'ST Get In Touch';
	
		$widget_ops = array(
			'classname'		=> 'widget_contact_info_multi',
			'description'	=> __( 'Share your contact information like an address, phone number, email etc.', 'stkit' )
			);
	
		$control_ops = array(
			'width'			=> 400,
			'height'		=> 200,
			'id_base'		=> $prefix
			);
		
		$options = get_option( 'widget_contact_info_multi' );
	
		if ( isset( $options[0] ) )
			unset( $options[0] );
		
		if ( !empty( $options ) ) {
	
			foreach ( array_keys( $options ) as $widget_number ) {
	
				wp_register_sidebar_widget( $prefix . '-' . $widget_number, $name, 'widget_contact_info_multi', $widget_ops, array( 'number' => $widget_number ) );
				wp_register_widget_control( $prefix . '-' . $widget_number, $name, 'widget_contact_info_multi_control', $control_ops, array( 'number' => $widget_number ) );
	
			}
	
		} else {
	
			$options = array();
			$widget_number = 1;
	
			wp_register_sidebar_widget( $prefix . '-' . $widget_number, $name, 'widget_contact_info_multi', $widget_ops, array( 'number' => $widget_number ) );
			wp_register_widget_control( $prefix . '-' . $widget_number, $name, 'widget_contact_info_multi_control', $control_ops, array( 'number' => $widget_number ) );
	
		}
	
	}
	add_action( 'widgets_init', 'widget_contact_info_multi_register' );



/*===============================================

	C O N T R O L S
	Widget controls

===============================================*/

	function widget_contact_info_multi_control($args) {
	
		$prefix = 'contact_info-multi';
		
		$options = get_option('widget_contact_info_multi');

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
			$options = st_smart_multiwidget_update( $prefix, $options, $_POST[$prefix], $_POST['sidebar'], 'widget_contact_info_multi' );

		}
		
		$number = ($args['number'] == -1) ? '%i%' : $args['number'];
	
		// Vars
		$opts = @$options[$number];
		$title = stripslashes( @$opts['title'] );
		$intro = stripslashes( @$opts['intro'] );
		$phone = stripslashes( @$opts['phone'] );
		$email = stripslashes( @$opts['email'] );
		$address = stripslashes( @$opts['address'] );
		$name = stripslashes( @$opts['name'] );
	
		?>

			<fieldset class="panel-fieldset metabox-fieldset">
				<legend><?php _e( 'Widget', 'stkit' ) ?></legend>

					<dl>
						<dt>
							<span><?php _e( 'Title', 'stkit' ); ?></span>
						</dt>
						<dd>
							<input type="text" name="<?php echo $prefix . '[' . $number; ?>][title]" value="<?php echo $title; ?>" />
							<small><?php _e( 'Widget title.', 'stkit' ); ?></small>
						</dd>
					</dl>

				<div class="clear"><!-- --></div>
			</fieldset>

			<fieldset class="panel-fieldset metabox-fieldset">
				<legend><?php _e( 'Contacts', 'stkit' ) ?></legend>

					<!-- Introduce -->

						<textarea class="no-resize" rows="4" cols="20" name="<?php echo $prefix . '[' . $number; ?>][intro]" ><?php echo $intro; ?></textarea>
						<p><small><?php _e( 'Enter an introduce text or leave it blank.', 'stkit' ); ?></small></p>
						<div class="clear"><!-- --></div>


					<!-- Address -->

						<dl>
							<dt>
								<span><?php _e( 'Address', 'stkit' ); ?></span>
							</dt>
							<dd>
								<input type="text" name="<?php echo $prefix . '[' . $number; ?>][address]" value="<?php echo $address; ?>" />
								<div class="clear"><!-- --></div>			
							</dd>
						</dl>


					<!-- Phone -->

						<dl>
							<dt>
								<span><?php _e( 'Phone', 'stkit' ); ?></span>
							</dt>
							<dd>
								<input type="text" name="<?php echo $prefix . '[' . $number; ?>][phone]" value="<?php echo $phone; ?>" />
								<div class="clear"><!-- --></div>
							</dd>
						</dl>


					<!-- Email -->

						<dl>
							<dt>
								<span><?php _e( 'Email', 'stkit' ); ?></span>
							</dt>
							<dd>
								<input type="text" name="<?php echo $prefix . '[' . $number; ?>][email]" value="<?php echo $email; ?>" />
								<div class="clear"><!-- --></div>
							</dd>
						</dl>


					<!-- Name -->

						<dl>
							<dt>
								<span><?php _e( 'Name', 'stkit' ); ?></span>
							</dt>
							<dd>
								<input type="text" name="<?php echo $prefix . '[' . $number; ?>][name]" value="<?php echo $name; ?>" />
							</dd>
						</dl>

				<div class="clear"><!-- --></div>
			</fieldset>

		<?php

	}



/*===============================================

	O U T P U T
	Widget output

===============================================*/

	function widget_contact_info_multi( $args, $vars = array() ) {
	
		extract($args);
	
		$widget_number = (int)str_replace('contact_info-multi-', '', @$widget_id);
	
		$options = get_option('widget_contact_info_multi');
	
		if ( !empty( $options[$widget_number] ) )
			$vars = $options[$widget_number];

		$title = stripslashes( $vars['title'] );
		$intro = stripslashes( $vars['intro'] );
		$address = stripslashes( $vars['address'] );
		$phone = stripslashes( $vars['phone'] );
		$email = stripslashes( $vars['email'] );
		$name = stripslashes( $vars['name'] );

		// Make a custom $before_widget
		$before_widget = '<div class="widget widget-info">';

		echo $before_widget;
	
			// Title
			if( !empty( $vars['title'] ) )
				echo $before_title . $title . $after_title ;

			// Intro
			if ( !empty($vars['intro']) )
				echo '<p>' . $intro . '</p>';

			echo '<address>';

				// Address
				if ( !empty($vars['address']) )
					echo '<p class="widget-info-address"><span>' . __( 'Address', 'stkit' ) . ': </span>' . $address . '</p>';
	
				// Phone
				if ( !empty($vars['phone']) ) 
					echo '<p class="widget-info-phone"><span>' . __( 'Phone', 'stkit' ) . ': </span>' . $phone . '</p>';
	
				// Email
				if ( !empty($vars['email']) )
					echo '<p class="widget-info-email"><span>' . __( 'Email', 'stkit' ) . ': </span><a class="mailto" href="mailto:' . $email . '">' . $email . '</a></p>';
	
				// Name
				if ( !empty($vars['name']) )
					echo '<p class="widget-info-name"><span>' . __( 'Name', 'stkit' ) . ': </span>' . $name . '</p>';

			echo '</address>';

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