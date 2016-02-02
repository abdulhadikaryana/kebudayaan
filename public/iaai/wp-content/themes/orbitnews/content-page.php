<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package OrbitNews
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<h1 class="post-title"><?php the_title(); ?></h1>
		<?php the_content(); ?>
		<?php wp_link_pages(array( 
				'before' => '<div class="alert-box secondary">' . __('Pages:', 'orbitnews'), 
				'after' => '</div>', 
				'link_before' => '<span>', 
				'link_after' => '</span>',  )); 
		?>
        
</article><!-- #post-## -->

