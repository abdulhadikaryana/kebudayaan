<?php 

class Ads_150_Widget extends WP_Widget {
	
	function Ads_150_Widget()
	{
		$widget_ops = array( 'classname' => 'widget_ads_small', 'description' => 'Ad slot with dimension of 150 by 150px.');

		$control_ops = array( 'width' => 200, 'height' => 300 );

		$this->WP_Widget('orn_150_ads-widget', '&#58;&#58; Ads 150x150 - Orbit News &#58;&#58;', $widget_ops, $control_ops);
		
	}
	
	function widget($args, $instance)
	{
		extract($args);

		$imgurl = array($instance['image_url1'],$instance['image_url2'],$instance['image_url3'],$instance['image_url4']);
		$url = array($instance['url1'],$instance['url2'],$instance['url3'],$instance['url4']);
		$title = $instance['title'];

		echo $before_widget; 

		if($title) {
			echo $before_title.$title.$after_title;
		}
	
		?>
	
		<ul class="no-bullet clearfix">
			<?php 
				for($i=0;$i<4;$i++) { 
	
					if( $imgurl[$i]!="" && $url[$i]!="" ) {
	
						echo "<li> <a href='$url[$i]'><img src='$imgurl[$i]' alt='$url[$i]' /></a> </li>";
	 
					}
				}
			?>
		</ul>
	
		<?php
	
		echo $after_widget; 
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		for($i=1;$i<5;$i++) {
		$instance['image_url'.$i]= strip_tags($new_instance['image_url'.$i]); 
		$instance['url'.$i]= strip_tags($new_instance['url'.$i]); 
		}
		
		return $instance;
	}

	function form($instance)
	{
		$imgurl = array(
			(isset($instance['image_url1']) ? $instance['image_url1'] : false),
			(isset($instance['image_url2']) ? $instance['image_url2'] : false),
			(isset($instance['image_url3']) ? $instance['image_url3'] : false),
			(isset($instance['image_url4']) ? $instance['image_url4'] : false)
			);
		$url = array(
			(isset($instance['url1']) ? $instance['url1'] : false),
			(isset($instance['url2']) ? $instance['url2'] : false),
			(isset($instance['url3']) ? $instance['url3'] : false),
			(isset($instance['url4']) ? $instance['url4'] : false)
			);
		$widget_title = (isset($instance['title']) ? $instance['title'] : false);
	
		?>		
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'orbitnews'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $widget_title; ?>" />
		</p>
		
		<?php
		for($i=0;$i<4;$i++) {
		?>
        <p> 
            <label for="<?php echo $this->get_field_id('image_url'.($i+1)); ?>"> <?php echo __('Ad Image URL', 'orbitnews').($i+1) ?> </label>
                

               		<input class="widefat" id="<?php echo $this->get_field_id('image_url'.($i+1)); ?>" name="<?php echo $this->get_field_name('image_url'.($i+1)); ?>" type="text" value="<?php echo $imgurl[$i]; ?>" />
           			<a href="#" class="button custom_upload_image_button"> <?php _e('Upload', 'orbitnews'); ?></a>

        </p>
                
        <p> 
            <label for="<?php echo $this->get_field_id('url'.($i+1)); ?>"> <?php echo __('Ad Link URL', 'orbitnews').($i+1) ?> </label>
            <input class="widefat" id="<?php echo $this->get_field_id('url'.($i+1)); ?>" name="<?php echo $this->get_field_name('url'.($i+1)); ?>" type="text" value="<?php echo $url[$i]; ?>" />
        </p>

       
<?php
		}
		
	}
}

add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_ss' );
function load_custom_wp_admin_ss() {
	if(function_exists( 'wp_enqueue_media' )){
    	wp_enqueue_media(); 
		} else {
    	wp_enqueue_style('thickbox');
    	wp_enqueue_script('media-upload');
    	wp_enqueue_script('thickbox');	
	}
}

add_action('admin_print_scripts', 'ads_150_uploader_scripts', 20);
function ads_150_uploader_scripts() {
if(function_exists( 'wp_enqueue_media' )){
?>
<script type="text/javascript">

jQuery(document).ready(function($) {
$('.custom_upload_image_button').click(function() {
    var send_attachment_bkp = wp.media.editor.send.attachment;
	var formfieldID = $(this).prev().attr("id");
    wp.media.editor.send.attachment = function(props, attachment) {
        $("#"+formfieldID).val(attachment.url);
        wp.media.editor.send.attachment = send_attachment_bkp;
    }
    wp.media.editor.open($(this));
    return false;       
	});
})

</script>
<?php
	}else{
?>
<script type="text/javascript">

var upload_image_button=false;
jQuery(document).ready(function($) {
$('.custom_upload_image_button').click(function() {
	upload_image_button = true;
	formfieldID = $(this).prev().attr("id");
	formfield   = $("#"+formfieldID).attr('name');
 	tb_show('Image Upload', 'media-upload.php?type=image&amp;TB_iframe=true');
	if ( upload_image_button == true ){

			var oldFunc = window.send_to_editor;
			window.send_to_editor = function(html) {
				imgurl = $('img', html).attr('src');
				$("#"+formfieldID).val(imgurl);
				tb_remove();
				window.send_to_editor = oldFunc;
				}
	}
	upload_image_button = false;
	});
})

</script>
<?php 
	}

}
