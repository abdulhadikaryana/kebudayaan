<?php 

add_action('widgets_init','lateset_tweets');

function lateset_tweets() {
	register_widget('lateset_tweets');
	
	}

class lateset_tweets extends WP_Widget {
	function lateset_tweets() {
			
		$widget_ops = array('classname' => 'tweets','description' => __('Widget display Latest Tweets','framework'));
		
		$this->WP_Widget('latest-tweets',__('Widget - Twitter','framework'),$widget_ops);

		}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$username = $instance['username'];
		$count = $instance['count'];
		$avatar_size = $instance['avatar'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
			$rndn = rand(1,500);
?>
			<?php
			wp_enqueue_script('Tweets');
			?>
			
			<script type="text/javascript">	
				jQuery.noConflict();
				jQuery(function(){
				jQuery(".tweet_<?php echo $rndn; ?>").tweet({
					join_text: "auto",
					modpath: '<?php echo get_template_directory_uri(); ?>/js/twitter/',
					loading_text: 'loading twitter feed...',
					username: "<?php echo $username ?>",
					avatar_size: false,
					count: <?php echo $count ?>,
				
				<?php if( is_rtl() ) { ?>
				template: "{text}"

				<?php } else { ?>
					seconds_ago_text: "<?php _e('about %d seconds ago','framework');?>",
					a_minutes_ago_text: "<?php _e('about a minute ago','framework');?>",
					minutes_ago_text: "<?php _e('about %d minutes ago','framework');?>",
					a_hours_ago_text: "<?php _e('about an hour ago','framework');?>",
					hours_ago_text: "<?php _e('about %d hours ago','framework');?>",
					a_day_ago_text: "<?php _e('about a day ago','framework');?>",
					days_ago_text: "<?php _e('about %d days ago','framework');?>",
					view_text: "<?php _e('view tweet on twitter','framework');?>"
				<?php } ?>
				  });
				});
			</script>
			
			    <div class="tweet_<?php echo $rndn; ?>"></div>
			
<?php 
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = strip_tags( $new_instance['username'] );
		$instance['count'] = $new_instance['count'];

		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Twitter','framework'), 
			'username' => 'effectivelab', 
			'count' => 4
 			);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
	
    	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'framework') ?></label>
		<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e('Twitter username:', 'framework') ?></label>
		<input id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" class="widefat" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Number of tweets:', 'framework') ?></label>
		<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" class="widefat" />
		</p>
        
   <?php 
}
	} //end class