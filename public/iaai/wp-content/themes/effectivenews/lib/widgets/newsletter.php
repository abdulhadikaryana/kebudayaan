<?php 

add_action('widgets_init','eff_newsletter');

function eff_newsletter() {
	register_widget('eff_newsletter');
	}

class eff_newsletter extends WP_Widget {
	function eff_newsletter() {
			
		$widget_ops = array('classname' => 'newsletter','description' => __('Widget display the Subscribe box','framework'));
		
		$this->WP_Widget('newsletter',__('Widget - Newsletter','framework'),$widget_ops);

		}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
		$feed_url = $instance['feed_url'];
?>
		
		<section class="widget section_widget">
			<div class="widget_inner">
			<form class="newsletter" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $feed_url; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
				<input type="text" class="nsf" name="email" value="Your Email" onfocus="if(this.value=='<?php _e('Your Email', 'framework'); ?>')this.value='';" onblur="if(this.value=='')this.value='<?php _e('Your Email', 'framework'); ?>';">
				<input type="hidden" name="loc" value="en_US">
				<input type="hidden" value="<?php echo $feed_url; ?>" name="uri"/>
				<input type="submit" class="nsb" value="Subscribe">
			</form>
			</div>
		</section>

<?php 
		/* After widget (defined by themes). */
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['feed_url'] = $new_instance['feed_url'];

		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 
			'msg' => __('Subscribe to our newsletter', 'framework'),
			'feed_url' => 'Themeforest'
 			);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
	
    	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('title:', 'framework'); ?></label>
		<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'feed_url' ); ?>"><?php _e('feedburner name: (your name without http://feeds.feedburner.com/) ', 'framework'); ?></label>
		<input id="<?php echo $this->get_field_id( 'feed_url' ); ?>" name="<?php echo $this->get_field_name( 'feed_url' ); ?>" value="<?php echo $instance['feed_url']; ?>" class="widefat" />
		</p>


   <?php 
}
	} //end class