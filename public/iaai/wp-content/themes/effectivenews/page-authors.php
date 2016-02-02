<?php
/*
Template Name: Authors
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
            <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <div class="page_inner">
		<div class="entry-content">
		    <?php the_content(); ?>
                    <ul class="author_page">
                         <?php
                            $users = get_users('blog_id=1&orderby=post_count&order=DESC');
                            foreach ($users as $user) {	?>
                        <li>
                            <div class="author-avatar">
			    <?php echo get_avatar( get_the_author_meta( 'user_email' , $user->ID ), apply_filters( 'MFW_author_bio_avatar_size', 70 ) ); ?>
                            </div>
                            <h3><a href="<?php echo get_author_posts_url( $user->ID ); ?>"><?php echo $user->display_name ?> </a></h3>
                            
                            <div class="author-description">
                                <?php the_author_meta( 'description'  , $user->ID ); ?>
                            </div>
                            
                            <div class="author-s_icons">
                                <?php if ( get_the_author_meta( 'url' ) ) : ?>
                                <a class="tip_n" href="<?php the_author_meta( 'url' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( " 's site", 'framework' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-site.png" alt="" /></a>
                                <?php endif ?>
                                <?php if ( get_the_author_meta( 'facebook' ) ) : ?>
                                <a class="tip_n" href="<?php the_author_meta( 'facebook' ); ?>" title="<?php the_author_meta( 'display_name' ); ?> <?php _e( '  on Facebook', 'framework' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-fb.png" alt="" /></a>
                                <?php endif ?>
                                <?php if ( get_the_author_meta( 'twitter' ) ) : ?>
                                <a class="tip_n" href="http://twitter.com/<?php the_author_meta( 'twitter' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( '  on Twitter', 'framework' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-twitter.png" alt="" /></a>
                                <?php endif ?>	
                                <?php if ( get_the_author_meta( 'google' ) ) : ?>
                                <a class="tip_n" href="<?php the_author_meta( 'google' ); ?>" title="<?php the_author_meta( 'display_name' ); ?> <?php _e( '  on Google+', 'framework' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-google.png" alt="" /></a>
                                <?php endif ?>	
                                <?php if ( get_the_author_meta( 'linkedin' ) ) : ?>
                                <a class="tip_n" href="<?php the_author_meta( 'linkedin' ); ?>" title="<?php the_author_meta( 'display_name' ); ?> <?php _e( '  on Linkedin', 'framework' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-linkedin.png" alt="" /></a>
                                <?php endif ?>				
                                <?php if ( get_the_author_meta( 'flickr' ) ) : ?>
                                <a class="tip_n" href="<?php the_author_meta( 'flickr' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( '  on Flickr', 'framework' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-flickr.png" alt="" /></a>
                                <?php endif ?>	
                                <?php if ( get_the_author_meta( 'youtube' ) ) : ?>
                                <a class="tip_n" href="<?php the_author_meta( 'youtube' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( '  on YouTube', 'framework' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-youtube.png" alt="" /></a>
                                <?php endif ?>
                                <?php if ( get_the_author_meta( 'pinterest' ) ) : ?>
                                <a class="tip_n" href="<?php the_author_meta( 'pinterest' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( '  on Pinterest', 'framework' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-pinterest.png" alt="" /></a>
                                <?php endif ?>
                                <?php if ( get_the_author_meta( 'dribbble' ) ) : ?>
                                <a class="tip_n" href="<?php the_author_meta( 'dribbble' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( '  on Dribbble', 'framework' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-dribbble.png" alt="" /></a>
                                <?php endif ?>
                            </div>
                        </li>
                         <?php } ?>
                    </ul>
		</div>
            </div>
            <?php endwhile; ?>
        </div>
        
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