<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	version 1.0

*/

	function widget_recent_posts_multi_register() {
		
		$prefix = 'recent-posts-multi';

		$name = 'ST Posts';

		$widget_ops = array(
			'classname'		=> 'widget_recent_posts_multi',
			'description'	=> __( 'Display a recent, random or popular posts with thumbnails and excerpts.', 'stkit' )
			);

		$control_ops = array(
			'width'			=> 200,
			'height'		=> 200,
			'id_base'		=> $prefix
			);
		
		$options = get_option( 'widget_recent_posts_multi' );

		if ( isset( $options[0] ) )
			unset( $options[0] );
		
		if ( !empty( $options ) ) {

			foreach ( array_keys( $options ) as $widget_number ) {

				wp_register_sidebar_widget( $prefix . '-' . $widget_number, $name, 'widget_recent_posts_multi', $widget_ops, array( 'number' => $widget_number ) );
				wp_register_widget_control( $prefix . '-' . $widget_number, $name, 'widget_recent_posts_multi_control', $control_ops, array( 'number' => $widget_number ) );

			}

		} else {

			$options = array();
			$widget_number = 1;

			wp_register_sidebar_widget( $prefix . '-' . $widget_number, $name, 'widget_recent_posts_multi', $widget_ops, array( 'number' => $widget_number ) );
			wp_register_widget_control( $prefix . '-' . $widget_number, $name, 'widget_recent_posts_multi_control', $control_ops, array( 'number' => $widget_number ) );

		}

	}
	add_action( 'widgets_init', 'widget_recent_posts_multi_register' );



