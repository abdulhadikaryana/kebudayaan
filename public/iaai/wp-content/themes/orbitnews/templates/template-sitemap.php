<?php
/**
 * Template Name: Sitemap Page
 *
 * The template for displaying Sitemap
 */

get_header(); ?>

	<!-- Content -->
	<section id="content" class="twelve column row pull-right singlepost">

		<?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>">
        
                <h1 class="post-title"><?php the_title(); ?></h1>
                <?php the_content(); ?>
                <?php wp_link_pages(array( 
                        'before' => '<div class="alert-box secondary">' . __('Pages:', 'orbitnews'), 
                        'after' => '</div>', 
                        'link_before' => '<span>', 
                        'link_after' => '</span>',  )); 
                ?>
                <div class="row">
                    <div class="four column">
                      <h3><?php _e('Pages','orbitnews'); ?></h2>
                      <ul class="disc"><?php wp_list_pages('title_li='); ?></ul>
                    </div>
                    <div class="four column">
                      <h3><?php _e('Categories','orbitnews'); ?></h2>
                      <ul class="disc"><?php wp_list_categories('title_li='); ?></ul>
                    </div>
                    <div class="two column">
                      <h3><?php _e('Tags','orbitnews'); ?></h2>
                      <ul class="disc">
                          <?php $tags = get_tags();
                          if ($tags) {
                              foreach ($tags as $tag) {
                                  echo '<li><a href="' . get_tag_link( $tag->term_id ) . '">' . $tag->name . '</a></li> ';
                              }
                          } ?>
                      </ul>
                    </div>
                    <div class="two column">
                      <h3><?php _e('Authors','orbitnews'); ?></h2>
                      <ul class="disc"><?php wp_list_authors('optioncount=1&exclude_admin=0'); ?></ul>
                    </div>                                
                </div>
                
        </article><!-- #post-## -->

		<?php endwhile; // end of the loop. ?>

	</section><!-- content section -->

<?php get_footer(); ?>
