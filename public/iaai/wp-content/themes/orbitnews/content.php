<?php
/**
 * The template for displaying content
 * Used for both single and index/archive/search.
 * Supported Post Formats: standard/audio/gallery/video
 * @package OrbitNews
 */
?>
<?php 

  $post_id 		  = get_the_ID(); 	   				 // Post Id Variable for Loop
  $post_format	  = get_post_format();  			 // Post Format
  $sidebar 		  = orbitnews_sidebars($post_id);	 // Get sidebar array
  $sidebar_pos 	  = $sidebar['layout']; 			 // Sidebar Position
  $other_thumb 	  = 'post-thumb';	   				 // Post Thumbnail size for post listing
  $excerpt_length = '20';			   				 // Excerept Length with sidebar

  // If there is no sidebar set bigger thumbnails and larger excerpt
  if ( $sidebar_pos == 'no-sidebar' ) { 
		$other_thumb = 'medium-thumb';	// Post Thumbnail size for post listing
		$excerpt_length = '45';			// Excerept Length without sidebar
  }
  
  //Show Hide Tags for this post
  $post_tags_vis = get_post_meta($post_id, 'orn_post_tags_meta', true);
  if ( empty($post_tags_vis) || 'default' == $post_tags_vis ) {
	$post_tags_vis = ot_get_option( 'orn_post_tags' );
  }

?>
<?php if ( is_single() ) { ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php get_template_part( 'templates/post/format', $post_format ); ?>
    
    <h1 class="post-title"><?php the_title(); ?></h1>
    <div class="post-content">
        <?php the_content(); ?>
    </div>
    <?php wp_link_pages(array( 
            'before' => '<div class="alert-box secondary">' . __('Pages:', 'orbitnews'), 
            'after' => '</div>', 
            'link_before' => '<span>', 
            'link_after' => '</span>',  )); 
    ?>
    <?php } else { ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('six column'); ?>>
    
    <div class="post-image">
        <?php
            if ( is_sticky() && is_home() && ! is_paged() ) {
                echo '<span title="Featured Item" class="has-tip sticky-ico"></span>';
            }
        ?>
		<?php 
			// Post format icon if avaliable
			if ( has_post_format('video') || has_post_format('gallery') || has_post_format('audio') ) {
				echo '<div class="post-icons">';
				echo '<a href="'. esc_url( get_post_format_link( $post_format ) ). '">';
				echo '<span title="'.( get_post_format_string( $post_format ) ).'" class="has-tip format-icon '. $post_format .'-ico"></span>';
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
    <?php } // is_single() ?>
    <?php if ( 'post' == get_post_type() ) { ?>
    <div class="post-meta">
        <?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
        <span class="comments"><?php comments_popup_link( '0', '1', '%', '', 'Off'); ?></span>
        <?php endif; ?>
        <span class="author"><?php the_author_posts_link(); ?></span>
        <span class="pdate"><a href="<?php the_permalink(); ?>"><?php the_time('F j, Y'); ?></a></span>
        <?php if ( is_single() ) { ?>
        <span class="categories"><?php the_category(', '); ?></span>
        <?php  
        if ( 'show' == $post_tags_vis ) { //Show or Hide Tags Option
            the_tags('<span class="tags"><strong>' . __("Tags", 'orbitnews') . '</strong> &raquo; ',', ','</span>'); 
        }
        ?>
        <?php } //end if single ?>
    </div><!-- .post-meta -->
    <?php } // end if post ?>
</article><!-- #post-## -->
