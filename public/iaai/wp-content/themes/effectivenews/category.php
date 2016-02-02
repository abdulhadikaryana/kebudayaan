<?php get_header(); ?>
    
	<div class="page_title">
                <h2>
                    <?php printf( __( 'Category: %s', 'framework' ), '<i>' . single_cat_title( '', false ) . '</i>' );	?>
                </h2>
                <?php if( eff_option( 'category_rss' ) ): ?>
                    <a class="cat_rss_icon tip_n" title="<?php _e( 'Feed Subscription', 'framework' ); ?>" href="<?php echo get_category_feed_link(get_query_var('cat')) ?>"><?php _e( 'Feed Subscription', 'framework' ); ?></a>
                <?php endif; ?>
                <span></span>
                
            </div>
            
            <?php
                if( eff_option( 'category_desc' ) ):	
                        $category_description = category_description();
                        if ( ! empty( $category_description ) )
                        echo '<div class="clear"></div><div class="category_desc">' . $category_description . '</div>';
                endif;
            ?>
	
        <div class="page_wrap">
            <div class="page_inner">
            <?php $category_id = get_query_var('cat') ; ?>
            <div class="entry-content">
                
                <?php if(eff_option('cat_slider') == true) { ?>
                    <section class="slider_section_box">
			<div class="slider">
			    <div class="flexslider"><!-- Slideshow -->
			    <ul class="slides">
				<?php
				$f_cat = $category_id;
				$cats_posts = eff_option('cat_filex_posts');
				?>
				<?php query_posts(array('showposts' => $cats_posts, 'cat' => $f_cat )); ?>   
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<li class="slider_item">
						<a href="<?php the_permalink(); ?>">
						<?php
						$img = eff_post_image('full');
						$Fimg = aq_resize($img,609, 340, true);
						?>
						<?php if (strpos(eff_post_image(), 'youtube')) { ?>
						<img src="<?php echo eff_post_image(); ?>" width="609" height="340" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
						    <img src="<?php echo eff_post_image(); ?>" width="609" height="340" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
						    <img src="<?php echo eff_post_image(); ?>" width="609" height="340" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } else { ?>
						    <img src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						<?php } ?>
						<span class="overlay <?php echo $postClass ; ?>"></span>
						</a>
						<div class="slider_caption">
						<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						<p><?php global $post;
							$excerpt = $post->post_excerpt;
							if($excerpt==''){
							$excerpt = get_the_content('');
							}
							echo wp_html_excerpt(strip_shortcodes($excerpt),180);
							?> ...</p>
						</div>
					</li>
				  <?php endwhile; ?>
				  <?php  else:  ?>
				  <!-- Else in here -->
				  <?php  endif; ?>
				  <?php wp_reset_query(); ?>
				</ul>
			    </div><!-- End Slideshow -->
			</div>
		    </section>
                    <?php wp_enqueue_style('flexslider'); ?>
		    <?php wp_enqueue_script('filex'); ?>
		    <script type="text/javascript" charset="utf-8">
			jQuery(window).load(function(){
			  jQuery('.flexslider').flexslider({
			    slideshow: true,
			    animation: "<?php echo eff_option('cat_filex_effect'); ?>", 
			    touch: true,
			    video: true,
			    controlNav: false, 
			    slideshowSpeed: <?php echo eff_option('cat_sli_speed'); ?>, 
			    after: function(slider) {
			      jQuery('.slider_caption').animate({
				bottom:0,
				
				}, 400)  
			    },
			    before: function(slider) {
			      jQuery('.slider_caption').animate({
				bottom:-200,
				}, 400)  
		    
			    },
			    start: function(slider){
			      jQuery('body').removeClass('loading');
		    
			      jQuery('.slider_caption').animate({
				bottom:0,
				
				}, 400)  
			    }
			  });
		      });
		    </script>
			<?php } ?>
                
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
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
                <?php  else:  ?>
                <!-- Else in here -->
                <?php  endif; ?>
            </div>
            <?php eff_pagination(); ?>
	    <?php wp_reset_query(); ?>
            </div>
        </div>
        
    </div>
    <!--wrap-->
        
<?php get_sidebar(); ?>

</div>
<!--Main-->
    
<div class="clear"></div>

<?php get_footer(); ?>