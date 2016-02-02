<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package OrbitNews
 */
?>

<article>
	
		<h1 class="post-title"><?php _e( 'Nothing Found', 'orbitnews' ); ?></h1>
	
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

		<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'orbitnews' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

		<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'orbitnews' ); ?></p>
        <div class="search_form">
			<?php get_search_form(); ?>
		</div>
		<?php else : ?>

		<p>
			<?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'orbitnews' ); ?>
		</p>
		<div class="search_form">
			<?php get_search_form(); ?>
		</div>
		<?php endif; ?>

</article><!-- .no-results -->
