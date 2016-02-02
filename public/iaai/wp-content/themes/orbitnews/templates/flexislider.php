<?php
/**
 * The template part for displaying flexislider.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package OrbitNews
 */
?>

<div class="flexslider mb25">
  <ul class="slides no-bullet inline-list m0">
    <?php
			$slider_posts = ot_get_option('orn_flexislider_nrposts'); // Get Number of posts to show in slider
			$slider_cat   = ''; 	// Define empty variable for slider categories
			$slider_tags  = ''; 	// Define empty variable for slider tags
			
			if (ot_get_option('orn_flexislider_type') == 'category' ) {
				$slider_cat  = ot_get_option('orn_flexislider_cat'); 	  // add user selected category to $slider_cat
			} elseif (ot_get_option('orn_flexislider_type') == 'tag' ) { 
				$slider_tags = ot_get_option('orn_flexislider_tag'); 	  // add user selected tag to $slider_tags
			}
			
			$sidebar_pos = ot_get_option('orn_sidebar_home_layout');
			$post_thumbnail = 'post-thumbnail'; 
			if ( 'no-sidebar' == $sidebar_pos ) { 
				$post_thumbnail = 'full-thumb'; // Post Full Thumb Size when no sidebar
			}
			
			$args = array(
				'posts_per_page' 		=> $slider_posts,
				'cat'			 		=> $slider_cat,
				'tag_id' 		 		=> $slider_tags,
				'ignore_sticky_posts' 	=> 1 
			);
			$recent_posts = new WP_Query ( $args );
			while($recent_posts->have_posts()): $recent_posts->the_post();
	?>
		<li>
            <a href="<?php the_permalink(); ?>" rel="bookmark" title="">
			<?php 
				if (has_post_thumbnail()) { 
					the_post_thumbnail($post_thumbnail); 
				} else {
					echo '<img src='. get_template_directory_uri() .'/images/fallback/'.$post_thumbnail.'.gif alt="No Image Avaliable">';
				}
			?>
            </a>
			<div class="flex-caption">
              <h1><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
              <p><?php custom_excerpt('27') ?></p>
			</div>
		</li>
    <?php
	    	endwhile;
			wp_reset_postdata();
	?>
  </ul>
</div>
