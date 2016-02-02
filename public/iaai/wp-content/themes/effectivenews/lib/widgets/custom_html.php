<?php 

add_action('widgets_init','eff_custom_text');

function eff_custom_text() {
	register_widget('eff_custom_text');
	
	}

class eff_custom_text extends WP_Widget {
	function eff_custom_text() {
			
		$widget_ops = array('classname' => 'eff_custom_text','description' => __('Arbitrary text or HTML with transparent background Ability','framework'));
		$this->WP_Widget('eff_custom_text',__('widget - Custom Text Widget','framework'),$widget_ops);

		}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$txt = $instance['txt'];
		$show_bg = $instance['show_bg'];

		/* Before widget (defined by themes). */
		if($show_bg != 'on') {
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
		echo $before_title . $title . $after_title;
		}

		?>
		   	<div class="widget custom_textwidget">
				<?php echo $txt; ?>
			</div>

			
<?php 
		/* After widget (defined by themes). */
	if($show_bg != 'on') {
		echo $after_widget;
	}

	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['txt'] = $new_instance['txt'];
		$instance['show_bg'] = $new_instance['show_bg'];


		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 
 			);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
	

	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'framework') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
	</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_bg'], 'on' ); ?> id="<?php echo $this->get_field_id( 'show_bg' ); ?>" name="<?php echo $this->get_field_name( 'show_bg' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_bg' ); ?>"><?php _e('transparent background', 'framework'); ?></label>
		</p>


 		<p>
		<textarea id="<?php echo $this->get_field_id( 'txt' ); ?>" name="<?php echo $this->get_field_name( 'txt' ); ?>" class="widefat" cols="20" rows="16"><?php echo $instance['txt']; ?></textarea>
		</p>
       
   <?php 
}
	} //end class