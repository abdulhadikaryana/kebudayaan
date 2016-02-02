<?php
/**
 * The Template for displaying all single posts.
 *
 * @package OrbitNews
 */

get_header(); ?>
	
<?php
	$sidebar_pos = get_post_meta($post->ID, "orn_sidebar_layout", true);
	switch ($sidebar_pos) {
		case 'left':
		$content_pos = 'right'; 
		$column_size = 'eight';
		break;
		case 'right':
		$content_pos = 'left'; 
		$column_size = 'eight';
		break;
		case 'no-sidebar':
		$content_pos = 'center'; 
		$column_size = 'twelve';
		break;
		default:
		$content_pos = 'left'; 
		$column_size = 'eight';
	}

	//Show Hide Navigation for this post
	$post_navigation = get_post_meta($post->ID, 'orn_post_navigation_meta', true);
	if ( empty($post_navigation) || 'default' == $post_navigation ) {
		$post_navigation = ot_get_option( 'orn_post_navigation' );
	}
?>
    <!-- Content -->
	<section id="content" class="<?php echo $column_size. ' column row pull-' . $content_pos ; ?> singlepost">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content' ); ?>
			
			<?php // Show Post Navigation
				if ( 'show' == $post_navigation ) { 
					orbitnews_content_nav( 'nav-below' ); 
				} 
			?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template();
			?>

		<?php endwhile; // end of the loop. ?>

	</section><!-- content section -->

<?php if ( 'no-sidebar' != $sidebar_pos ) { get_sidebar(); } ?>
<?php get_footer(); ?>