<!--Author Box-->
<div class="block author_box">
    <div class="block_box_title">
        <h2><?php _e( 'About', 'framework' ) ?> <?php the_author() ?></h2>
        <span></span>
    </div>
    
    <section class="section_box">
        <div class="content_inner">
            
            <div class="author-avatar">
                <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'MFW_author_bio_avatar_size', 70 ), $default=eff_option('custom_gravatar') ); ?>
            </div>
            
            <div class="author-description">
                <?php the_author_meta( 'description' ); ?>
            </div>
            
            <div class="author_topics">
                <a rel=author href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">View all posts by <?php the_author_meta( 'display_name' ); ?> &raquo;</a>    
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
            
        </div>
    </section>
</div>
<div class="clear"></div>
<!--Author Box-->