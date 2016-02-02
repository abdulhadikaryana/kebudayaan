<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package OrbitNews
 */

get_header(); ?>

	<section id="content" class="eight column row pull-left">
		<section class="row">
		<?php if ( have_posts() ) : ?>

		  <?php /* Breadcrumbs */ ?>
          <?php orbitnews_breadcrumbs(); ?>
          
          <?php /* Start the Loop */ ?>
          <?php while ( have_posts() ) : the_post(); ?>

          <?php get_template_part( 'content' ); ?>

          <?php endwhile; ?>
		</section><!-- End Row -->
				<?php orbitnews_paginate($pages = '', $range = 2); ?>
			<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		</section><!-- End Row -->
		<?php endif; ?>
	</section><!-- End Content Section  -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
