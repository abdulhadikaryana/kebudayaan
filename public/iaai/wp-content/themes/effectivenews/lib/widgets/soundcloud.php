<?php
add_action( 'widgets_init', 'eff_soundcloud_widget' );
function eff_soundcloud_widget() {
	register_widget( 'eff_widget_soundcloud' );
}
class eff_widget_soundcloud extends WP_Widget {

	function eff_widget_soundcloud() {
		$widget_ops = array( 'classname' => 'eff_soundcloud_widget'  );
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'eff_soundcloud_widget' );
		$this->WP_Widget( 'eff_soundcloud_widget','Widget - SoundCloud', $widget_ops, $control_ops );
	}
 
	
	function widget( $args, $instance ) {
		extract( $args );

		$url = $instance['url'];
		$autoplay = $instance['autoplay'];
		
		$play = 'false';
		if( !empty( $autoplay )) $play = 'true';


		
			echo $before_widget; 

                        $title = apply_filters( 'widget_title', $instance['text_html_title'] );
                                //$disable_styles = $instance['disable_styles'];
                                
                        if ( !empty( $title ) ) { 
                                echo $before_title . $title . $after_title; 
                        };

			?>
			<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=<?php echo $url ; ?>&amp;auto_play=<?php echo $autoplay ; ?>&amp;show_artwork=true"></iframe>
			<?php
                        if ( !empty( $title ) ) {
                            echo $after_widget;
                        } else {
                        ?>
                        </div>
                        <?php
                        }		
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['text_html_title'] = strip_tags( $new_instance['text_html_title'] );
		$instance['url'] = $new_instance['url'] ;
		$instance['autoplay'] = strip_tags( $new_instance['autoplay'] );
		return $instance;
	}

	function form( $instance ) {
		$defaults = array( 'text_html_title' => 'SoundCloud'  );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'text_html_title' ); ?>">Title : </label>
			<input id="<?php echo $this->get_field_id( 'text_html_title' ); ?>" name="<?php echo $this->get_field_name( 'text_html_title' ); ?>" value="<?php echo $instance['text_html_title']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'url' ); ?>">URL :</label>
			<input id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" value="<?php echo $instance['url']; ?>" type="text" class="widefat" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'autoplay' ); ?>">Autoplay :</label>
			<input id="<?php echo $this->get_field_id( 'autoplay' ); ?>" name="<?php echo $this->get_field_name( 'autoplay' ); ?>" value="true" <?php if( $instance['autoplay'] ) echo 'checked="checked"'; ?> type="checkbox" />
		</p>


	<?php
	}
}
?>