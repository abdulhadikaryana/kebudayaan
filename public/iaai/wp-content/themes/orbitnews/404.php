<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package OrbitNews
 */

get_header(); ?>

	<!-- Content -->
	<section id="content" class="eight column row pull-left">
		<div class="page-container error-404">
			<p>
            	error 
            	<b>404</b>
            	<span>
				<?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'orbitnews' ); ?>
            	</span>
            </p>
		</div>
	</section>
	<!-- .error-404 -->
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>
