<?php get_header(); ?>
    
	<?php
	    if(isset($_GET['author_name'])) :
	      $curauth = get_userdatabylogin($author_name);
	      else :
	      $curauth = get_userdata(intval($author));
	    endif;
	?>
	    
	<div class="page_title">
	    <h2><?php _e('About ' , 'framework' ) ?><?php echo $curauth->display_name; ?></h2>
	    <span></span>
	</div>
	
        <div class="page_wrap"> 
            <div class="page_inner">
		    <ul class="author_p">
                        <li>
                            <div class="author-avatar">
			    <?php echo get_avatar( get_the_author_meta( 'user_email' , $user->ID ), apply_filters( 'MFW_author_bio_avatar_size', 100 ), $default=eff_option('custom_gravatar') ); ?>
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
                    </ul>  
            </div>
        </div>
        <div class="block">
            <?php if(have_posts()) : while(have_posts()) : the_post('');?>
            <section class="section_box">
                <div class="blog_style1">
                    <div class="content_inner">
                        <div class="post_thumb">
                            <a href="<?php the_permalink(); ?>">
                                <?php if (eff_post_image() != false) { ?>
                                <?php
                                $img = eff_post_image('full');
                                $Fimg = aq_resize($img,158, 159, true);
                                ?>
                                <img src="<?php echo $Fimg; ?>" alt="<?php the_title(); ?>">
                                <?php } ?>
                                <span class="overlay <?php echo $postClass ; ?>"></span>
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
                            echo wp_html_excerpt(strip_shortcodes($excerpt),200);
                            ?> ...
                        </p>
                        <a href="<?php the_permalink() ?>" class="read_more"><?php _e('Read More &raquo;', 'framework'); ?></a>
                    </div>
                </div>
            </section>
            <?php endwhile; else: ?>
            <!--else here-->
            <?php endif; ?>
             <?php eff_pagination(); ?>
            <?php wp_reset_query(); ?>
        </div>
        
        </div>
        <!--wrap-->
        
	<?php get_sidebar(); ?>
        
    </div>
    <!--Main-->
    
<div class="clear"></div>

<?php get_footer(); ?>