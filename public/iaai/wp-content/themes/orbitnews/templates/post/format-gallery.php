<?php
/**
 * The template part that displays image gallery for gallery post formats
 * The following content displays on single posts before post title
 * @package OrbitNews
 */
$post_id       = get_the_ID();
$sidebar_pos   = get_post_meta($post_id, 'orn_sidebar_layout', true); 
$single_thumb  = ( ( 'no-sidebar' == $sidebar_pos ) ? 'full-thumb' : 'post-thumbnail' );
$image_ids     = trim(get_post_meta($post_id, 'orn_image_gallery', true));

if ( !empty($image_ids) ) {

	echo '<!-- Gallery Slider -->';
	echo '<div class="flexslider no-nav mb25">';
	echo '<ul class="no-bullet slides gallery">';
	
	$image_ids = explode( ',', $image_ids );
	foreach( $image_ids as $image_id ) {
		$image_title  = get_the_title( $image_id );
		$image_croped = wp_get_attachment_image( $image_id, $single_thumb );
		$imageurl     = wp_get_attachment_url( $image_id );	
		echo '<li><a class="fancybox" href="'.$imageurl.'" title="'.$image_title.'">'.$image_croped.'</a></li>' . "\n";
	}

	echo '</ul>';    
	echo '</div>';
	echo '<!-- End Gallery Slider -->';

} //end !empty($image_ids)
