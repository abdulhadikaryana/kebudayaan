<?php
/**
 * The template for displaying image attachments.
 *
 * @package OrbitNews
 */

get_header(); ?>

	<section id="content" class="twelve column row pull-center singlepost">

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class('mb25'); ?>>

				<?php the_title( '<h1 class="post-title">', '</h1>' ); ?>
					
					<?php
						
						$metadata = wp_get_attachment_metadata();
						printf( __( '<span class="pdate"><time datetime="%1$s">%2$s</time></span> - <a href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a> in <a href="%6$s" title="Return to %7$s" rel="gallery">%8$s</a>.', 'orbitnews' ),
							esc_attr( get_the_date( 'c' ) ),
							esc_html( get_the_date() ),
							esc_url( wp_get_attachment_url() ),
							$metadata['width'],
							$metadata['height'],
							esc_url( get_permalink( $post->post_parent ) ),
							esc_attr( strip_tags( get_the_title( $post->post_parent ) ) ),
							get_the_title( $post->post_parent )
						);
						
					?>
					
				<div class="line"></div>
				<div class="clear"></div>          

				<?php orbitnews_the_attached_image(); ?>

				<?php if ( has_excerpt() ) : ?>
		
					<?php the_excerpt(); ?>
				
				<?php endif; ?>

				<?php
					the_content();
					
					wp_link_pages(array( 
					'before' => '<div class="alert-box secondary">' . __('Pages:', 'orbitnews'), 
					'after' => '</div>', 
					'link_before' => '<span>', 
					'link_after' => '</span>',  )); 
				?>
                
			</article><!-- #post-## -->
			<nav role="navigation" id="image-navigation" class="post-navigation clearfix">
				<div class="nav-previous th"><?php previous_image_link(false); ?></div>
				<div class="nav-next th"><?php next_image_link(false); ?></div>
			</nav><!-- #image-navigation --> 
			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template();
			?>

		<?php endwhile; // end of the loop. ?>

	</section><!-- end #content section -->

<?php get_footer(); ?>
