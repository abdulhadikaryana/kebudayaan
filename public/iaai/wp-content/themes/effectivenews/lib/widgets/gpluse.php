<?php

add_action( 'widgets_init', 'gplus_widget_box' );
function gplus_widget_box() {
	register_widget( 'gplus_widget' );
}
class gplus_widget extends WP_Widget {

	function gplus_widget() {
		$widget_ops = array( 'classname' => 'g-widget' );
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'gplus_widget' );
		$this->WP_Widget('eff_gplus',__('widget - Google+ Box','framework'),$widget_ops);
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		$page_url = $instance['page_url'];

		echo $before_widget;
		if ( $title )
			echo $before_title;
			echo $title ; ?>
		<?php echo $after_title; ?>
			<div class="gplus-box">
				
               
<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
  {parsetags: 'explicit'}
</script>

<!-- Place this tag where you want the badge to render. -->
<div class="g-plus" data-width="275" data-href="<?php echo $page_url ?>" data-rel="publisher"></div>

<!-- Place this render call where appropriate. -->
<script type="text/javascript">gapi.plus.go();</script>
                	
			</div>
	<?php 
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['page_url'] = strip_tags( $new_instance['page_url'] );
		return $instance;
	}

	function form( $instance ) {
		$defaults = array( 'title' =>__( 'Find us on Google+' , 'framework'),'page_url'=>'//plus.google.com/109221593645351262967' );
		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$page_url = isset( $instance['page_url'] ) ? esc_attr( $instance['page_url'] ) : '';
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title : ' , 'framework') ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'page_url' ); ?>"><?php _e('Page Url : ' , 'framework') ?></label>
			<input id="<?php echo $this->get_field_id( 'page_url' ); ?>" name="<?php echo $this->get_field_name( 'page_url' ); ?>" value="<?php echo $instance['page_url']; ?>" class="widefat" type="text" />
		</p>


	<?php
	}
}
?>