<?php
/**
 * Template Name: Video Page
 * This is a custom Video Page template
 *	
 *
 * @package OrbitNews
 */
?>
<?php get_header(); ?>

	<section id="content" class="twelve column row pull-center video">
		
        <section class="row">

			  <?php
					$temp = $wp_query; $wp_query= null;
					$video_posts_pp = ot_get_option('orn_video_posts_per_page');
					$video_cat = ''; // Define empty variable for video posts category
					$video_tag = ''; // Define empty variable for video posts tag
					
					if (ot_get_option('orn_videopage_type') == 'category' ) {
						$video_cat = ot_get_option('orn_videopage_cat');
					} elseif (ot_get_option('orn_videopage_type') == 'tag' ) { 
						$video_tag = ot_get_option('orn_videopage_tag');
					}
					
					$args = array(
						'posts_per_page' => $video_posts_pp,
						'paged' => $paged,
						'cat' => $video_cat,
						'tag_id' => $video_tag,
						'tax_query' => array(
							array(
								'taxonomy' => 'post_format',
								'field' => 'slug',
								'terms' => 'post-format-video'
							)
						)
				    );
                  $wp_query = new WP_Query( $args );
                  while ($wp_query->have_posts()) : $wp_query->the_post(); 
              ?>
    
              <article id="post-<?php the_ID(); ?>" <?php post_class('three column'); ?>>
                      <div class="post-image">
						  <?php 
						  $embed_video_link = get_post_meta(get_the_ID(), '_orn_embed_link', true);
						  $the_title = get_the_title();
						  $template_url = get_template_directory_uri();
                          echo '<a href="'.$embed_video_link.'" rel="bookmark" title="'.$the_title.'">';
							if ( has_post_thumbnail()) { 
								the_post_thumbnail('small-thumb'); 
							} else {
							  	echo "<img src=$template_url/images/fallback/small-thumb.gif alt='No Image Avaliable'>";
							} 
						  ?>
                          </a>
                      </div>
                      <div class="post-container">
                          <h2 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                      </div>		
              </article><!-- #post-## -->
    
            <?php endwhile; ?>

		</section><!-- End Row -->
		
		<?php orbitnews_paginate($wp_query->max_num_pages); ?>

		<?php wp_reset_postdata(); ?>
   	
    </section><!-- End Content Section -->

<?php get_footer(); ?>