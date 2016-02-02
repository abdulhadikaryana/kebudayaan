<?php
/**
 * Template Name: Blog
 * This is a custom Blog template
 * @package OrbitNews
 */
 
get_header(); ?>
 
    <?php
	$sidebar_pos = get_post_meta($post->ID, "orn_sidebar_layout", true);
	switch ($sidebar_pos) {
		case 'left':
		$content_pos = 'right'; 
		$column_size = 'eight';
		$other_thumb = 'post-thumb';
		$excerpt_length = '20';
		break;
		case 'right':
		$content_pos = 'left'; 
		$column_size = 'eight';
	    $other_thumb = 'post-thumb';
		$excerpt_length = '20';
		break;
		case 'no-sidebar':
		$content_pos = 'center'; 
		$column_size = 'twelve';
		$other_thumb = 'medium-thumb';
		$excerpt_length = '35';
		break;
		default:
		$content_pos = 'left'; 
		$column_size = 'eight';
	    $other_thumb = 'post-thumb';
		$excerpt_length = '20';
	}
	?>
    <!-- Content -->
	<section id="content" class="<?php echo $column_size. ' column row pull-' . $content_pos ; ?>">
		
        <section class="row">
        	
			<?php // Display blog posts on any page @ http://m0n.co/l
			$temp = $wp_query; $wp_query= null;
			$posts_pp = get_option('posts_per_page');
			$args = array(
						'posts_per_page' => $posts_pp,
						'paged' => $paged,
					);
            $wp_query = new WP_Query( $args );
            while ($wp_query->have_posts()) : $wp_query->the_post(); 
			?>
    
                <article id="post-<?php the_ID(); ?>" <?php post_class('six column'); ?>>
            
                    <div class="post-image">
                        <?php
						if ( is_sticky() && ! is_paged() ) {
							echo '<span title="Featured Item" class="has-tip sticky-ico"></span>';
						}
						?>
						<?php
                        if ( has_post_format('video') || has_post_format('gallery') || has_post_format('audio') ) {
							echo '<div class="post-icons">';
							echo '<a href="'. esc_url( get_post_format_link( get_post_format() ) ).'">';
							echo '<span title="'.get_post_format_string( get_post_format() ).'" class="has-tip format-icon '. get_post_format() .'-ico"></span>';
							echo '</a>';
							echo '</div>';
                        }
                        ?>
                        <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>">
                            <?php 
							if ( has_post_thumbnail() ) { 
								the_post_thumbnail( $other_thumb ); 
							} else {
								echo '<img src='. get_template_directory_uri() .'/images/fallback/'.$other_thumb.'.gif alt="No Image Avaliable">';
							}
							?>
                        </a>   
                    </div>
                    <div class="post-container">
                        <h2 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                        <div class="post-excerpt">
                            <?php custom_excerpt($excerpt_length) ?>
                        </div>
                    </div>
                    <div class="post-meta">
                        <span class="comments"><?php  comments_popup_link( '0', '1', '%', '', ''); ?></span>
                        <span class="author"><?php the_author_posts_link(); ?></span>
						<span class="pdate"><a href="<?php the_permalink(); ?>"><?php the_time('F j, Y'); ?></a></span>
                    </div><!-- .post-meta -->
                	<div class="clear"></div>      
                </article><!-- #post-## -->
    
            <?php endwhile; ?>

		</section><!-- End Row -->
		
		<?php orbitnews_paginate($wp_query->max_num_pages); ?>

		<?php wp_reset_postdata(); ?>
   	
    </section><!-- End Content Section -->

<?php if ( 'no-sidebar' != $sidebar_pos ) { get_sidebar(); } ?>
<?php get_footer(); ?>