/*===============================================

	C O N T R O L S
	Widget controls

===============================================*/

	function widget_recent_posts_multi_control( $args ) {

		global
			$st_Options,
			$st_Settings;

		$st_ = array();

		// Post type names
		$st_['st_post'] = !empty( $st_Settings['ctp_post'] ) ? $st_Settings['ctp_post'] : $st_Options['ctp']['post'];

		$prefix = 'recent-posts-multi';
		
		$options = get_option('widget_recent_posts_multi');

		if ( empty( $options) )
			$options = array();

		if ( isset( $options[0] ) )
			unset( $options[0] );
			
		// update options array
		if ( !empty($_POST[$prefix]) && is_array($_POST) ) {

			foreach ( $_POST[$prefix] as $widget_number => $values ) {

				if( empty( $values ) && isset( $options[$widget_number] ) ) // user clicked cancel
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
			$options = st_smart_multiwidget_update( $prefix, $options, $_POST[$prefix], $_POST['sidebar'], 'widget_recent_posts_multi' );
		}

		$number = ($args['number'] == -1) ? '%i%' : $args['number'];
	
		// Vars
		$opts = @$options[$number];
		$title = @$opts['title'];
		$post_type = @$opts['post_type'];
		$type = @$opts['type'];
		$timeframe = @$opts['timeframe'];
		$cats = @$opts['cats'];
		$qty = @$opts['qty'];
		$thumb = @$opts['thumb'];
		$date = @$opts['date'];
		$excerpt = @$opts['excerpt'];
		$cache = @$opts['cache'];

		?>

			<fieldset class="panel-fieldset metabox-fieldset">
				<legend><?php _e( 'Title', 'stkit' ) ?></legend>
	
				<input type="text" name="<?php echo $prefix . '[' . $number; ?>][title]" value="<?php echo $title; ?>" />
				<small><?php _e( 'Widget title.', 'stkit' ); ?></small>
	
				<div class="clear"><!-- --></div>
			</fieldset>
		
			<fieldset class="panel-fieldset metabox-fieldset"><legend><?php _e( 'Posts', 'stkit' ) ?></legend>

				<?php

					if ( !empty( $st_Settings['projects_status'] ) && $st_Settings['projects_status'] == 'yes' ) { ?>

						<label><input type="radio" value="post" name="<?php echo $prefix . '[' . $number; ?>][post_type]"
							<?php if ( !$post_type || $post_type == 'post' ) echo 'checked="checked"'; ?> /> <?php _e( 'Posts', 'stkit' ) ?></label>
		
						<label><input type="radio" value="<?php echo $st_['st_post'] ?>" name="<?php echo $prefix . '[' . $number; ?>][post_type]"
							<?php if ( $post_type == $st_['st_post'] ) echo 'checked="checked"'; ?> /> <?php _e( 'Projects', 'stkit' ) ?></label>
		
						<p><small><?php _e( 'Select a type of posts.', 'stkit' ); ?></small></p>
		
		
						<div class="clear"><!-- --></div><?php

					}

				?>


				<select name="<?php echo $prefix . '[' . $number; ?>][type]">
					<option value="recent" <?php if ( $type == 'recent' ) echo 'selected'; ?>><?php _e( 'Recent', 'stkit' ); ?></option>
					<option value="random" <?php if ( $type == 'random' ) echo 'selected'; ?>><?php _e( 'Random', 'stkit' ); ?></option>
					<option value="most_viewed" <?php if ( $type == 'most_viewed' ) echo 'selected'; if ( empty( $st_Settings['post_views'] ) || $st_Settings['post_views'] != 'yes' ) echo 'disabled'; ?>><?php _e( 'Most viewed', 'stkit' ); ?></option>
					<option value="most_commented" <?php if ( $type == 'most_commented' ) echo 'selected'; ?>><?php _e( 'Most commented', 'stkit' ); ?></option>
				</select>
				<p>
					<small><?php _e( 'Select a kind of posts.', 'stkit' ) ?></small>
					<?php
						if (
							empty( $st_Settings['post_views'] ) ||
							!empty( $st_Settings['post_views'] ) && $st_Settings['post_views'] != 'yes' )
								echo '<small>' . __( "Checkbox <a href='admin.php?page=st-major-settings'>Post Views</a> in case you'd like to show a most viewed posts.", 'stkit' ) . '</small>';
					?>
				</p>


				<div class="clear"><!-- --></div>


				<select name="<?php echo $prefix . '[' . $number; ?>][timeframe]">
					<option value="all" <?php if ( $timeframe == 'all' ) echo 'selected'; ?>><?php _e( 'For all time', 'stkit' ); ?></option>
					<option value="month" <?php if ( $timeframe == 'month' ) echo 'selected'; ?>><?php _e( 'For last month', 'stkit' ); ?></option>
					<option value="week" <?php if ( $timeframe == 'week' ) echo 'selected'; ?>><?php _e( 'For last week', 'stkit' ); ?></option>
				</select>
				<p>
					<small><?php _e( 'Select a time frame.', 'stkit' ) ?></small>
				</p>


				<div class="clear"><!-- --></div>


				<input type="text" name="<?php echo $prefix . '[' . $number; ?>][cats]" value="<?php echo $cats; ?>" />
				<p><small><?php _e( 'Enter a slugs of categories separated by comma. Optional.', 'stkit' ); ?></small></p>


				<div class="clear"><!-- --></div>


				<select name="<?php echo $prefix . '[' . $number; ?>][qty]">
					<?php
	
						$arr = array(1,2,3,5,7,10,15);
	
						foreach ( $arr as $value ) {
	
							$out = '<option value="' . $value . '"';
	
							if ( $qty == $value )
								$out .= ' selected';
	
							$out .= '>' . $value . '</option>';
	
							echo $out;
	
						}
	
					?>
				</select>
				<p><small><?php _e( 'Select a number of posts.', 'stkit' ); ?></small></p>


				<div class="clear"><!-- --></div>


				<label><input type="checkbox" name="<?php echo $prefix . '[' . $number; ?>][thumb]" value="display" <?php if ( $thumb == 'display' ) echo 'checked'; ?> /> <?php _e( 'Thumbnail', 'stkit' ) ?></label>


				<div class="clear"><!-- --></div>


				<label><input type="checkbox" name="<?php echo $prefix . '[' . $number; ?>][date]" value="display" <?php if ( $date == 'display' ) echo 'checked'; ?> /> <?php _e( 'Date', 'stkit' ) ?></label>


				<div class="clear"><!-- --></div>


				<label><input type="checkbox" name="<?php echo $prefix . '[' . $number; ?>][excerpt]" value="display" <?php if ( $excerpt == 'display' ) echo 'checked'; ?> /> <?php _e( 'Excerpt', 'stkit' ) ?></label>


				<div class="clear"><!-- --></div>
	
			</fieldset>

			<fieldset class="panel-fieldset metabox-fieldset">
				<legend><?php _e( 'Misc', 'stkit' ) ?></legend>
	
				<label><input type="checkbox" name="<?php echo $prefix . '[' . $number; ?>][cache]" value="display" <?php if ( $cache == 'display' ) echo 'checked'; ?> /> <?php _e( 'Cache', 'stkit' ) ?></label>
				<small><?php _e( 'Store a query result within 12 hours. Recommended.', 'stkit' ); ?></small>
	
				<div class="clear"><!-- --></div>
			</fieldset>

		<?php

	}



/*===============================================

	O U T P U T
	Widget output

===============================================*/

	function widget_recent_posts_multi( $args, $vars = array() ) {

		extract($args);

		global
			$st_Options,
			$st_Settings;

		$widget_number = (int)str_replace('recent-posts-multi-', '', @$widget_id);

		$options = get_option('widget_recent_posts_multi');

		if ( !empty( $options[$widget_number] ) )
			$vars = $options[$widget_number];

		$title = !empty( $vars['title'] ) ? $vars['title'] : '';
		$post_type = !empty( $vars['post_type'] ) ? $vars['post_type'] : 'post';
		$type = !empty( $vars['type'] ) ? $vars['type'] : 'recent';
		$timeframe = !empty( $vars['timeframe'] ) ? $vars['timeframe'] : 'all';
		$cats = !empty( $vars['cats'] ) ? $vars['cats'] : '';
		//$cats = preg_split("/[\s,]+/", $vars['cats']); // array
		$qty = $vars['qty'];
		$thumb = !empty( $vars['thumb'] ) ? $vars['thumb'] : '';
		$date = !empty( $vars['date'] ) ? $vars['date'] : '';
		$excerpt = !empty( $vars['excerpt'] ) ? $vars['excerpt'] : '';
		$cache = !empty( $vars['cache'] ) ? $vars['cache'] : '';
		$widget_class = str_replace( '_', '-', $type );

		// Taxonomy
		if ( $post_type == 'post' )
			$taxonomy = 'category_name';
		else
			$taxonomy = !empty( $st_Settings['ctp_category'] ) ? $st_Settings['ctp_category'] : $st_Options['ctp']['category'];

		$args = array();

		// Recent posts
		if ( $type == 'recent' ) {

			 $args = array(
				'post_type'				=> $post_type,
				'posts_per_page'		=> $qty,
				'orderby'				=> 'date',
				'order'					=> 'DESC',
				'post_status'			=> 'publish',
				'ignore_sticky_posts'	=> 1,
				$taxonomy				=> $cats
				);

		}

		// Random posts
		elseif ( $type == 'random' ) {

			 $args = array(
				'post_type'				=> $post_type,
				'posts_per_page'		=> $qty,
				'orderby'				=> 'rand',
				'post_status'			=> 'publish',
				'ignore_sticky_posts'	=> 1,
				$taxonomy				=> $cats,
				'date_query'			=> ( $timeframe != 'all' ? 
													array(
														array(
															'column'	=> 'post_date_gmt',
															'after'		=> '1 ' . $timeframe . ' ago',
														),
													)
											: '' )
				);

		}

		// Most viewed posts
		elseif ( $type == 'most_viewed' ) {

			$args = array (
				'post_type'				=> $post_type,
				'posts_per_page'		=> $qty,
				'ignore_sticky_posts'	=> 1,
				'orderby'				=> 'meta_value_num',
				'meta_key'				=> 'post_views_count',
				$taxonomy				=> $cats,
				'date_query'			=> ( $timeframe != 'all' ? 
													array(
														array(
															'column'	=> 'post_date_gmt',
															'after'		=> '1 ' . $timeframe . ' ago',
														),
													)
											: '' )
			);

		}

		// Most commented posts
		elseif ( $type == 'most_commented' ) {

			 $args = array(
				'post_type'				=> $post_type,
				'posts_per_page'		=> $qty,
				'orderby'				=> 'comment_count',
				'order'					=> 'DESC',
				'post_status'			=> 'publish',
				'ignore_sticky_posts'	=> 1,
				$taxonomy				=> $cats,
				'date_query'			=> ( $timeframe != 'all' ? 
													array(
														array(
															'column'	=> 'post_date_gmt',
															'after'		=> '1 ' . $timeframe . ' ago',
														),
													)
											: '' )
			);

		}


		$temp = !empty( $wp_query ) ? $wp_query : '';
		$wp_query = null;

		if ( !empty( $cache ) )
			$wp_query = get_transient( 'st_posts_widget_' . $type );

		if ( $wp_query == false ) {

			$wp_query = new WP_Query( $args );

			set_transient( 'st_posts_widget_' . $type, $wp_query, 60 * 60 * 12 );

		}


			// Make a custom $before_widget
			$before_widget = '<div class="widget widget-posts widget-posts-' . $widget_class . '">';
	
			echo $before_widget;

				// Output
				if( !empty( $vars['title'] ) )
					echo $before_title . $title . $after_title ;

				$count = 0;

				while ( $wp_query->have_posts() ) : $wp_query->the_post();

					$count++;
					$class = '';

					if ( $count == 2 ) {
						$class = ' class="even"';
						$count = 0;
					}

					echo "\n";

					echo '<div' . $class . '>';


						// Thumbnail
						if ( $thumb == 'display' ) {

							if ( has_post_thumbnail() ) {
						
								$image = get_the_post_thumbnail( $wp_query->post->ID, 'thumbnail' );
								$class = 'widget-posts-image';
						
							}
						
							else {

								if ( !empty( $st_Options['font-st'] ) == true ) {

									$image = '';
									$class = 'widget-posts-icon ico-st ico-' . st_get_format_icon( $wp_query->post->ID, false, false, false, 'text' );

								}

								else {

									$image = st_get_format_icon( $wp_query->post->ID, 16 );
									$class = 'widget-posts-icon';

								}
						
							}

							echo '<a class="' . $class . '" href="' . get_permalink() . '">' . $image . '</a>';

						}


						// Widget box
						$class = $thumb == 'display' ? ' widget-posts-post-box-with-thumb' : '';

						echo '<div class="widget-posts-post-box' . $class . '">';


							// Title
							if ( get_the_title( $wp_query->post->ID ) )
								echo '<a class="widget-posts-title" href="' . get_permalink( $wp_query->post->ID ) . '">' . get_the_title( $wp_query->post->ID ) . '</a>';

							// Date
							if ( $date == 'display' ) {

								if ( !empty( $st_Settings['nice_time'] ) && $st_Settings['nice_time'] == 'yes' ) {
									echo '<div class="widget-posts-date">' . st_nicetime( $wp_query->post->post_date_gmt ) . '</div>';
								}
								else {
									echo '<div class="widget-posts-date">' . get_the_time( get_option('date_format'), $wp_query->post->ID ) . '</div>';
								}
	
							}


							// Number of comments
							if ( $type == 'most_commented' && get_comments_number( $wp_query->post->ID ) != 0 ) {
	
								echo '<div class="widget-posts-comments">';
	
									comments_number( __( 'No Comments', 'stkit' ), __( '1 Comment', 'stkit' ), __( '% Comments', 'stkit' ));
	
								echo '</div>';
	
							}


							// Number of views
							if ( $type == 'most_viewed' ) {
	
								echo '<div class="widget-posts-views">';
	
									echo number_format( get_post_meta( $wp_query->post->ID, 'post_views_count', true ) ) . ' <span>' . __( 'views', 'stkit' ) . '</span>';
	
								echo '</div>';
	
							}


							// Excerpt
							if ( $excerpt == 'display' )
								echo '<div class="widget-posts-excerpt">' . wpautop( get_the_excerpt() ) . '</div>';


						echo '</div>';

					echo '<div class="clear"><!-- --></div></div>';
	
				endwhile;
	
			echo $after_widget;


		$wp_query = null;
		$wp_query = $temp;
		
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