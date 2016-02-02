<?php
/**
 * The template part that displays featured image for standard post formats
 * The following content displays on single posts before post title
 * @package OrbitNews
 */
$post_id            = get_the_ID();
$sidebar_pos 	    = get_post_meta($post_id, 'orn_sidebar_layout', true);
$single_thumb 	    = ( ( 'no-sidebar' == $sidebar_pos ) ? 'full-thumb' : 'post-thumbnail' );
$featured_img_vis	= get_post_meta($post_id, 'orn_post_featured_meta', true);

if ( empty( $featured_img_vis ) || 'default' == $featured_img_vis ) {
  $featured_img_vis = ot_get_option( 'orn_post_featuredimg' );
}

if ( ( has_post_thumbnail() ) && ( 'show' == $featured_img_vis ) ) {
	$big_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');
	echo '<a rel="image" class="featured-img fancybox" href="'. $big_thumb[0] .'" title="'. get_the_title() .'">';
	echo the_post_thumbnail($single_thumb);
	echo '</a>';
}
