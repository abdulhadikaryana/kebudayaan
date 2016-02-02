<?php 

class OrbitN_Oembed_Video_Widget extends WP_Widget {
	
	function OrbitN_Oembed_Video_Widget()
	{
		$widget_ops = array( 'description' => 'Add Oembed supported Videos to sidebar');

		$control_ops = array( 'id_base' => 'orn_oembed_video_widget' );

		$this->WP_Widget('orn_oembed_video_widget', '&#58;&#58; Featured Video - Orbit News &#58;&#58;', $widget_ops, $control_ops);
		
	}
	
	function widget($args, $instance)
	{
		extract($args);

		if(isset($instance))
		{
			if( isset( $instance[ 'title' ] ) ) {
				$title = apply_filters( 'widget_title', $instance[ 'title' ] );
			}
					
			if( isset( $instance[ 'video_url' ] ) ) {
				$video_url = htmlspecialchars_decode( $instance[ 'video_url' ] );
			}
		}
		
		echo $before_widget; 
		
		if( isset( $title ) ) {	
		echo $before_title.$title.$after_title;	
		}	
	
		if( isset( $video_url ) ) {  
		echo '<div class="flex-video"> '. wp_oembed_get( $video_url ) .' </div>';
		}
		
		echo $after_widget; 	
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['video_url'] = esc_attr($new_instance['video_url']);
		
		return $instance;
	}

	function form( $instance ) {
		$defaults = array( 
			'title' => __('Featured Video', 'orbitnews'), 
			'video_url' => __('http://www.youtube.com/watch?v=jwZUjdImZGk', 'orbitnews'),
						);
						
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>			
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'orbitnews'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id('video_url'); ?>"><?php _e('Video Url:', 'orbitnews'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('video_url'); ?>" name="<?php echo $this->get_field_name('video_url'); ?>" type="text" value="<?php echo $instance['video_url']; ?>" />
		</p>
				
	<?php
	}
} 
