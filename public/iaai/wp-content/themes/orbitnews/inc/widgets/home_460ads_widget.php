<?php 

class OrbitN_Homepage_Ads_460_Widget extends WP_Widget {
	
	function OrbitN_Homepage_Ads_460_Widget()
	{
		$widget_ops = array( 'classname' => 'ads_middle_mb25', 'description' => 'Home Ad slot with dimension of 460 by 60px.');

		$control_ops = array( 'width' => 200, 'height' => 300 );

		$this->WP_Widget('orn_460_ads-widget', '&#58;&#58; Home Ads 460x60 - Orbit News &#58;&#58;', $widget_ops, $control_ops);
		
	}
	
	function widget($args, $instance)
	{
		extract($args);

		if(isset($instance))
		{
			if( isset( $instance[ 'title' ] ) ) {
				$title = apply_filters( 'widget_title', $instance[ 'title' ] );
			}
					
			if( isset( $instance[ 'template' ] ) ) {
				$template = htmlspecialchars_decode( $instance[ 'template' ] );
			}
		}
		
		echo $before_widget; 
		
		/* Display the widget title if one was input (before and after defined by themes). */
		if( !isset( $title ) ) {	
		echo $before_title . $title . $after_title;	
		}	
	
		if( isset( $template ) ) {  
		echo '<div class="ads-middle mb25"> '.$template.' </div>';
		}
		
		echo $after_widget; 	
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['template'] = htmlspecialchars($new_instance['template']);
		
		return $instance;
	}

	function form( $instance ) {
		$defaults = array( 
			'title' => __('Home Ads 485x60', 'orbitnews'), 
			'template' => __('<a href="#"><img src="http://placehold.it/468x60" alt="ads"></a>', 'orbitnews'),
						);
						
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>			
		<p><label for="<?php echo $this->get_field_id('template'); ?>"><?php _e('Home Ad Code (480 x 60 pixel):', 'orbitnews'); ?></label>
		<textarea id="<?php echo $this->get_field_id('template'); ?>" name="<?php echo $this->get_field_name('template'); ?>" rows="10" cols="20" class="widefat"><?php echo $instance['template']; ?></textarea></p>
				
	<?php
	}
} 
