<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	version 1.0

*/

	function widget_social_icons_multi_register() {
		
		$prefix = 'social_icons-multi';

		$name = 'ST Social Icons';

		$widget_ops = array(
			'classname'		=> 'widget_social_icons_multi',
			'description'	=> __( 'Display a social networks icons linked to your profiles.', 'stkit' )
			);

		$control_ops = array(
			'width'			=> 200,
			'height'		=> 200,
			'id_base'		=> $prefix
			);
		
		$options = get_option( 'widget_social_icons_multi' );

		if ( isset( $options[0] ) )
			unset( $options[0] );
		
		if ( !empty( $options ) ) {

			foreach ( array_keys( $options ) as $widget_number ) {

				wp_register_sidebar_widget( $prefix . '-' . $widget_number, $name, 'widget_social_icons_multi', $widget_ops, array( 'number' => $widget_number ) );
				wp_register_widget_control( $prefix . '-' . $widget_number, $name, 'widget_social_icons_multi_control', $control_ops, array( 'number' => $widget_number ) );
	
			}

		} else {

			$options = array();
			$widget_number = 1;

			wp_register_sidebar_widget( $prefix . '-' . $widget_number, $name, 'widget_social_icons_multi', $widget_ops, array( 'number' => $widget_number ) );
			wp_register_widget_control( $prefix . '-' . $widget_number, $name, 'widget_social_icons_multi_control', $control_ops, array( 'number' => $widget_number ) );

		}

	}
	add_action( 'widgets_init', 'widget_social_icons_multi_register' );



/*===============================================

	C O N T R O L S
	Widget controls

===============================================*/

	function widget_social_icons_multi_control($args) {
	
		$prefix = 'social_icons-multi';
		
		$options = get_option('widget_social_icons_multi');

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
			$options = st_smart_multiwidget_update( $prefix, $options, $_POST[$prefix], $_POST['sidebar'], 'widget_social_icons_multi' );
		}
		
		$number = ($args['number'] == -1) ? '%i%' : $args['number'];
	
		// Vars
		$opts = @$options[$number];
		$title = @$opts['title'];

		?>
	
			<fieldset class="panel-fieldset metabox-fieldset">
				<legend><?php _e( 'Title', 'stkit' ) ?></legend>
		
				<input type="text" name="<?php echo $prefix . '[' . $number; ?>][title]" value="<?php echo $title; ?>" />
				<small><?php _e( 'Widget title.', 'stkit' ); ?></small>
		
				<div class="clear"><!-- --></div>
			</fieldset>
		
			<fieldset class="panel-fieldset metabox-fieldset">
				<legend><?php _e( 'Icons', 'stkit' ); ?></legend>

				<a href="admin.php?page=st-layout-settings" class="button"><?php _e( 'Manage', 'stkit' ); ?></a>
				<small><?php _e( 'Fill forms on Social tab.', 'stkit' ); ?></small>
		
				<div class="clear"><!-- --></div>
		
			</fieldset>
	
		<?php

	}



/*===============================================

	O U T P U T
	Widget output

===============================================*/

	function widget_social_icons_multi( $args, $vars = array() ) {

		extract($args);

		$widget_number = (int)str_replace('social_icons-multi-', '', @$widget_id);

		$options = get_option('widget_social_icons_multi');

		if ( !empty( $options[$widget_number] ) )
			$vars = $options[$widget_number];

		$title = $vars['title'];

		// Make a custom $before_widget
		$before_widget = '<div class="widget widget-social_icons">';

		// Output
		echo $before_widget;

			if( !empty( $vars['title'] ) )
				echo $before_title . $title . $after_title ;

				st_icons_social();

				?>

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