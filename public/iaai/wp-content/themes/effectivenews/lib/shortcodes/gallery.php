<?php 
function custom_gallery($atts, $content = null) {
	extract(shortcode_atts(array(
        'width' => '150',
        'height' => '150'
	), $atts));
	
	ob_start();


$attachs = get_posts(array(
 'numberposts' => -1,
 'post_type' => 'attachment',
 'post_parent' => get_the_ID(),
 'post_mime_type' => 'image', // get attached images only
 'output' => ARRAY_A
));
if (!empty($attachs)) {
 foreach ($attachs as $att) {
  // get image's source based on size, can be 'thumbnail', 'medium', 'large', 'full' or registed post thumbnails sizes
  $imgsc = aq_resize($src,217, 150, true);
  
  // show image
  echo '<div><img src="'.$src.'" alt="" /></div>';
 }
}
		
                
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}
add_shortcode("custom_gallery", "custom_gallery");

?>