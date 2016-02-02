<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	version 1.0

*/

	function widget_flickr_multi_register() {
		
		$prefix = 'flickr-multi';

		$name = 'ST Flickr';

		$widget_ops = array(
			'classname'		=> 'widget_flickr_multi',
			'description'	=> __( 'Your photos from Flickr.', 'stkit' )
			);

		$control_ops = array(
			'width'			=> 400,
			'height'		=> 200,
			'id_base'		=> $prefix
			);
		
		$options = get_option( 'widget_flickr_multi' );

		if ( isset( $options[0] ) )
			unset( $options[0] );
		
		if ( !empty( $options ) ) {

			foreach ( array_keys( $options ) as $widget_number ) {

				wp_register_sidebar_widget( $prefix . '-' . $widget_number, $name, 'widget_flickr_multi', $widget_ops, array( 'number' => $widget_number ) );
				wp_register_widget_control( $prefix . '-' . $widget_number, $name, 'widget_flickr_multi_control', $control_ops, array( 'number' => $widget_number ) );
	
			}

		} else {

			$options = array();
			$widget_number = 1;

			wp_register_sidebar_widget( $prefix . '-' . $widget_number, $name, 'widget_flickr_multi', $widget_ops, array( 'number' => $widget_number ) );
			wp_register_widget_control( $prefix . '-' . $widget_number, $name, 'widget_flickr_multi_control', $control_ops, array( 'number' => $widget_number ) );

		}

	}
	add_action( 'widgets_init', 'widget_flickr_multi_register' );



/*===============================================

	C O N T R O L S
	Widget controls

===============================================*/

	function widget_flickr_multi_control($args) {

		$prefix = 'flickr-multi';
		
		$options = get_option('widget_flickr_multi' );

		if ( empty( $options ) )
			$options = array();

		if ( isset( $options[0] ) )
			unset( $options[0] );
			
		// update options array
		if ( !empty($_POST[$prefix] ) && is_array($_POST) ) {

			foreach ( $_POST[$prefix] as $widget_number => $values ) {

				if ( empty($values) && isset( $options[$widget_number] ) ) // user clicked cancel
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
			$options = st_smart_multiwidget_update( $prefix, $options, $_POST[$prefix], $_POST['sidebar'], 'widget_flickr_multi' );

		}
		
		$number = ($args['number'] == -1) ? '%i%' : $args['number'];
	
		// Vars
		$opts = @$options[$number];
		$title = @$opts['title'];
		$id = @$opts['id'] ? @$opts['id'] : '52617155@N08';
		$type = @$opts['type'] ? @$opts['type'] : 'user';
		$qty = @$opts['qty'] ? @$opts['qty'] : 6;
		$order = @$opts['order'];

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
				<legend><?php _e( 'Flickr', 'stkit' ) ?></legend>
		
					<dl>
						<dt>
							<span><?php _e( 'Account ID', 'stkit' ); ?></span>
						</dt>
						<dd>
							<input type="text" name="<?php echo $prefix . '[' . $number; ?>][id]" value="<?php echo $id; ?>" />
							<p><small><?php _e( 'Enter your Flickr ID', 'stkit' ) ?> (<a href="http://www.idgettr.com">idGettr</a>).</small></p>
						</dd>
					</dl>
		
					<div class="clear"><!-- --></div>
		
					<dl>
						<dt>
							<?php _e( 'Account type', 'stkit' ); ?>
						</dt>
						<dd>
							<label><input type="radio" value="user" name="<?php echo $prefix . '[' . $number; ?>][type]" <?php if ( $type == "user" || !$type  ) echo 'checked="checked"'; ?> /> <?php _e( 'User', 'stkit' ); ?></label>
							<label><input type="radio" value="group" name="<?php echo $prefix . '[' . $number; ?>][type]" <?php if ( $type == "group" ) echo 'checked="checked"'; ?> /> <?php _e( 'Group', 'stkit' ); ?></label>
						</dd>
					</dl>
		
					<div class="clear"><!-- --></div>
		
			</fieldset>
		
			<fieldset class="panel-fieldset metabox-fieldset"><legend><?php _e( 'Photos', 'stkit' ) ?></legend>
		
					<dl>
						<dt>
							<span><?php _e( 'Quantity', 'stkit' ); ?></span>
						</dt>
						<dd>
							<select name="<?php echo $prefix . '[' . $number; ?>][qty]">
								<?php

									$arr = array(1,2,3,4,5,6,7,8,9,10);

									foreach ( $arr as $value ) {

										$out = '<option value="' . $value . '"';

											if ( $qty == $value ) $out .= ' selected';

										$out .= '>' . $value . ' &nbsp;</option>';

										echo $out;

									};

								?>
							</select>
							<p><small><?php _e( 'Select number of photos.', 'stkit' ); ?></small></p>
						</dd>
					</dl>
		
				<div class="clear"><!-- --></div>
		
					<dl>
						<dt>
							<?php _e( 'Order', 'stkit' ); ?>
						</dt>
						<dd>
							<label><input type="radio" value="random" name="<?php echo $prefix . '[' . $number; ?>][order]" <?php if ( $order == "random" || !$order  ) echo 'checked="checked"'; ?> /> <?php _e( 'Random', 'stkit' ); ?></label>
							<label><input type="radio" value="latest" name="<?php echo $prefix . '[' . $number; ?>][order]" <?php if ( $order == "latest" ) echo 'checked="checked"'; ?> /> <?php _e( 'Recent', 'stkit' ); ?></label>
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

	function widget_flickr_multi( $args, $vars = array() ) {

		extract($args);

		$widget_number = (int)str_replace('flickr-multi-', '', @$widget_id);

		$options = get_option('widget_flickr_multi');

		if ( !empty($options[$widget_number]) )
			$vars = $options[$widget_number];

		// Vars
		$title = $vars['title'];
		$id = $vars['id'] ? $vars['id'] : '10729228@N07';
		$type = $vars['type'] ? $vars['type'] : 'user';
		$qty = $vars['qty'];
		$order = $vars['order'];

		// Make a custom $before_widget
		$before_widget = '<div class="widget widget-flickr">';

		// Output
		echo $before_widget;
	
			if( !empty( $vars['title'] ) )
				echo $before_title . $title . $after_title ;

			?>
	
				<div id="flickr">
			
					<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $qty; ?>&amp;display=<?php echo $order ?>&amp;size=s&amp;layout=x&amp;source=<?php echo $type ?>&amp;<?php echo $type ?>=<?php echo $id ?>"></script>
	
					<div class="clear"><!-- --></div>
	
				</div>
	
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