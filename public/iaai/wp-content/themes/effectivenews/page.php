<?php get_header(); ?>
    
	<?php if(get_post_meta($post->ID, 'eff_page_breadcrumb', true)) { ?>
	<?php the_breadcrumb(); ?>
        <?php } ?>
	
	<?php
	$ssidebar = '';
        $ssideoption = get_post_meta($post->ID, 'eff_sidebar_option', true);
	$comments = get_post_meta($post->ID, 'eff_page_comments', true);
	$buildYourhome = get_post_meta($post->ID, 'eff_page_builder', true);
	?>
	<?php if ($buildYourhome == false) { ?>
	<div class="page_title">
	    <h2><?php the_title(); ?></h2>
	    <span></span>
	</div>
        <div class="page_wrap">
            <div class="page_inner">
		<div class="entry-content">
		     <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		    <?php the_content(); ?>
		    <?php wp_link_pages( array( 'before' => '<div class="my-paginated-posts">' . __( 'Pages:', 'framework' ), 'after' => '</div>' ) ); ?>
		    <?php endwhile; else: ?>
		    <?php endif; ?>        
		    <?php wp_reset_query(); ?>
		</div>
            </div>
        </div>
	<?php } else { ?>
		     <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		    <?php the_content(); ?>
		    <?php wp_link_pages( array( 'before' => '<div class="my-paginated-posts">' . __( 'Pages:', 'framework' ), 'after' => '</div>' ) ); ?>
		    <?php endwhile; else: ?>
		    <?php endif; ?>        
		    <?php wp_reset_query(); ?>
        <?php } ?>
	<?php if($comments) { ?>
	<?php comments_template(); ?>
	<?php } ?>
	
        </div>
        <!--wrap-->
        
	<?php if( $ssideoption !== 'fullw' ) { ?>
	<?php if(eff_option('sidebar') == '3cleft' || eff_option('sidebar') == '3cright') { ?>
	<aside class="sec_sidebar sidebar">
	    <?php dynamic_sidebar( 'Secondary sidebar' ); ?>
	</aside>
	<?php } ?>
        <aside class="sidebar">
            <?php global $wp_query; $postid = $wp_query->post->ID; $cus = get_post_meta($postid, 'sbg_selected_sidebar_replacement', true);?>
		<?php if ($cus != '') { ?>
		<?php if ($cus[0] != '0') { ?>
		     <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar($cus[0])){ }else { ?>
			<p class="noside"><?php _e('There Is No Sidebar Widgets Yet', 'framework'); ?></p>
		 <?php } ?>
		<?php } else { ?>
		 <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Main sidebar')){ }else { ?>
			<p class="noside"><?php _e('There Is No Sidebar Widgets Yet', 'framework'); ?></p>
		 <?php } ?>
		<?php } ?>
		<?php } else { ?>
		 <?php if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Main sidebar')){ }else { ?>
			<p class="noside"><?php _e('There Is No Sidebar Widgets Yet', 'framework'); ?></p>
		 <?php } ?>
	    <?php } ?>
        </aside>
	<?php } ?>
        
    </div>
    <!--Main-->
    
<div class="clear"></div>

<?php get_footer(); ?>