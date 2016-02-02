<?php
/*
Template Name: Reviews
*/
?>
<?php get_header(); ?>
    
        <?php if(get_post_meta($post->ID, 'eff_page_breadcrumb', true)) { ?>
	<?php the_breadcrumb(); ?>
        <?php } ?>
	
	<?php
	$ssidebar = '';
        $ssideoption = get_post_meta($post->ID, 'eff_sidebar_option', true);
	$comments = get_post_meta($post->ID, 'eff_page_comments', true);
	?>
	<div class="page_title">
	    <h2><?php the_title(); ?></h2>
	    <span></span>
	</div>
	
        <div class="page_wrap">
            <div class="page_inner">
            <?php query_posts(array('showposts' => get_option('posts_per_page'), 'meta_key' => 'eff_enable_review', 'meta_value' => true, 'paged' => $paged)); ?>
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <div class="block">
                    <section class="section_box">
                        <div class="blog_style1">
                            <div class="content_inner">
                                <div class="post_thumb">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php
                                        $img = eff_post_image('medium');
                                        $Fimg = aq_resize($img,158, 159, true);
                                        ?>
                                        <?php if (strpos(eff_post_image(), 'youtube')) { ?>
					<img src="<?php echo eff_post_image(); ?>" width="158" height="159" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					
					<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
					    <img src="<?php echo eff_post_image(); ?>" width="158" height="159" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					
					<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
					    <img src="<?php echo eff_post_image(); ?>" width="158" height="159" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					
					<?php } else { ?>
					    <img src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					<?php } ?>
                                        <span class="overlay <?php echo $postClass ; ?>"></span>
                                        <?php
                                        $rt_enable = get_post_meta($post->ID, 'eff_enable_review', true);
                                        $rt_style = get_post_meta($post->ID, 'eff_review_style', true);
                                        $percent_score = get_post_meta($post->ID, 'eff_rt_final_score', true);
                                        $points_score = get_post_meta($post->ID, 'eff_rt_final_score_po', true);
                                        $stars_score = get_post_meta($post->ID, 'eff_rt_final_score_stars', true);
                                        if($rt_enable) {
                                            if($rt_style == 'stars') {
                                                echo '<div class="rt_post_rev"><div class="rt_stars_post">
                                                          <span class="rt_stars_post_rate" style="width:'. $percent_score . '%;"></span>
                                                     </div></div>';
                                            }
                                            if($rt_style == 'percent') {
                                                echo '<div class="rt_post_rev">
                                                <div class="percent_post">'. $percent_score .'%</div>
                                                </div>';
                                            }
                                
                                            if($rt_style == 'points') {
                                                echo '<div class="rt_post_rev">
                                                <div class="percent_post">'. $points_score .'</div>
                                                </div>';
                                            }
                                
                                        }
                                        ?>
                                    </a>
                                </div>
                                <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                                <span class="post_meta"><?php the_time('F d, Y');  ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a></span>
                                <p>
                                    <?php global $post;
                                    $excerpt = $post->post_excerpt;
                                    if($excerpt==''){
                                    $excerpt = get_the_content('');
                                    }
                                    echo wp_html_excerpt(strip_shortcodes($excerpt),120);
                                    ?> ...
                                </p>
                                <a href="<?php the_permalink() ?>" class="read_more"><?php _e('Read More &raquo;', 'framework'); ?></a>
                            </div>
                        </div>
                    </section>
                </div>        
            <?php endwhile; ?>
            <?php  else:  ?>
            <!-- Else in here -->
            <?php  endif; ?>
            <?php eff_pagination(); ?>
            <?php wp_reset_query(); ?>
            </div>
        </div>
	
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