<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package OrbitNews
 */

get_header(); ?>

    <?php
	$sidebar_pos = ot_get_option('orn_sidebar_home_layout');
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
	?>
	<!-- Content -->
	<section id="content" class="<?php echo $column_size. ' column row pull-' . $content_pos; ?>">
	 
    	<section class="row">
			<?php if ( have_posts() ) : ?>
				<?php /* Start the Loop */ ?>
                <?php while ( have_posts() ) : the_post(); ?>
                <?php
                            /* Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            get_template_part( 'content' );
                ?>
				<?php endwhile; ?>
		
		</section><!-- End Post Row -->
				<?php orbitnews_paginate($pages = '', $range = 2); ?>
			<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		</section><!-- End Content-None Row -->
			<?php endif; ?><!-- End if Posts -->
	</section><!-- End Content Section -->
	
<?php if ( 'no-sidebar' != $sidebar_pos ) { get_sidebar(); } ?>
<?php get_footer(); ?>
