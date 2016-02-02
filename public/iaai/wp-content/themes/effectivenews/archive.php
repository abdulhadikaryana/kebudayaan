<?php get_header(); ?>
	
	<div class="page_title">
                <h2>
                    <?php if ( is_day() ) : ?>
                            <?php printf( __( 'Daily Archives: <small>%s</small>', 'framework' ), get_the_date() ); ?>
                    <?php elseif ( is_month() ) : ?>
                            <?php printf( __( 'Monthly Archives: <small>%s</small>', 'framework' ), get_the_date( 'F Y' ) ); ?>
                    <?php elseif ( is_year() ) : ?>
                            <?php printf( __( 'Yearly Archives: <small>%s</small>', 'framework' ), get_the_date( 'Y' ) ); ?>
                    <?php else : ?>
                            <?php _e( 'Blog Archives', 'framework' ); ?>
                    <?php endif; ?>
                </h2>
                <span></span>
            </div>
	
        <div class="search_page">        
            
            <div class="entry-content">
                <?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
                    <div class="block">
                        <section class="section_box">
                            <div class="blog_style1">
                                <div class="content_inner">
                                    <div class="post_thumb">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php
                                            $img = eff_post_image('full');
                                            $Fimg = aq_resize($img,167, 171, true);
                                            ?>
                                            <?php if (strpos(eff_post_image(), 'youtube')) { ?>
					    <img src="<?php echo eff_post_image(); ?>" width="167" height="171" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					    
					    <?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
						<img src="<?php echo eff_post_image(); ?>" width="167" height="171" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					    
					    <?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
						<img src="<?php echo eff_post_image(); ?>" width="167" height="171" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					    
					    <?php } else { ?>
						<img src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
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
                                        echo wp_html_excerpt(strip_shortcodes($excerpt),179);
                                        ?> ...
                                    </p>
                                    <a href="<?php the_permalink() ?>" class="read_more"><?php _e('Read More &raquo;', 'framework'); ?></a>
                                </div>
                            </div>
                        </section>
                    </div>
                <?php endwhile; ?>
            </div>
            <?php eff_pagination(); ?>
            <?php  else:  ?>
            <div class="entry-content">
		<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'framework' ); ?></p>
            </div>
            <?php  endif; ?>
	    <?php wp_reset_query(); ?>
        </div>
        
    </div>
    <!--wrap-->
        
<?php get_sidebar(); ?>

</div>
<!--Main-->
    
<div class="clear"></div>

<?php get_footer(); ?>