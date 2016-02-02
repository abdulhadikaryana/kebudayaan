<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Generate
 */

get_header(); ?>


	<div id="primary" <?php generate_content_class(); ?>>
		<main id="main" class="site-main" itemprop="mainContentOfPage" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'generate' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<div class="inside-article">
						<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'generate' ); ?></p>

						<?php get_search_form(); ?>
					</div><!-- .inside-article -->
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php 
do_action('generate_sidebars');
get_footer(); 