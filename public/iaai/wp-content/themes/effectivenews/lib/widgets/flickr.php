<?php 

add_action('widgets_init','eff_flickr');

function eff_flickr() {
	register_widget('eff_flickr');
	
	}

class eff_flickr extends WP_Widget {
	function eff_flickr() {
			
		$widget_ops = array('classname' => 'flickr','description' => __('Widget display Flickr Photo','framework'));
		$this->WP_Widget('flickr-photo',__('Widget - Flickr','framework'),$widget_ops);

		}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
$title = apply_filters('widget_title', $instance['title'] );
	$flickrID = $instance['flickrID'];
	$count = $instance['count'];


		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
?>
	<script type="text/javascript">
		<!--
		jQuery(document).ready(function() {                
			jQuery('.flickr_badge_wrapper').jflickrfeed({
				limit: <?php echo $count; ?>,
				qstrings: {
					id: '<?php echo $flickrID; ?>'
				},
				itemTemplate: '<div class="flickr_badge_image">' +
							'<a rel="colorbox" href="{{image}}" title="{{title}}">' +
								'<img src="{{image_s}}" alt="{{title}}" />' +
							'</a>' +
						'</div>'
			});
		});
		// -->
	</script>
	<div class="flickr_badge_wrapper clearfix">
	</div>
	
			
<?php 
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['flickrID'] = strip_tags( $new_instance['flickrID'] );
		$instance['count'] = $new_instance['count'];
		$instance['type'] = $new_instance['type'];
		$instance['display'] = $new_instance['display'];

		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Flickr','framework'), 
		'flickrID' => '61958348@N03',
		'count' => '15',
 			);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
	
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'framework') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'flickrID' ); ?>"><?php _e('Flickr ID:', 'framework') ?> (<a href="http://idgettr.com/">idGettr</a>)</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'flickrID' ); ?>" name="<?php echo $this->get_field_name( 'flickrID' ); ?>" value="<?php echo $instance['flickrID']; ?>" />
	</p>
	
	<p>
		<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Number of Photos:', 'framework') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" />
	</p>
        
   <?php 
}
	} //end class