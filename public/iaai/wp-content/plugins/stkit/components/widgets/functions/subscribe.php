<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	version 1.0

*/

	function widget_subscribe_multi_register() {
		
		$prefix = 'subscribe-multi';

		$name = 'ST Subscribe';

		$widget_ops = array(
			'classname'		=> 'widget_subscribe_multi',
			'description'	=> __( 'Allow visitors to subscribe to your website via FeedBurner', 'stkit' )
			);

		$control_ops = array(
			'width'			=> 200,
			'height'		=> 200,
			'id_base'		=> $prefix
			);
		
		$options = get_option( 'widget_subscribe_multi' );

		if ( isset( $options[0] ) )
			unset( $options[0] );
		
		if ( !empty( $options ) ) {

			foreach ( array_keys( $options ) as $widget_number ) {

				wp_register_sidebar_widget( $prefix . '-' . $widget_number, $name, 'widget_subscribe_multi', $widget_ops, array( 'number' => $widget_number ) );
				wp_register_widget_control( $prefix . '-' . $widget_number, $name, 'widget_subscribe_multi_control', $control_ops, array( 'number' => $widget_number ) );
	
			}

		} else {

			$options = array();
			$widget_number = 1;

			wp_register_sidebar_widget( $prefix . '-' . $widget_number, $name, 'widget_subscribe_multi', $widget_ops, array( 'number' => $widget_number ) );
			wp_register_widget_control( $prefix . '-' . $widget_number, $name, 'widget_subscribe_multi_control', $control_ops, array( 'number' => $widget_number ) );

		}

	}
	add_action( 'widgets_init', 'widget_subscribe_multi_register' );



/*===============================================

	C O N T R O L S
	Widget controls

===============================================*/

	function widget_subscribe_multi_control($args) {
	
		$prefix = 'subscribe-multi';
		
		$options = get_option('widget_subscribe_multi');

		if ( empty( $options ) )
			$options = array();

		if ( isset( $options[0] ) )
			unset( $options[0] );
			
		// update options array
		if ( !empty($_POST[$prefix]) && is_array($_POST) ) {

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
			if ( $args['number'] == -1 && !empty( $options['last_number'] ) )
				$args['number'] = $options['last_number'];
	
			// clear unused options and update options in DB. return actual options array
			$options = st_smart_multiwidget_update( $prefix, $options, $_POST[$prefix], $_POST['sidebar'], 'widget_subscribe_multi' );
		}
		
		$number = ($args['number'] == -1) ? '%i%' : $args['number'];
	
		// Vars
		$opts = @$options[$number];
		$title = @$opts['title'];
		$feedId = @$opts['feedId'];
		$descr = @$opts['descr'] ? stripslashes(@$opts['descr']) : __( 'Sign up for our newsletter to receive the latest news and event postings.', 'stkit' );

		?>

			<fieldset class="panel-fieldset metabox-fieldset"><legend><?php _e( 'Title', 'stkit' ) ?></legend>

				<input type="text" name="<?php echo $prefix . '[' . $number; ?>][title]" value="<?php echo $title; ?>" />
				<small><?php _e( 'Widget title.', 'stkit' ); ?></small>

			</fieldset>

			<fieldset class="panel-fieldset metabox-fieldset">
				<legend><?php _e( 'Feedburner', 'stkit' ) ?></legend>
		
				<input type="text" name="<?php echo $prefix . '[' . $number; ?>][feedId]" value="<?php echo $feedId; ?>" />
				<small><?php _e( 'Enter you Feedburner ID', 'stkit' ); ?></small>
		
				<div class="clear"><!-- --></div>
			</fieldset>
		
			<fieldset class="panel-fieldset metabox-fieldset">
				<legend><?php _e( 'Email-subscribe', 'stkit' ); ?></legend>

				<textarea rows="4" cols="20" name="<?php echo $prefix . '[' . $number; ?>][descr]" ><?php echo $descr; ?></textarea>
				<small><?php _e( 'Description', 'stkit' ); ?></small>
		
				<div class="clear"><!-- --></div>
		
			</fieldset>
	
		<?php

	}



/*===============================================

	O U T P U T
	Widget output

===============================================*/

	function widget_subscribe_multi( $args, $vars = array() ) {

		extract($args);

		$widget_number = (int)str_replace('subscribe-multi-', '', @$widget_id);

		$options = get_option('widget_subscribe_multi');

		if ( !empty( $options[$widget_number] ) )
			$vars = $options[$widget_number];

		// Vars
		$title = !empty( $vars['title'] ) ? $vars['title'] : __( 'Email subscription', 'stkit' );
		$feedId = $vars['feedId'];
		$descr = $vars['descr'] ? stripslashes($vars['descr']) : __( 'Sign up for our newsletter to receive the latest news and event postings.', 'stkit' );
	
		// Make a custom $before_widget
		$before_widget = '<div class="widget widget-subscribe">';

		// Output
		echo $before_widget;

			echo $before_title . $title . $after_title ;

			echo wpautop( $descr );

				?>

					<form class="feedemail-form" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $feedId ?>', 'popupwindow', 'scrollbars=yes,width=600,height=550');return true">
						<div>
							<input type="text" class="feedemail-input" name="email" maxlength="150" value="" placeholder="<?php _e( 'your.email@address', 'stkit' ) ?>" />
							<input type="hidden" value="<?php echo $feedId ?>" name="uri"/>
							<input type="hidden" name="loc" value="<?php echo str_replace('-', '_', get_bloginfo( 'language' ) ) ?>"/>
							<input type="submit" value="<?php _e( 'Subscribe', 'stkit' ) ?>" class="feedemail-button"/>
						</div>
					</form>

					<div class="clear"><!-- --></div>

			<?php

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