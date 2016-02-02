<?php 
/**
 * The template part that displays embeded video for video post formats
 * The following content displays on single posts before post title
 * @package OrbitNews
 */ 
$post_id    = get_the_ID();
$embed_html = get_post_meta($post_id, '_orn_oembed_body', true);

if ( !empty($embed_html) ) {
	echo '<figure class="flex-video">'. $embed_html .'</figure>';
}
