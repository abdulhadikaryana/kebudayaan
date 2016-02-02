<?php
function eff_news_box_sc($display, $cat, $tag, $title, $posts, $style){ ?>
	<?php
	    global $wpdb;
	    $tag_ID = $wpdb->get_var("SELECT * FROM ".$wpdb->terms." WHERE `name` = '".$tag."'");
	?>
	    <?php if($display == 'cat') {
		$nb_title = get_cat_name($cat);
		$nb_link = get_category_link($cat);
		} elseif ($display == 'tag') {
		$nb_title = $tag;
		$nb_link = get_tag_link($tag_ID);
		} else {
		$nb_title = $title;
		$nb_link = '';
	    }
	    ?>
            
    <?php if($style == 'style2') { ?>
                <!--News Box 2-->
                <div class="block">
                    <div class="block_title">
                       <div class="title_bg"> <h2><a href="<?php echo $nb_link; ?>"><?php echo $nb_title; ?></a></h2></div>
                        <span></span>
                    </div>
                    
                    <section class="section_box">
                            <div class="news_box2">
                                <div class="first_news">
                                    <?php if($display == 'cat') {
                                    query_posts(array('showposts' => 1, 'cat' => $cat ));
                                    } elseif ($display == 'tag') {
                                    query_posts(array('showposts' => 1, 'tag' => $tag ));
                                    } else {
                                    query_posts(array('showposts' => 1 ));
                                    }
                                    ?>
                                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                                    <div class="post_thumb">
                                        <a href="<?php the_permalink(); ?>">
					    <?php
					    $img = eff_post_image('medium');
					    $Fimg = aq_resize($img,277, 153, true);
					    ?>
					    <?php if (strpos(eff_post_image(), 'youtube')) { ?>
					    <img src="<?php echo eff_post_image(); ?>" width="277" height="153" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					    
					    <?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
						<img src="<?php echo eff_post_image(); ?>" width="277" height="153" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					    
					    <?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
						<img src="<?php echo eff_post_image(); ?>" width="277" height="153" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					    
					    <?php } else { ?>
						<img src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					    <?php } ?>
                                        </a>
                                    </div>
                                    <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php short_title(55); ?></a></h2>
                                    <span class="post_meta"><?php the_time('F d, Y');  ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a></span>
                                    <p>
					<?php global $post;
					$excerpt = $post->post_excerpt;
					if($excerpt==''){
					$excerpt = get_the_content('');
					}
					echo wp_html_excerpt(strip_shortcodes($excerpt),140);
					?> ...
                                    </p>
                                    <a href="<?php the_permalink() ?>" class="read_more"><?php _e('Read More &raquo;', 'framework'); ?></a>
                                    <?php endwhile; else: ?>
                                    <!--else here-->
                                    <?php endif; ?>
                                    <?php wp_reset_query(); ?>
                                </div>
                                <ul>
                                    <?php if($display == 'cat') {
                                    query_posts(array('showposts' => $posts,'offset' => 1, 'cat' => $cat ));
                                    } elseif ($display == 'tag') {
                                    query_posts(array('showposts' => $posts, 'offset' => 1, 'tag' => $tag ));
                                    } else {
                                    query_posts(array('showposts' => $posts, 'offset' => 1 ));
                                    }
                                    ?>
                                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                                    <li>
                                        <div class="post_thumb">
                                            <a href="<?php the_permalink(); ?>" rel="bookmark">
                                               <?php
						$img = eff_post_image();
						$Fimg = aq_resize($img,50, 50, true);
						?>
						<?php if (strpos(eff_post_image(), 'youtube')) { ?>
						<img src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
						    <img src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
						    <img src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } else { ?>
						    <img src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						<?php } ?>
                                            </a>
                                        </div>
                                        <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php short_title(45); ?></a></h2>
                                        <span class="post_meta"><?php the_time('F d, Y');  ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a></span>
                                    </li>
                                    <?php endwhile; else: ?>
                                    <!--else here-->
                                    <?php endif; ?>
                                    <?php wp_reset_query(); ?>
                                </ul>    
                            </div>
                    </section>
                </div>
                <!--News Box 2-->         
    <?php } elseif($style == 'style3') { ?>
                <!--News Box 3-->
                    <div class="block">
                        <div class="news_box3">
                            <div class="block_title">
                                <div class="title_bg"><h2><a href="<?php echo $nb_link; ?>"><?php echo $nb_title; ?></a></h2></div>
                                <span></span>
                            </div>
                            
                            <section class="section_box">
                                <div class="content_inner">
                                    <div class="first_news">
                                        <?php if($display == 'cat') {
                                        query_posts(array('showposts' => 1, 'cat' => $cat ));
                                        } elseif ($display == 'tag') {
                                        query_posts(array('showposts' => 1, 'tag' => $tag ));
                                        } else {
                                        query_posts(array('showposts' => 1 ));
                                        }
                                        ?>
                                        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                                        <div class="post_thumb">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php
						$img = eff_post_image('medium');
						$Fimg = aq_resize($img,250, 143, true);
						?>
						<?php if (strpos(eff_post_image(), 'youtube')) { ?>
						<img src="<?php echo eff_post_image(); ?>" width="250" height="143" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
						    <img src="<?php echo eff_post_image(); ?>" width="250" height="143" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
						    <img src="<?php echo eff_post_image(); ?>" width="250" height="143" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } else { ?>
						    <img src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						<?php } ?>
                                            </a>
                                        </div>
                                        <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php short_title(55); ?></a></h2>
                                        <span class="post_meta"><?php the_time('F d, Y');  ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a></span>
                                        <p>
					    <?php global $post;
					    $excerpt = $post->post_excerpt;
					    if($excerpt==''){
					    $excerpt = get_the_content('');
					    }
					    echo wp_html_excerpt(strip_shortcodes($excerpt),150);
					    ?> ...
                                        </p>
                                        <a href="<?php the_permalink() ?>" class="read_more"><?php _e('Read More &raquo;', 'framework'); ?></a>
                                        <?php endwhile; else: ?>
                                        <!--else here-->
                                        <?php endif; ?>
                                        <?php wp_reset_query(); ?>
                                    </div>
                                </div>
                                <ul>
                                    <?php if($display == 'cat') {
                                    query_posts(array('showposts' => $posts,'offset' => 1, 'cat' => $cat ));
                                    } elseif ($display == 'tag') {
                                    query_posts(array('showposts' => $posts, 'offset' => 1, 'tag' => $tag ));
                                    } else {
                                    query_posts(array('showposts' => $posts, 'offset' => 1 ));
                                    }
                                    ?>
                                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                                    <li>
                                        <div class="post_thumb">
                                            <a href="<?php the_permalink(); ?>" rel="bookmark">
                                                <?php
						$img = eff_post_image();
						$Fimg = aq_resize($img,50, 50, true);
						?>
						<?php if (strpos(eff_post_image(), 'youtube')) { ?>
						<img src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
						    <img src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
						    <img src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } else { ?>
						    <img src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						<?php } ?>
                                            </a>
                                        </div>
                                        <h2><a href="<?php the_permalink(); ?>"><?php short_title(45); ?></a></h2>
                                        <span class="post_meta"><?php the_time('F d, Y');  ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a></span>
                                    </li>
                                    <?php endwhile; else: ?>
                                    <!--else here-->
                                    <?php endif; ?>
                                    <?php wp_reset_query(); ?>
                                </ul>
                            </section>
                        </div>
                    </div>   
                <!--News Box 3-->        
    <?php } elseif($style == 'style4') { ?>
                <!--News Box 4-->
                <div class="block">
                    <div class="block_title">
                        <div class="title_bg"><h2><a href="<?php echo $nb_link; ?>"><?php echo $nb_title; ?></a></h2></div>
                        <span></span>
                    </div>
                    
                    <section class="section_box">
                        <div class="news_box4">
                            <div class="content_inner">
                                <ul>
                                    <?php if($display == 'cat') {
                                    query_posts(array('showposts' => $posts, 'cat' => $cat ));
                                    } elseif ($display == 'tag') {
                                    query_posts(array('showposts' => $posts,  'tag' => $tag ));
                                    } else {
                                    query_posts(array('showposts' => $posts ));
                                    }
                                    ?>
                                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                                    <li>
                                        <div class="post_thumb">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php
						$img = eff_post_image('medium');
						$Fimg = aq_resize($img,277, 153, true);
						?>
						<?php if (strpos(eff_post_image(), 'youtube')) { ?>
						<img src="<?php echo eff_post_image(); ?>" width="277" height="153" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
						    <img src="<?php echo eff_post_image(); ?>" width="277" height="153" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
						    <img src="<?php echo eff_post_image(); ?>" width="277" height="153" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } else { ?>
						    <img src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						<?php } ?>
                                            </a>
                                        </div>
                                        <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php short_title(55); ?></a></h2>
                                        <span class="post_meta"><?php the_time('F d, Y');  ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a></span>
                                        <p>
					    <?php global $post;
					    $excerpt = $post->post_excerpt;
					    if($excerpt==''){
					    $excerpt = get_the_content('');
					    }
					    echo wp_html_excerpt(strip_shortcodes($excerpt),180);
					    ?> ...
                                        </p>
                                        <a href="<?php the_permalink() ?>" class="read_more"><?php _e('Read More &raquo;', 'framework'); ?></a>
                                    </li>
                                    <?php endwhile; else: ?>
                                    <!--else here-->
                                    <?php endif; ?>
                                    <?php wp_reset_query(); ?>
                                </ul>
                            </div>
                        </div>
                    </section>
                </div>
                <!--News Box 4-->     
    <?php } elseif($style == 'style5') { ?>
                <!--News Box 5-->
                <div class="block">
                    <div class="block_title">
                        <div class="title_bg"><h2><a href="<?php echo $nb_link; ?>"><?php echo $nb_title; ?></a></h2></div>
                        <span></span>
                    </div>
                    
                        <div class="news_box5">
                                    <?php if($display == 'cat') {
                                    query_posts(array('showposts' => $posts, 'cat' => $cat ));
                                    } elseif ($display == 'tag') {
                                    query_posts(array('showposts' => $posts,  'tag' => $tag ));
                                    } else {
                                    query_posts(array('showposts' => $posts ));
                                    }
                                    ?>
                                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                                    <div class="section_box_2">
					<div class="box5_inner">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php
						$img = eff_post_image('medium');
						$Fimg = aq_resize($img,306, 222, true);
						?>
						<?php if (strpos(eff_post_image(), 'youtube')) { ?>
						<img src="<?php echo eff_post_image(); ?>" width="306" height="222" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
						    <img src="<?php echo eff_post_image(); ?>" width="306" height="222" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
						    <img src="<?php echo eff_post_image(); ?>" width="306" height="222" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } else { ?>
						    <img src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						<?php } ?>
                                            </a>
					<div class="box5_content">
                                        <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php short_title(60); ?></a></h2>
                                        <span class="post_meta"><?php the_time('F d, Y');  ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a></span>
                                        <p>
					    <?php global $post;
					    $excerpt = $post->post_excerpt;
					    if($excerpt==''){
					    $excerpt = get_the_content('');
					    }
					    echo wp_html_excerpt(strip_shortcodes($excerpt),122);
					    ?> ...
                                        </p>
                                        <a href="<?php the_permalink() ?>" class="read_more"><?php _e('Read More &raquo;', 'framework'); ?></a>
					</div>
                                    </div>
				    </div>
                                    <?php endwhile; else: ?>
                                    <!--else here-->
                                    <?php endif; ?>
                                    <?php wp_reset_query(); ?>
                        </div>
                </div>
                <!--News Box 5-->      
    <?php } else { ?>
                <!--News Box 1-->
                <div class="block">
                    <div class="block_title">
                        <div class="title_bg"><h2><a href="<?php echo $nb_link; ?>"><?php echo $nb_title; ?></a></h2></div>
                        <span></span>
                    </div>
                    
                    <section class="section_box">
                            <div class="news_box1">
                                <div class="first_news">
                                    <?php if($display == 'cat') {
                                    query_posts(array('showposts' => 1, 'cat' => $cat ));
                                    } elseif ($display == 'tag') {
                                    query_posts(array('showposts' => 1, 'tag' => $tag ));
                                    } else {
                                    query_posts(array('showposts' => 1 ));
                                    }
                                    ?>
                                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                                    <div class="post_thumb">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php
					    $img = eff_post_image('medium');
					    $Fimg = aq_resize($img,277, 147, true);
					    ?>
					    <?php if (strpos(eff_post_image(), 'youtube')) { ?>
					    <img src="<?php echo eff_post_image(); ?>" width="277" height="147" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					    
					    <?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
						<img src="<?php echo eff_post_image(); ?>" width="277" height="147" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					    
					    <?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
						<img src="<?php echo eff_post_image(); ?>" width="277" height="147" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					    
					    <?php } else { ?>
						<img src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					    <?php } ?>
                                        </a>
                                    </div>
                                    <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php short_title(50); ?></a></h2>
                                    <span class="post_meta"><?php the_time('F d, Y');  ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a></span>
                                    <p>
					<?php global $post;
					$excerpt = $post->post_excerpt;
					if($excerpt==''){
					$excerpt = get_the_content('');
					}
					echo wp_html_excerpt(strip_shortcodes($excerpt),119);
					?> ...<a href="<?php the_permalink() ?>" class="read_more"><?php _e('Read More &raquo;', 'framework'); ?></a>
                                    </p>                            
                                    <?php endwhile; else: ?>
                                    <!--else here-->
                                    <?php endif; ?>
                                    <?php wp_reset_query(); ?>
                                </div>
                                <ul>
                                    <?php if($display == 'cat') {
                                    query_posts(array('showposts' => $posts,'offset' => 1, 'cat' => $cat ));
                                    } elseif ($display == 'tag') {
                                    query_posts(array('showposts' => $posts, 'offset' => 1, 'tag' => $tag ));
                                    } else {
                                    query_posts(array('showposts' => $posts, 'offset' => 1 ));
                                    }
                                    ?>
                                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                                    <li>
                                        <div class="post_thumb">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php
						$img = eff_post_image();
						$Fimg = aq_resize($img,50, 50, true);
						?>
						<?php if (strpos(eff_post_image(), 'youtube')) { ?>
						<img src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
						    <img src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
						    <img src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } else { ?>
						    <img src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						<?php } ?>
                                            </a>
                                        </div>
                                        <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php short_title(45); ?></a></h2>
                                        <span class="post_meta"><?php the_time('F d, Y');  ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a></span>
                                    </li>
                                    <?php endwhile; else: ?>
                                    <!--else here-->
                                    <?php endif; ?>
                                    <?php wp_reset_query(); ?>
                                </ul>    
                            </div>
                    </section>
                </div>
                <!--News Box 1-->   
	<?php } ?>
<?php } ?>
<?php function eff_bottom_box_sc($cat){ ?>
	<?php    
	    $bb_title = get_cat_name($cat);
	    $bb_link = get_category_link($cat);
	    ?>
            
	    <div class="block bottom_box">
		<div class="bblock_title">
		   <div class="title_bg"> <h2><a href="<?php echo $bb_link; ?>"><?php echo $bb_title; ?></a></h2></div>
		    <span></span>
		</div>
		
		<section class="section_box_2">
				<?php query_posts(array('showposts' => 1, 'cat' => $cat )); ?>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				    <a href="<?php the_permalink(); ?>">
					<?php
					$img = eff_post_image('medium');
					$Fimg = aq_resize($img,232, 136, true);
					?>
					<?php if (strpos(eff_post_image(), 'youtube')) { ?>
					<img src="<?php echo eff_post_image(); ?>" width="232" height="136" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					
					<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
					    <img src="<?php echo eff_post_image(); ?>" width="232" height="136" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					
					<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
					    <img src="<?php echo eff_post_image(); ?>" width="232" height="136" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					
					<?php } else { ?>
					    <img src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					<?php } ?>
				    </a>
				<div class="stylebox2">
				    <div class="first_news">
					<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php short_title(50); ?></a></h2>
					<?php endwhile; else: ?>
					<!--else here-->
					<?php endif; ?>
					<?php wp_reset_query(); ?>
				    </div>
				    <ul>
					<?php query_posts(array('showposts' => 4,'offset' => 1, 'cat' => $cat )); ?>
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<li>
					    <h2>&raquo; <a href="<?php the_permalink(); ?>" rel="bookmark"><?php short_title(30); ?></a></h2>
					</li>
					<?php endwhile; else: ?>
					<!--else here-->
					<?php endif; ?>
					<?php wp_reset_query(); ?>
					<a href="<?php echo $bb_link; ?>" class="read_more">More &raquo;</a>
				    </ul>
				</div>
		</section>
	    </div>
<?php } ?>
<?php function eff_blog_sc($style, $display, $cat, $posts){ ?>
    <?php if($style == 'style2') { ?>
            <!--BLog style 2-->
            <div class="block">
                <?php if($display == 'cat') { ?>
                <?php query_posts(array('showposts' => $posts, 'cat' => $cat )); ?>
                <?php } else { ?>
                 <?php query_posts(array('showposts' => $posts)); ?>
                <?php } ?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <section class="section_box">
                    <div class="blog_style2">
			<?php
			$type = get_post_meta($post->ID, 'eff_article_type',true);
			$image = get_post_meta($post->ID, 'eff_slider_option',true);
			$video_type = get_post_meta($post->ID, 'eff_video_type',true);
			$mvideo_id = get_post_meta($post->ID, 'eff_video_id',true);
			$gm_link = get_post_meta($post->ID, 'eff_gm_url',true);
			$audio_link = get_post_meta($post->ID, 'eff_audio_url',true);
			
			    $postClass = '';
			if ($type == 'featured') {
			    $postClass = 'image-post';
			} elseif ($type == 'video') {
			    $postClass = 'video-post';
			} elseif ($type == 'slider') {
			    $postClass = 'slider-post';
			} elseif ($type == 'audio') {
			    $postClass = 'audio-post';
			} elseif ($type == 'gmap') {
			    $postClass = 'map-post';
			} elseif ($type == 'slider') {
			    $postClass = 'slider-post';
			} else {
			    $postClass = 'format_defult';
			}
			?>
			
			<?php if ($type == 'video') { ?>
			<div class="m_video_frame">
			<?php if ($video_type == 'youtube') { ?>
			<iframe width="100%" height="300" src="http://www.youtube.com/embed/<?php echo $mvideo_id; ?>" frameborder="0" allowfullscreen></iframe>
			 <?php } elseif ($video_type == 'vimo') { ?>
			<iframe src="http://player.vimeo.com/video/<?php echo $mvideo_id; ?>?title=0&amp;portrait=0&amp;badge=0" width="100%" height="300px" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
			<?php } elseif ($video_type == 'daily') { ?>
			<iframe frameborder="0" width="100%" height="300" src="http://www.dailymotion.com/embed/video/<?php echo $mvideo_id ?>?logo=0"></iframe>
			<?php } ?>
			</div>
			<?php } elseif ($type == 'audio') { ?>
			<div class="m_soundcloud">
			<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=<?php echo $audio_link; ?>"></iframe>
			</div>
			<?php } elseif ($type == 'slider') { ?>
			<div class="postSlideshow">
			<?php
			global $wpdb;
			$images = get_post_meta($post->ID, 'eff_slider_option', false );
			$images = implode( ',' , $images );
			// Re-arrange images with 'menu_order'
			$images = $wpdb->get_col( "
			    SELECT ID FROM {$wpdb->posts}
			    WHERE post_type = 'attachment'
			    AND ID in ({$images})
			    ORDER BY menu_order ASC
			" );
			foreach ( $images as $att )
			{
			    // Get image's source based on size, can be 'thumbnail', 'medium', 'large', 'full' or registed post thumbnails sizes
			    $src = wp_get_attachment_image_src( $att, 'large' );
			    $src = $src[0];
			    // Show image
			?>
			<img width="622px" height="257px" src="<?php echo $src; ?>">
			<?php } ?>
			</div>
			<div class="slideshowControl">
			<a class="slide_next"></a>
			<a class="slide_prev"></a>
			<div class="slidePager"></div>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
		
				//inner slideshow
				$('.postSlideshow').cycle({
				timeout:0,
				speed: 'normal',
				pager:  '.slidePager',
				next:'.slide_next',
				prev:'.slide_prev',
				before: resize_slideshow
				});
				
				function resize_slideshow(curr, next, opts, fwd){
				//get the height of the current slide
				var $ht = $(this).height();
				//set the container's height to that of the current slide
				$(this).parent().animate({
				height : $ht
				});
				}
	
				$('.postSlideshow').click(function() {
					$('.postSlideshow').cycle('next');
				});
		
				});
			</script>
			<?php } elseif ($type == 'gmap') { ?>
			<div class="m-google-map">
			<iframe width="630" height="257" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?php echo $gm_link ?>&amp;output=embed"></iframe>
			</div>
			<?php } elseif ($type == 'featured') { ?>
			<?php $width = 622; $height = 257 ; ?>
			<div class="f_post_thumb">
			<?php eff_thumb('', $width , $height ); ?>
			</div>
			<?php } else { ?>
			    <a href="<?php the_permalink(); ?>">
			    <?php if (eff_post_image() != false) { ?>
			    <?php
			    $img = eff_post_image('large');
			    $Fimg = aq_resize($img,622, 257, true);
			    ?>
			    <img src="<?php echo $Fimg; ?>" alt="<?php the_title(); ?>">
			    <?php } ?>
			    </a>
			<?php } ?>
                        <div class="bs2_head">
                            <span class="post_type"><i class="<?php echo $postClass ; ?>"></i></span>
                            <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php short_title(65); ?></a></h2>
                            <span class="post_meta"><span class="date"><?php the_time('F d, Y');  ?></span><span class="author"><?php _e( 'Posted by: ' , 'framework' ); ?> <a rel="author" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>" title="<?php sprintf( esc_attr__( 'View all posts by %s', 'framework' ), get_the_author() ) ?>"><?php echo get_the_author() ?> </a></span><span class="category"><?php _e( 'Category: ' , 'framework' ); ?><?php printf('%1$s', get_the_category_list( ', ' ) ); ?></span><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a></span>
                        </div>
                        
                        <div class="content_inner">
                            <p>
				<?php global $post;
				$excerpt = $post->post_excerpt;
				if($excerpt==''){
				$excerpt = get_the_content('');
				}
				echo wp_html_excerpt(strip_shortcodes($excerpt),600);
				?> ...
                            </p>
                            <a href="<?php the_permalink() ?>" class="read_more"><?php _e('Read More &raquo;', 'framework'); ?></a>
                        </div>
                    </div>
                </section>
		<?php endwhile; else: ?>
		<!--else here-->
		<?php endif; ?>
		<?php wp_reset_query(); ?>
            </div>
            <!--BLog style 2--> 
	    <?php eff_pagination(); ?>    
    <?php } elseif ($style == 'style1') { ?>
            <!--Blog Style-->
                <?php if($display == 'cat') { ?>
                <?php query_posts(array('showposts' => $posts, 'cat' => $cat )); ?>
                <?php } else { ?>
                 <?php query_posts(array('showposts' => $posts)); ?>
                <?php } ?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div class="block">
		<section class="section_box">
		    <div class="blog_style1">
			<?php
			$type = get_post_meta($post->ID, 'eff_article_type',true);
			$image = get_post_meta($post->ID, 'eff_slider_option',true);
			$video_type = get_post_meta($post->ID, 'eff_video_type',true);
			$mvideo_id = get_post_meta($post->ID, 'eff_video_id',true);
			$gm_link = get_post_meta($post->ID, 'eff_gm_url',true);
			$audio_link = get_post_meta($post->ID, 'eff_audio_url',true);
			
			    $postClass = '';
			if ($type == 'featured') {
			    $postClass = 'image-post';
			} elseif ($type == 'video') {
			    $postClass = 'video-post';
			} elseif ($type == 'slider') {
			    $postClass = 'slider-post';
			} elseif ($type == 'audio') {
			    $postClass = 'audio-post';
			} elseif ($type == 'gmap') {
			    $postClass = 'map-post';
			} elseif ($type == 'slider') {
			    $postClass = 'slider-post';
			} else {
			    $postClass = 'format_defult';
			}
			?>
			<div class="content_inner">
			    <div class="post_thumb">
				<a href="<?php the_permalink(); ?>">
				    <?php
				    $img = eff_post_image('medium');
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
				echo wp_html_excerpt(strip_shortcodes($excerpt),250);
				?> ...
			    </p>
			    <a href="<?php the_permalink() ?>" class="read_more"><?php _e('Read More &raquo;', 'framework'); ?></a>
			</div>
		    </div>
		</section>
	    </div>
		<?php endwhile; else: ?>
		<!--else here-->
		<?php endif; ?>
		<?php wp_reset_query(); ?>
	    <!--Blog Style-->
	    <?php eff_pagination(); ?>	    
    <?php } ?>
