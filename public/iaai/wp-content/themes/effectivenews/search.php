<?php get_header(); ?>
	<div class="page_title">
	    <h2>
		<?php if ( have_posts() ) : ?>
		<?php printf( __( 'Search Results for: %s', 'framework' ), '<i>' . get_search_query() . '</i>' ); ?>
		<?php else : ?>
		<?php _e( 'Nothing Found', 'framework' ); ?>
		<?php endif; ?>
	    </h2>
	    <span></span>
	</div>
	
        <div class="page_wrap">
            <div class="page_inner"> 
            <div class="entry-content">
                <?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
                    <div class="block">
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
                                        echo wp_html_excerpt(strip_shortcodes($excerpt),120);
                                        ?> ...
                                    </p>
                                    <a href="<?php the_permalink() ?>" class="read_more"><?php _e('Read More &raquo;', 'framework'); ?></a>
                                </div>
                            </div>
                        </section>
                    </div>
                <?php endwhile; ?>
		<?php eff_pagination(); ?>
		<?php  else:  ?>
		    <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'framework' ); ?></p>
		<?php  endif; ?>
            </div>
	    <?php wp_reset_query(); ?>
	    </div>
        </div>
</div>   
<?php get_sidebar(); ?>

</div>
<!--Main-->
    
<div class="clear"></div>

<?php get_footer(); ?>