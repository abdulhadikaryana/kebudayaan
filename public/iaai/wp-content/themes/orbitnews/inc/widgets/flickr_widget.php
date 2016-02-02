<?php

class Flickr_Widget extends WP_Widget {
	
	function Flickr_Widget()
	{
		$widget_ops = array('classname' => 'flickr-widget', 'description' => 'Display photos from flickr.');

		$control_ops = array('id_base' => 'orn-flickr-widget');

		$this->WP_Widget('orn-flickr-widget', '&#58;&#58; Flickr Widget - Orbit News &#58;&#58;', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);

		$title = apply_filters('widget_title', $instance['title']);
		$screen_name = $instance['screen_name'];
		$number = $instance['number'];
		$fancybox = esc_attr($instance['fancybox']);
		$img_size = esc_attr($instance['img_size']); // Added

		
		echo $before_widget;

		if($title) {
			echo $before_title.$title.$after_title;
		}
		
		if($screen_name && $number) {
			$flickr_name = 'flicker_id_from_'. $screen_name;
			$flickrID = get_option( $flickr_name );
			if ( empty( $flickrID ) ) {			
				if (preg_match("#^\d+@N\d+$#", $screen_name)) {
					$flickrID = $screen_name;
				} else {
					$api_key = 'e99b92d7d6b2eb90678ef063e1ae158c';
					@$person = wp_remote_get('http://api.flickr.com/services/rest/?method=flickr.people.findByUsername&api_key='.$api_key.'&username='.$screen_name.'&format=json');
					@$person = trim($person['body'], 'jsonFlickrApi()');
					@$person = json_decode($person);
					if ( isset($person->user->id) ) {
						$flickrID = $person->user->id;
					}
				}
			update_option($flickr_name, $flickrID);
			}
			if($flickrID) {
			?>
				<script type="text/javascript">
                        jQuery(window).load(function() {
                            jQuery('.<?php echo $this->id; ?>').jflickrfeed({
                                limit: <?php echo $number; ?>,
                                qstrings: {
                                    id: '<?php echo $flickrID; ?>'
                                },
                                itemTemplate: '<li>'+
                                              	'<a rel="<?php echo $this->id; ?>" href="{{<?php echo $img_size ?>}}" title="{{title}}">' +
                                              		'<img src="{{image_s}}" alt="{{title}}" />' +
                                              	'</a>' +
                                              '</li>'
									<?php if( $fancybox && $fancybox == '1' ) { ?>		  
                                    }, function(data) {
                                            jQuery("[rel='<?php echo $this->id; ?>']").colorbox({
													  transition	: 'fade',
													  scalePhotos 	: true,
													  maxWidth		: '90%',
													  maxHeight		: '90%',
													  slideshow		: true,
													  slideshowAuto	: false,
													  slideshowSpeed: 6000
                                      		});
									<?php } ?>
                    
                            });		
                        });	
				</script>
            <div class="flickr-widget">
            	<ul class='block-grid four-up <?php echo $this->id; ?>'></ul>  
            </div>
			<?php
			
			} else {
			
				echo '<p>Invalid flickr username.</p>';
			
			}
		}
		
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['screen_name'] = strip_tags($new_instance['screen_name']);
		$instance['number'] = strip_tags($new_instance['number']);
		$instance['fancybox'] = strip_tags($new_instance['fancybox']);
		$instance['img_size'] = strip_tags($new_instance['img_size']);


		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Photos from Flickr', 'screen_name' => '', 'number' => 12, 'fancybox' => '1', 'img_size' => 'image');
		$instance = wp_parse_args((array) $instance, $defaults); 

		?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'orbitnews'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('screen_name'); ?>"><?php _e('Screen name or Flickr ID:', 'orbitnews'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('screen_name'); ?>" name="<?php echo $this->get_field_name('screen_name'); ?>" value="<?php echo $instance['screen_name']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of photos to show:', 'orbitnews'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo $instance['number']; ?>" />
		</p>
        
        <p>
        	<input id="<?php echo $this->get_field_id('fancybox'); ?>" name="<?php echo $this->get_field_name('fancybox'); ?>" type="checkbox" value="1" <?php checked( '1', $instance['fancybox'] ); ?> />
	        <label for="<?php echo $this->get_field_id('fancybox'); ?>"><?php _e('Enable Fancybox:', 'orbitnews'); ?></label>
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('img_size'); ?>"><?php _e('Image Size:', 'orbitnews'); ?></label>
            <select class="widefat" name="<?php echo $this->get_field_name('img_size'); ?>" id="<?php echo $this->get_field_id('img_size'); ?>">
            <?php
            $image_sizes = array( 'Small'  => 'image_m', 'Medium' => 'image', 'Large'  => 'image_b' );
            foreach ($image_sizes as $size_k => $size_v ) {
            echo '<option value="' . $size_v . '" id="' . $size_v . '"', $instance['img_size'] == $size_v ? ' selected="selected"' : '', '>', $size_k, '</option>';
            }
            ?>
            </select>
        </p>        
	<?php
	}
}