<?php } ?>
<?php function eff_slider_sc($type, $display, $cat, $tag, $count){ ?>
	<?php if($type == 'cyc') { ?>  
	    <!--Slider-->
		    <section class="slider_section_box">
			<div class="slider">
			    <div class="slider_wrap">
				<div class="cycle_slider">
				    <?php if ($display == 'lates') { ?>
				    <?php query_posts(array('showposts' => $count)); ?>
				    <?php } elseif ($display == 'category') { ?>
				    <?php query_posts(array('showposts' => $count, 'cat' => $cat )); ?>
				    <?php } elseif ($display == 'tag') { ?>
				    <?php query_posts(array('showposts' => $count, 'tag' => $tag )); ?>
				    <?php } else { ?>
				    <?php query_posts(array('showposts' => $count)); ?>
				    <?php } ?>
				    
				    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				    <div class="slider_item">
					<a href="<?php the_permalink(); ?>">
					    <?php
					    $img = eff_post_image('large');
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
					</a>
					<div class="slider_caption">
					    <h2><a href="<?php the_permalink(); ?>"><?php short_title(50); ?></a></h2>
					    <p>
						<?php global $post;
						$excerpt = $post->post_excerpt;
						if($excerpt==''){
						$excerpt = get_the_content('');
						}
						echo wp_html_excerpt(strip_shortcodes($excerpt),180);
						?> ...
					    </p>
					</div>
				    </div>
				    <?php endwhile; ?>
				    <?php  else:  ?>
				    <!-- Else in here -->
				    <?php  endif; ?>
				    <?php wp_reset_query(); ?>
				</div>
			    </div>
			    <ul class="slider_nav">
				<?php if ($display == 'lates') { ?>
				<?php query_posts(array('showposts' => $count)); ?>
				<?php } elseif ($display == 'category') { ?>
				<?php query_posts(array('showposts' => $count, 'cat' => $cat )); ?>
				<?php } elseif ($display == 'tag') { ?>
				<?php query_posts(array('showposts' => $count, 'tag' => $tag )); ?>
				<?php } else { ?>
				<?php query_posts(array('showposts' => $count)); ?>
				<?php } ?>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
				<li>
				    <a href="<?php the_permalink(); ?>" rel="bookmark">
					<?php
					$img = eff_post_image('thumbnail');
					$Fimg = aq_resize($img,88, 73, true);
					?>
					<?php if (strpos(eff_post_image(), 'youtube')) { ?>
					<img src="<?php echo eff_post_image(); ?>" width="88" height="73" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					
					<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
					    <img src="<?php echo eff_post_image(); ?>" width="88" height="73" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					
					<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
					    <img src="<?php echo eff_post_image(); ?>" width="88" height="73" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					
					<?php } else { ?>
					    <img src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					<?php } ?>
				    </a>
				</li>
				<?php endwhile; ?>
				<?php  else:  ?>
				<!-- Else in here -->
				<?php  endif; ?>
				<?php wp_reset_query(); ?>
			    </ul>
			</div>
		    </section>
		    <!--Slider-->
		    <script>
			jQuery(document).ready(function($) {
			    $('.cycle_slider').cycle({
				fx:     '<?php echo eff_option('cycle_effect'); ?>',
				speed: <?php echo eff_option('sli_speed'); ?>,
				pager: 'ul.slider_nav',
				slideExpr: '.slider_item',
				pagerAnchorBuilder: function(idx, slide) {
				return 'ul.slider_nav li:eq(' + (idx) + ')';
				}
			    });
			});
		    </script>	    
	<?php } elseif($type == 'filex') { ?>
		    <section class="slider_section_box">
			<div class="slider">
			    <div class="flexslider"><!-- Slideshow -->
			    <ul class="slides">
				    <?php if ($display == 'lates') { ?>
				    <?php query_posts(array('showposts' => $count)); ?>
				    <?php } elseif ($display == 'cat') { ?>
				    <?php query_posts(array('showposts' => $count, 'cat' => $cat )); ?>
				    <?php } elseif ($display == 'tag') { ?>
				    <?php query_posts(array('showposts' => $count, 'tag' => $tag )); ?>
				    <?php } else { ?>
				    <?php query_posts(array('showposts' => $count)); ?>
				    <?php } ?>
			       <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<li class="slider_item">
				<a href="<?php the_permalink(); ?>">
				<?php
				$img = eff_post_image('large');
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
				</a>
				<div class="slider_caption">
				<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php short_title(50); ?></a></h2>
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
		    
		    <script type="text/javascript" charset="utf-8">
			jQuery(window).load(function(){
			  jQuery('.flexslider').flexslider({
			    slideshow: true,
			    animation: "<?php echo eff_option('filex_effect'); ?>", 
			    touch: true,
			    video: true,
			    slideshowSpeed: <?php echo eff_option('sli_speed'); ?>, 
			    after: function(slider) {
			      jQuery('.slider_caption').animate({
				bottom:0,
				
				}, 400)  
			    },
			    before: function(slider) {
			      jQuery('.slider_caption').animate({
				bottom:-105,
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
	<?php } elseif($type == 'caro') { ?>
	<div class="caro_slider">
	    <ul>
		    <?php if ($display == 'lates') { ?>
		    <?php query_posts(array('showposts' => 2 )); ?>
		    <?php } elseif ($display == 'cat') { ?>
		    <?php query_posts(array('showposts' => 2, 'cat' => $cat )); ?>
		    <?php } elseif ($display == 'tag') { ?>
		    <?php query_posts(array('showposts' => 2, 'tag' => $tag )); ?>
		    <?php } else { ?>
		    <?php query_posts(array('showposts' => 2 )); ?>
		    <?php } ?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>    
		<li class="caro_item top">
		    <a href="<?php the_permalink(); ?>">
			<?php
			$img = eff_post_image('large');
			$Fimg = aq_resize($img,314, 169, true);
			?>
			<?php if (strpos(eff_post_image(), 'youtube')) { ?>
			<img src="<?php echo eff_post_image(); ?>" width="314" height="169" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
			
			<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
			    <img src="<?php echo eff_post_image(); ?>" width="314" height="169" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
			
			<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
			    <img src="<?php echo eff_post_image(); ?>" width="314" height="169" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
			
			<?php } else { ?>
			    <img src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
			<?php } ?>
			<h2><?php short_title(60); ?></h2>
		    </a>
		</li>
		<?php endwhile; else: ?>
		<!--else here-->
		<?php endif; ?>
		<?php wp_reset_query(); ?>
		
		    
		    <?php if ($display == 'lates') { ?>
		    <?php query_posts(array('showposts' => $count, 'offset' => 2 )); ?>
		    <?php } elseif ($display == 'cat') { ?>
		    <?php query_posts(array('showposts' => $count, 'offset' => 2,'cat' => $cat )); ?>
		    <?php } elseif ($display == 'tag') { ?>
		    <?php query_posts(array('showposts' => $count, 'offset' => 2,'tag' => $tag )); ?>
		    <?php } else { ?>
		    <?php query_posts(array('showposts' => $count, 'offset' => 2 )); ?>
		    <?php } ?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<li class="caro_item">
		    <a href="<?php the_permalink(); ?>">
			<?php
			$img = eff_post_image('medium');
			$Fimg = aq_resize($img,210, 170, true);
			?>
			<?php if (strpos(eff_post_image(), 'youtube')) { ?>
			<img src="<?php echo eff_post_image(); ?>" width="210" height="170" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
			
			<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
			    <img src="<?php echo eff_post_image(); ?>" width="210" height="170" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
			
			<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
			    <img src="<?php echo eff_post_image(); ?>" width="210" height="170" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
			
			<?php } else { ?>
			    <img src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
			<?php } ?>
			<h2><?php short_title(50); ?></h2>
		    </a>
		</li>
		<?php endwhile; else: ?>
		<!--else here-->
		<?php endif; ?>
		<?php wp_reset_query(); ?>
	    </ul>
	</div>
	<?php } else { ?>
	    <div class="def_slider">
		<div class="def_sliders">
		<div class="def_slider_wrap">
			
			<?php if ($display == 'lates') { ?>
			<?php query_posts(array('showposts' => $count)); ?>
			<?php } elseif ($display == 'cat') { ?>
			<?php query_posts(array('showposts' => $count, 'cat' => $cat )); ?>
			<?php } elseif ($display == 'tag') { ?>
			<?php query_posts(array('showposts' => $count, 'tag' => $tag )); ?>
			<?php } else { ?>
			<?php query_posts(array('showposts' => $count)); ?>
			<?php } ?>
		   <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		    <div class="def_slider_item">
			<a href="<?php the_permalink(); ?>">
			    <?php
			    $img = eff_post_image('large');
			    $Fimg = aq_resize($img,630, 350, true);
			    ?>
			    <?php if (strpos(eff_post_image(), 'youtube')) { ?>
			    <img src="<?php echo eff_post_image(); ?>" width="630" height="350" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
			    
			    <?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
				<img src="<?php echo eff_post_image(); ?>" width="630" height="350" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
			    
			    <?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
				<img src="<?php echo eff_post_image(); ?>" width="630" height="350" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
			    
			    <?php } else { ?>
				<img src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
			    <?php } ?>
			</a>
			<div class="slider_caption">
			    <h2><a href="<?php the_permalink(); ?>"><?php short_title(50); ?></a></h2>   
			</div>
			<p class="caption">
			<?php global $post;
			$excerpt = $post->post_excerpt;
			if($excerpt==''){
			$excerpt = get_the_content('');
			}
			echo wp_html_excerpt(strip_shortcodes($excerpt),115);
			?> ...</p>
		    </div>
		    <?php endwhile; ?>
		    <?php  else:  ?>
		    <!-- Else in here -->
		    <?php  endif; ?>
		    <?php wp_reset_query(); ?>
		</div>
		<a href="#" id="def_next">Next</a>
		<a href="#" id="def_prev">Prev</a>
		</div>
	    </div>
	    
	    <script>
		jQuery(document).ready(function($) {
		    $('.def_slider_wrap').cycle({
			fx:     '<?php echo eff_option('cycle_effect'); ?>',
			speed: <?php echo eff_option('sli_speed'); ?>,
			prev: '#def_prev',
			next: '#def_next', 
			});
		    });
	    </script>
	<?php } ?>	
<?php } ?>
<?php function eff_nip_sc($style, $display, $cat, $title, $posts) { ?>
	    <?php
	    if($display == 'cat') {
            $cat_query = new WP_Query('cat='.$cat.'&posts_per_page='.$Posts); }
	    if($display == 'latest') {
	    $cat_query = new WP_Query('&posts_per_page='.$Posts);	
	    }
	    ?>
	    <?php if($display == 'cat') {
	    $nip_title = get_cat_name($cat);
	    $nip_link = get_category_link($cat);
	    } else {
	    $nip_title = $title;
	    $nip_link = '';
	    }
	    ?>
	    <?php if($nipstyle == 'style2') { ?>
		<!--News In pic Style 2-->
		<div class="block">
		    <div class="block_title">
			<div class="title_bg"><h2><a href="<?php echo $nip_link; ?>"><?php if( $title ) echo $nip_title; else _e('News In Picture' , 'framework') ; ?></a></h2></div>
			<span></span>
		    </div>
		    
		    <section class="section_box">
			<div class="content_inner">
			    <?php if($cat_query->have_posts()): $count=0; ?>
			    <div class="news_pic2">
				<?php while ( $cat_query->have_posts() ) : $cat_query->the_post(); $count ++ ;?>
				<a href="<?php the_permalink(); ?>" rel="bookmark">
				    <?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>			
				    <?php
				    $img = eff_post_image('thumbnail');
				    $Fimg = aq_resize($img,70, 70, true);
				    ?>
				    <?php if (strpos(eff_post_image(), 'youtube')) { ?>
				    <img src="<?php echo eff_post_image(); ?>" width="70" height="70" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="tip_n" />
				    
				    <?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
					<img src="<?php echo eff_post_image(); ?>" width="70" height="70" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="tip_n" />
				    
				    <?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
					<img src="<?php echo eff_post_image(); ?>" width="70" height="70" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="tip_n" />
				    
				    <?php } else { ?>
					<img src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="tip_n" />
				    <?php } ?>
				</a>
				<?php endif; ?>
				<?php endwhile;?>
			    </div>
			    <?php endif; ?>
			    <?php wp_reset_query(); ?>
			</div>
		    </section>
		</div>
		<!--News In pic Style 2-->
	    <?php } else { ?>
		<!--News in Pic-->
		<div class="block">
		    <div class="block_title">
			<div class="title_bg"><h2><a href="<?php echo $nip_link; ?>"><?php if( $title ) echo $nip_title; else _e('News In Picture' , 'framework') ; ?></a></h2></div>
			<span></span>
		    </div>
		    
		    <section class="section_box">
			<div class="content_inner">
			    <div class="news_pic">
				<div class="first_img">
				    <?php if($display == 'cat') {
                                    query_posts(array('showposts' => 1, 'cat' => $cat ));
                                    } else {
                                    query_posts(array('showposts' => 1 ));
                                    }
                                    ?>
                                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				    <a href="<?php the_permalink(); ?>">
					<?php
					$img = eff_post_image('medium');
					$Fimg = aq_resize($img,223, 138, true);
					?>
					<?php if (strpos(eff_post_image(), 'youtube')) { ?>
					<img src="<?php echo eff_post_image(); ?>" width="223" height="138" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="tip_n" />
					
					<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
					    <img src="<?php echo eff_post_image(); ?>" width="223" height="138" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="tip_n" />
					
					<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
					    <img src="<?php echo eff_post_image(); ?>" width="223" height="138" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="tip_n" />
					
					<?php } else { ?>
					    <img src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="tip_n" />
					<?php } ?>
				    </a>
				    <?php endwhile; else: ?>
                                    <!--else here-->
                                    <?php endif; ?>
                                    <?php wp_reset_query(); ?>
				</div>
				
				<?php if($display == 'cat') {
				query_posts(array('showposts' => 8,'offset' => 1, 'cat' => $cat ));
				} else {
				query_posts(array('showposts' => 8, 'offset' => 1 ));
				}
				?>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<a href="<?php the_permalink(); ?>" rel="bookmark">
					<?php
					$img = eff_post_image('thumbnail');
					$Fimg = aq_resize($img,71, 60, true);
					?>
					<?php if (strpos(eff_post_image(), 'youtube')) { ?>
					<img src="<?php echo eff_post_image(); ?>" width="71" height="60" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="tip_n" />
					
					<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
					    <img src="<?php echo eff_post_image(); ?>" width="71" height="60" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="tip_n" />
					
					<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
					    <img src="<?php echo eff_post_image(); ?>" width="71" height="60" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="tip_n" />
					
					<?php } else { ?>
					    <img src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="tip_n" />
					<?php } ?>
				</a>
				<?php endwhile; else: ?>
				<!--else here-->
				<?php endif; ?>
				<?php wp_reset_query(); ?>
			    </div>
			</div>
		    </section>
		</div>
		<!--News in Pic-->
	    <?php } ?>
<?php } ?>
<?php function eff_scroller_sc($style, $display, $cat, $tag, $title, $posts) { ?>
	<?php
	    global $wpdb;
	    $tag_ID = $wpdb->get_var("SELECT * FROM ".$wpdb->terms." WHERE `name` = '".$tag."'");
	?>
	    <?php if($display == 'cat') {
		$nb_title = get_cat_name($cat);
		$nb_link = get_category_link($cat);
		} elseif ($display == 'tag') {
		$nb_title = $tag;
		$nb_link = get_tag_link($tag_ID);
		} else {
		$nb_title = $title;
		$nb_link = '';
	    }
	    ?>
	    <?php if($style == 'style1') { ?>
	    <!--Crousel-->
		<div class="block rcrousel">
		    <div class="block_title">
			<div class="title_bg"><h2><a href="<?php echo $nb_link; ?>"><?php echo $nb_title; ?></a></h2></div>
			<a href="#" class="c1_next">next</a>
			<a href="#" class="c1_prev">prev</a>
			<span></span>
		    </div>
		    
		    <section class="section_box">
			<div class="content_inner">
			    <div class="crousel_style1">
				<div class="crousel1">
				    <?php if($display == 'cat') {
                                    query_posts(array('showposts' => $posts, 'cat' => $cat ));
                                    } elseif ($display == 'tag') {
                                    query_posts(array('showposts' => $posts, 'tag' => $tag ));
                                    } else {
                                    query_posts(array('showposts' => $posts ));
                                    }
                                    ?>
                                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				    <div class="cr_item">
					<div class="post_thumb">
					    <a href="<?php the_permalink(); ?>">
						<?php
						$img = eff_post_image('thumbnail');
						$Fimg = aq_resize($img,125, 67, true);
						?>
						<?php if (strpos(eff_post_image(), 'youtube')) { ?>
						<img src="<?php echo eff_post_image(); ?>" width="125" height="67" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
						    <img src="<?php echo eff_post_image(); ?>" width="125" height="67" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
						    <img src="<?php echo eff_post_image(); ?>" width="125" height="67" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } else { ?>
						    <img src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						<?php } ?>
					    </a>
					</div>
					<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php short_title(40); ?></a></h2>
					<span class="post_meta"><?php the_time('F d, Y');  ?></span>
				    </div>
				    <?php endwhile; else: ?>
				    <!--else here-->
				    <?php endif; ?>
				    <?php wp_reset_query(); ?>
				</div>
			    </div>
			</div>
		    </section>
		</div>
		<!--Crousel-->
		<script>
		    jQuery(document).ready(function($) {
			//latest vids wrap
			var vids = $(".cr_item");
			for(var i = 0; i < vids.length; i+=4) {
			  vids.slice(i, i+4).wrapAll('<div class="four_items"></div>');
			}
			//Crousel Style1
		       $('.crousel1').cycle({
			prev: '.c1_prev',
			next: '.c1_next',
			slideExpr: '.four_items',
			slideResize: 0,
			pause: 1,
			easing: 'swing',
			<?php if( is_rtl() ) { ?>
			fx: 'scrollRight',
			<?php } else { ?>
			fx: 'scrollHorz',
			<?php } ?>
			cleartype: true,
			cleartypeNoBg: true,
			speed: <?php echo eff_option('c_speed'); ?>,
			<?php if (eff_option('c_auto') != false ) { ?>
			 timeout:<?php echo eff_option('c_auto_time'); ?>,
			<?php } else { ?>
			 timeout:0,
			<?php } ?>
		    });
		    });
		</script>
		<?php } else { ?>
		<!--Crousel Style2-->
		<div class="block rcrousel">
		    <div class="block_title">
			<div class="title_bg"><h2><a href="<?php echo $nb_link; ?>"><?php echo $nb_title; ?></a></h2></div>
			<a href="#" class="c2_next">next</a>
			<a href="#" class="c2_prev">prev</a>
			<span></span>
		    </div>
		    
			    <div class="crousel_style2">
				<div class="crousel2">
				    <?php if($display == 'cat') {
                                    query_posts(array('showposts' => $posts, 'cat' => $cat ));
                                    } elseif ($display == 'tag') {
                                    query_posts(array('showposts' => $posts, 'tag' => $tag ));
                                    } else {
                                    query_posts(array('showposts' => $posts ));
                                    }
                                    ?>
                                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				    <div class="cr_item">
					<div class="section_box_2">
					    <a href="<?php the_permalink(); ?>">
						<?php
						$img = eff_post_image('thumbnail');
						$Fimg = aq_resize($img,154, 103, true);
						?>
						<?php if (strpos(eff_post_image(), 'youtube')) { ?>
						<img src="<?php echo eff_post_image(); ?>" width="154" height="103" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
						    <img src="<?php echo eff_post_image(); ?>" width="154" height="103" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
						    <img src="<?php echo eff_post_image(); ?>" width="154" height="103" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } else { ?>
						    <img src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						<?php } ?>
					    </a>
					<div class="stylebox2">
					<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php short_title(45); ?></a></h2>
					</div>
					</div>
				    </div>
				    <?php endwhile; else: ?>
				    <!--else here-->
				    <?php endif; ?>
				    <?php wp_reset_query(); ?>
				</div>
			    </div>
		</div>
		<!--Crousel Style2-->
		<script>
		    jQuery(document).ready(function($) {
			//latest vids wrap
			var vids = $(".cr_item");
			for(var i = 0; i < vids.length; i+=4) {
			  vids.slice(i, i+4).wrapAll('<div class="four_items"></div>');
			}
			//Crousel Style1
		       $('.crousel2').cycle({
			prev: '.c2_prev',
			next: '.c2_next',
			slideExpr: '.four_items',
			slideResize: 0,
			pause: 1,
			easing: 'swing',
			<?php if( is_rtl() ) { ?>
			fx: 'scrollRight',
			<?php } else { ?>
			fx: 'scrollHorz',
			<?php } ?>
			cleartype: true,
			cleartypeNoBg: true,
			speed: <?php echo eff_option('c_speed'); ?>,
			<?php if (eff_option('c_auto') != false ) { ?>
			 timeout:<?php echo eff_option('c_auto_time'); ?>,
			<?php } else { ?>
			 timeout:0,
			<?php } ?>
		    });
		    });
		</script>
		<?php } ?>
<?php } ?>
<?php function eff_latest_videos_sc($order, $title, $count) { ?>
	    <!--Crousel-->
		<div class="block rcrousel">
		    <div class="block_title">
			<div class="title_bg"><h2><a href="#"><?php echo $title; ?></a></h2></div>
			<a href="#" class="lv_next">next</a>
			<a href="#" class="lv_prev">prev</a>
			<span></span>
		    </div>
		    
		    <section class="section_box">
			<div class="content_inner">
			    <div class="crousel_style1_lv">
				<div class="crousel1_lv">
				    <?php query_posts(array(  'showposts' => $count, 'meta_key' => 'eff_article_type', 'meta_value' => 'video', 'orderby' => $order  )); ?>
                                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				    <div class="lv_item">
					<div class="post_thumb">
					    <a href="<?php the_permalink(); ?>">
						<?php
						$img = eff_post_image('thumbnail');
						$Fimg = aq_resize($img,125, 93, true);
						?>
						<?php if (strpos(eff_post_image(), 'youtube')) { ?>
						<img src="<?php echo eff_post_image(); ?>" width="125" height="93" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
						    <img src="<?php echo eff_post_image(); ?>" width="125" height="93" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
						    <img src="<?php echo eff_post_image(); ?>" width="125" height="93" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } else { ?>
						    <img src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						<?php } ?>
					    </a>
					</div>
					<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php short_title(40); ?></a></h2>
					<span class="post_meta"><?php the_time('F d, Y');  ?></span>	
				    </div>
				    <?php endwhile; else: ?>
				    <!--else here-->
				    <?php endif; ?>
				    <?php wp_reset_query(); ?>
				</div>
			    </div>
			</div>
		    </section>
		</div>
		<!--Crousel-->
		<script>
		    jQuery(document).ready(function($) {
			//latest vids wrap
			var vids = $(".lv_item");
			for(var i = 0; i < vids.length; i+=4) {
			  vids.slice(i, i+4).wrapAll('<div class="four_items"></div>');
			}
			//Crousel Style1
		       $('.crousel1_lv').cycle({
			prev: '.lv_prev',
			next: '.lv_next',
			slideExpr: '.four_items',
			slideResize: 0,
			pause: 1,
			easing: 'swing',
			<?php if( is_rtl() ) { ?>
			fx: 'scrollRight',
			<?php } else { ?>
			fx: 'scrollHorz',
			<?php } ?>
			cleartype: true,
			cleartypeNoBg: true,
			speed: <?php echo eff_option('lv_speed'); ?>,
			<?php if (eff_option('lv_auto') != false ) { ?>
			 timeout:<?php echo eff_option('lv_auto_time'); ?>,
			<?php } else { ?>
			 timeout:0,
			<?php } ?>
		    });
		    });
		</script>
<?php } ?>