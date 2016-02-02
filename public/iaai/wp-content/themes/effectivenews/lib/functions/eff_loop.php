<?php
function eff_news_box($num){ ?>
	<?php
	    $display= eff_option('nb'.$num.'_display');
	    $cat = eff_option('nb'.$num.'_category');
	    $tag = eff_option('nb'.$num.'_tag');
	    $title = eff_option('nb'.$num.'_title');
	    $style = eff_option('nb'.$num.'_style');
	    $posts = eff_option('nb'.$num.'_posts');
	    $eln = eff_option('nb'.$num.'_num');
	    $tl = eff_option('nb'.$num.'_tl');
	    $dateformat = eff_option('hp_date_format');
	    $hpcomment = eff_option('hp_comment');

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
                <div class="block cat_<?php echo $cat ; ?>">
                    <div class="block_title">
                       <div class="title_bg"> <h2><a href="<?php echo $nb_link; ?>"><?php echo $nb_title; ?></a></h2></div>
                        <span></span>
                    </div>
                    
                    <section class="section_box">
                            <div class="news_box2">
                                <div class="first_news" itemscope="" itemtype="http://schema.org/Article">
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
					    $img = eff_post_image('newsbox2');
					    $Fimg = aq_resize($img,277, 153, true);
					    ?>
					    <?php if (strpos(eff_post_image(), 'youtube')) { ?>
					    <img itemprop="image" src="<?php echo eff_post_image(); ?>" width="277" height="153" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					    
					    <?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
						<img itemprop="image" src="<?php echo eff_post_image(); ?>" width="277" height="153" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					    
					    <?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
						<img itemprop="image" src="<?php echo eff_post_image(); ?>" width="277" height="153" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					    
					    <?php } else { ?>
						<img itemprop="image" src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					    <?php } ?>
                                        </a>
                                    </div>
                                    <h2 itemprop="name"><a href="<?php the_permalink(); ?>" itemprop="url" rel="bookmark"><?php if($tl == true) {short_title($tl);} else {the_title();} ?></a></h2>
                                    <span class="post_meta"><?php the_time($dateformat);  ?><?php if($hpcomment == true) { ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a><?php } ?>
				    <meta itemprop="interactionCount" content="<?php comments_number( 'UserComments: 0', 'UserComments: 1', 'UserComments: %' ); ?>">
				    <?php
					$rt_enable = get_post_meta($post->ID, 'eff_enable_review', true);
					$rt_style = get_post_meta($post->ID, 'eff_review_style', true);
					$percent_score = get_post_meta($post->ID, 'eff_rt_final_score', true);
					$points_score = get_post_meta($post->ID, 'eff_rt_final_score_po', true);
					$stars_score = get_post_meta($post->ID, 'eff_rt_final_score_stars', true);
					if($rt_enable) {
					    if($rt_style == 'stars') {
						echo '<span class="rt_nb_rev rt_nb_star"><span class="rt_stars_post" title="'. $percent_score . '%">
							  <span class="rt_stars_post_rate" style="width:'. $percent_score . '%;"></span>
						     </span></span>';
					    }
					    if($rt_style == 'percent') {
						echo '<span class="rt_nb_rev" title="'. $percent_score .'">
						<span class="percent_post">'. $percent_score .'%</span>
						</span>';
					    }
				
					    if($rt_style == 'points') {
						echo '<span class="rt_nb_rev" title="'. $points_score .'">
						<span class="percent_post">'. $points_score .'</span>
						</span>';
					    }
				
					}
					?>
				    </span>
                                    <p>
					<?php global $post;
					$excerpt = $post->post_excerpt;
					if($excerpt==''){
					$excerpt = get_the_content('');
					}
					echo wp_html_excerpt(strip_shortcodes($excerpt),$eln);
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
                                    <li itemscope="" itemtype="http://schema.org/Article">
                                        <div class="post_thumb">
                                            <a href="<?php the_permalink(); ?>" rel="bookmark">
                                               <?php
						$img = eff_post_image('small-thumb');
						$Fimg = aq_resize($img,50, 50, true);
						?>
						<?php if (strpos(eff_post_image(), 'youtube')) { ?>
						<img itemprop="image" src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
						    <img itemprop="image" src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
						    <img itemprop="image" src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } else { ?>
						    <img itemprop="image" src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						<?php } ?>
                                            </a>
                                        </div>
                                        <h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>" rel="bookmark"><?php if($tl == true) {short_title($tl);} else {the_title();} ?></a></h2>
                                        <span class="post_meta"><?php the_time($dateformat);  ?><?php if($hpcomment == true) { ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a><?php } ?>
					<meta itemprop="interactionCount" content="<?php comments_number( 'UserComments: 0', 'UserComments: 1', 'UserComments: %' ); ?>">
					</span>
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
                    <div class="block cat_<?php echo $cat ; ?>">
                        <div class="news_box3">
                            <div class="block_title">
                                <div class="title_bg"><h2><a href="<?php echo $nb_link; ?>"><?php echo $nb_title; ?></a></h2></div>
                                <span></span>
                            </div>
                            
                            <section class="section_box">
                                <div class="content_inner">
                                    <div class="first_news" itemscope="" itemtype="http://schema.org/Article">
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
						$img = eff_post_image('newsbox3');
						$Fimg = aq_resize($img,250, 143, true);
						?>
						<?php if (strpos(eff_post_image(), 'youtube')) { ?>
						<img itemprop="image" src="<?php echo eff_post_image(); ?>" width="250" height="143" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
						    <img itemprop="image" src="<?php echo eff_post_image(); ?>" width="250" height="143" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
						    <img itemprop="image" src="<?php echo eff_post_image(); ?>" width="250" height="143" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } else { ?>
						    <img itemprop="image" src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						<?php } ?>
                                            </a>
                                        </div>
                                        <h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>" rel="bookmark"><?php if($tl == true) {short_title($tl);} else {the_title();} ?></a></h2>
                                        <span class="post_meta"><?php the_time($dateformat);  ?><?php if($hpcomment == true) { ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a><?php } ?>
					<?php
					$rt_enable = get_post_meta($post->ID, 'eff_enable_review', true);
					$rt_style = get_post_meta($post->ID, 'eff_review_style', true);
					$percent_score = get_post_meta($post->ID, 'eff_rt_final_score', true);
					$points_score = get_post_meta($post->ID, 'eff_rt_final_score_po', true);
					$stars_score = get_post_meta($post->ID, 'eff_rt_final_score_stars', true);
					if($rt_enable) {
					    if($rt_style == 'stars') {
						echo '<span class="rt_nb_rev rt_nb_star"><span class="rt_stars_post" title="'. $percent_score . '%">
							  <span class="rt_stars_post_rate" style="width:'. $percent_score . '%;"></span>
						     </span></span>';
					    }
					    if($rt_style == 'percent') {
						echo '<span class="rt_nb_rev" title="'. $percent_score .'">
						<span class="percent_post">'. $percent_score .'%</span>
						</span>';
					    }
				
					    if($rt_style == 'points') {
						echo '<span class="rt_nb_rev" title="'. $points_score .'">
						<span class="percent_post">'. $points_score .'</span>
						</span>';
					    }
				
					}
					?>
					</span>
					<p>
					    <?php global $post;
					    $excerpt = $post->post_excerpt;
					    if($excerpt==''){
					    $excerpt = get_the_content('');
					    }
					    echo wp_html_excerpt(strip_shortcodes($excerpt),$eln);
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
                                    <li itemscope="" itemtype="http://schema.org/Article">
                                        <div class="post_thumb">
                                            <a href="<?php the_permalink(); ?>" rel="bookmark">
                                                <?php
						$img = eff_post_image('small-thumb');
						$Fimg = aq_resize($img,50, 50, true);
						?>
						<?php if (strpos(eff_post_image(), 'youtube')) { ?>
						<img itemprop="image"src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
						    <img itemprop="image" src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
						    <img itemprop="image" src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } else { ?>
						    <img itemprop="image" src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						<?php } ?>
                                            </a>
                                        </div>
                                        <h2 itemprop="name"><a itemprop="url"href="<?php the_permalink(); ?>"><?php if($tl == true) {short_title($tl);} else {the_title();} ?></a></h2>
                                        <span class="post_meta"><?php the_time($dateformat);  ?><?php if($hpcomment == true) { ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a><?php } ?>
					</span>
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
                <div class="block cat_<?php echo $cat ; ?>">
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
                                    <li itemscope="" itemtype="http://schema.org/Article">
                                        <div class="post_thumb">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php
						$img = eff_post_image('newsbox2');
						$Fimg = aq_resize($img,277, 153, true);
						?>
						<?php if (strpos(eff_post_image(), 'youtube')) { ?>
						<img itemprop="image" src="<?php echo eff_post_image(); ?>" width="277" height="153" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
						    <img itemprop="image" src="<?php echo eff_post_image(); ?>" width="277" height="153" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
						    <img itemprop="image" src="<?php echo eff_post_image(); ?>" width="277" height="153" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } else { ?>
						    <img itemprop="image" src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						<?php } ?>
                                            </a>
                                        </div>
                                        <h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>" rel="bookmark"><?php if($tl == true) {short_title($tl);} else {the_title();} ?></a></h2>
                                        <span class="post_meta"><?php the_time($dateformat);  ?><?php if($hpcomment == true) { ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a><?php } ?>
					<?php
					$rt_enable = get_post_meta($post->ID, 'eff_enable_review', true);
					$rt_style = get_post_meta($post->ID, 'eff_review_style', true);
					$percent_score = get_post_meta($post->ID, 'eff_rt_final_score', true);
					$points_score = get_post_meta($post->ID, 'eff_rt_final_score_po', true);
					$stars_score = get_post_meta($post->ID, 'eff_rt_final_score_stars', true);
					if($rt_enable) {
					    if($rt_style == 'stars') {
						echo '<span class="rt_nb_rev rt_nb_star"><span class="rt_stars_post" title="'. $percent_score . '%">
							  <span class="rt_stars_post_rate" style="width:'. $percent_score . '%;"></span>
						     </span></span>';
					    }
					    if($rt_style == 'percent') {
						echo '<span class="rt_nb_rev" title="'. $percent_score .'">
						<span class="percent_post">'. $percent_score .'%</span>
						</span>';
					    }
				
					    if($rt_style == 'points') {
						echo '<span class="rt_nb_rev" title="'. $points_score .'">
						<span class="percent_post">'. $points_score .'</span>
						</span>';
					    }
				
					}
					?>
					</span>
                                        <p>
					    <?php global $post;
					    $excerpt = $post->post_excerpt;
					    if($excerpt==''){
					    $excerpt = get_the_content('');
					    }
					    echo wp_html_excerpt(strip_shortcodes($excerpt),$eln);
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
                <div class="block cat_<?php echo $cat ; ?>">
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
					<div class="box5_inner" itemscope="" itemtype="http://schema.org/Article">
					    <div class="post_thumb2">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php
						$img = eff_post_image('newsbox5');
						$Fimg = aq_resize($img,306, 222, true);
						?>
						<?php if (strpos(eff_post_image(), 'youtube')) { ?>
						<img itemprop="image" src="<?php echo eff_post_image(); ?>" width="306" height="222" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
						    <img itemprop="image" src="<?php echo eff_post_image(); ?>" width="306" height="222" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
						    <img itemprop="image" src="<?php echo eff_post_image(); ?>" width="306" height="222" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } else { ?>
						    <img itemprop="image" src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						<?php } ?>
                                            </a>
					    </div>
					<div class="box5_content">
                                        <h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>" rel="bookmark"><?php if($tl == true) {short_title($tl);} else {the_title();} ?></a></h2>
                                        <span class="post_meta"><?php the_time($dateformat);  ?><?php if($hpcomment == true) { ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a><?php } ?>
					<?php
					$rt_enable = get_post_meta($post->ID, 'eff_enable_review', true);
					$rt_style = get_post_meta($post->ID, 'eff_review_style', true);
					$percent_score = get_post_meta($post->ID, 'eff_rt_final_score', true);
					$points_score = get_post_meta($post->ID, 'eff_rt_final_score_po', true);
					$stars_score = get_post_meta($post->ID, 'eff_rt_final_score_stars', true);
					if($rt_enable) {
					    if($rt_style == 'stars') {
						echo '<span class="rt_nb_rev rt_nb_star"><span class="rt_stars_post" title="'. $percent_score . '%">
							  <span class="rt_stars_post_rate" style="width:'. $percent_score . '%;"></span>
						     </span></span>';
					    }
					    if($rt_style == 'percent') {
						echo '<span class="rt_nb_rev" title="'. $percent_score .'">
						<span class="percent_post">'. $percent_score .'%</span>
						</span>';
					    }
				
					    if($rt_style == 'points') {
						echo '<span class="rt_nb_rev" title="'. $points_score .'">
						<span class="percent_post">'. $points_score .'</span>
						</span>';
					    }
				
					}
					?>
					</span>
                                        <p>
					    <?php global $post;
					    $excerpt = $post->post_excerpt;
					    if($excerpt==''){
					    $excerpt = get_the_content('');
					    }
					    echo wp_html_excerpt(strip_shortcodes($excerpt),$eln);
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
                <div class="block cat_<?php echo $cat ; ?>">
                    <div class="block_title">
                        <div class="title_bg"><h2><a href="<?php echo $nb_link; ?>"><?php echo $nb_title; ?></a></h2></div>
                        <span></span>
                    </div>
                    
                    <section class="section_box">
                            <div class="news_box1">
                                <div class="first_news" itemscope="" itemtype="http://schema.org/Article">
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
					    $img = eff_post_image('newsbox1');
					    $Fimg = aq_resize($img,277, 147, true);
					    ?>
					    <?php if (strpos(eff_post_image(), 'youtube')) { ?>
					    <img itemprop="image" src="<?php echo eff_post_image(); ?>" width="277" height="147" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					    
					    <?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
						<img itemprop="image" src="<?php echo eff_post_image(); ?>" width="277" height="147" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					    
					    <?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
						<img itemprop="image" src="<?php echo eff_post_image(); ?>" width="277" height="147" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					    
					    <?php } else { ?>
						<img itemprop="image" src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					    <?php } ?>
                                        </a>
                                    </div>
                                    <h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>" rel="bookmark"><?php if($tl == true) {short_title($tl);} else {the_title();} ?></a></h2>
                                    <span class="post_meta"><?php the_time($dateformat);  ?><?php if($hpcomment == true) { ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a><?php } ?>
				    <?php
					$rt_enable = get_post_meta($post->ID, 'eff_enable_review', true);
					$rt_style = get_post_meta($post->ID, 'eff_review_style', true);
					$percent_score = get_post_meta($post->ID, 'eff_rt_final_score', true);
					$points_score = get_post_meta($post->ID, 'eff_rt_final_score_po', true);
					$stars_score = get_post_meta($post->ID, 'eff_rt_final_score_stars', true);
					if($rt_enable) {
					    if($rt_style == 'stars') {
						echo '<span class="rt_nb_rev rt_nb_star"><span class="rt_stars_post" title="'. $percent_score . '%">
							  <span class="rt_stars_post_rate" style="width:'. $percent_score . '%;"></span>
						     </span></span>';
					    }
					    if($rt_style == 'percent') {
						echo '<span class="rt_nb_rev" title="'. $percent_score .'">
						<span class="percent_post">'. $percent_score .'%</span>
						</span>';
					    }
				
					    if($rt_style == 'points') {
						echo '<span class="rt_nb_rev" title="'. $points_score .'">
						<span class="percent_post">'. $points_score .'</span>
						</span>';
					    }
				
					}
					?>
				    </span>
                                    <p>
					<?php global $post;
					$excerpt = $post->post_excerpt;
					if($excerpt==''){
					$excerpt = get_the_content('');
					}
					echo wp_html_excerpt(strip_shortcodes($excerpt),$eln);
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
                                    <li itemscope="" itemtype="http://schema.org/Article">
                                        <div class="post_thumb">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php
						$img = eff_post_image('small-thumb');
						$Fimg = aq_resize($img,50, 50, true);
						?>
						<?php if (strpos(eff_post_image(), 'youtube')) { ?>
						<img itemprop="image" src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
						    <img itemprop="image" src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
						    <img itemprop="image" src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						
						<?php } else { ?>
						    <img itemprop="image" src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
						<?php } ?>
                                            </a>
                                        </div>
                                        <h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>" rel="bookmark"><?php if($tl == true) {short_title($tl);} else {the_title();} ?></a></h2>
                                        <span class="post_meta"><?php the_time($dateformat);  ?><?php if($hpcomment == true) { ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a><?php } ?></span>
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
<?php function eff_nip() { ?>
	    <?php
	    $nipdisplay= eff_option('nip_display');
	    $nipcat = eff_option('nip_cat');
	    $niptitle = eff_option('nip_title');
	    $nipPosts = eff_option('nip_number');
	    $nipstyle = eff_option('nip_style');
            
	    if($nipdisplay == 'cat') {
            $nipcat_query = new WP_Query('cat='.$nipcat.'&posts_per_page='.$nipPosts); }
	    if($nipdisplay == 'latest') {
	    $nipcat_query = new WP_Query('&posts_per_page='.$nipPosts);	
	    }
	    ?>
	    <?php if($nipdisplay == 'cat') {
	    $nip_title = get_cat_name($nipcat);
	    $nip_link = get_category_link($nipcat);
	    } else {
	    $nip_title = $niptitle;
	    $nip_link = '';
	    }
	    ?>
	    <?php if($nipstyle == 'style2') { ?>
		<!--News In pic Style 2-->
		<div class="block">
		    <div class="block_title">
			<div class="title_bg"><h2><a href="<?php echo $nip_link; ?>"><?php if( $niptitle ) echo $nip_title; else _e('News In Picture' , 'framework') ; ?></a></h2></div>
			<span></span>
		    </div>
		    
		    <section class="section_box">
			<div class="content_inner">
			    <?php if($nipcat_query->have_posts()): $count=0; ?>
			    <div class="news_pic2">
				<?php while ( $nipcat_query->have_posts() ) : $nipcat_query->the_post(); $count ++ ;?>
				<div class="post_thumb2">
				<a href="<?php the_permalink(); ?>" rel="bookmark">
				    <?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>			
				    <?php
				    $img = eff_post_image('newspic');
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
				</div>
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
			<div class="title_bg"><h2><a href="<?php echo $nip_link; ?>"><?php if( $niptitle ) echo $nip_title; else _e('News In Picture' , 'framework') ; ?></a></h2></div>
			<span></span>
		    </div>
		    
		    <section class="section_box">
			<div class="content_inner">
			    <div class="news_pic">
				<div class="first_img">
				    <?php if($nipdisplay == 'cat') {
                                    query_posts(array('showposts' => 1, 'cat' => $nipcat ));
                                    } else {
                                    query_posts(array('showposts' => 1 ));
                                    }
                                    ?>
                                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				    <div class="post_thumb2">
				    <a href="<?php the_permalink(); ?>">
					<?php
					$img = eff_post_image('newspic2');
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
				    </div>
				    <?php endwhile; else: ?>
                                    <!--else here-->
                                    <?php endif; ?>
                                    <?php wp_reset_query(); ?>
				</div>
				
				<?php if($nipdisplay == 'cat') {
				query_posts(array('showposts' => 8,'offset' => 1, 'cat' => $nipcat ));
				} else {
				query_posts(array('showposts' => 8, 'offset' => 1 ));
				}
				?>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<a href="<?php the_permalink(); ?>" rel="bookmark">
					<?php
					$img = eff_post_image('newspic3');
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
<?php function eff_breaking() { ?>
	    <?php
	    $brdisplay= eff_option('breaking_display');
	    $brcat = eff_option('breaking_category');
	    $brposts = eff_option('breaking_number');
	    $brcustom  = eff_option('breaking_custom');
	    ?>
	    
	    <div class="breaking_news">
		<?php if(eff_option('br_tite') == true) { ?>
                <span class="ticker_title"><?php echo eff_option('br_tite'); ?></span>
		<?php } ?>
		<div class="ticker_bg">
		<span class="wrap_arrow"></span>
                <div class="ticker_wrap">
                    <ul id="ticker">
			<?php if ($brdisplay == 'custom') { ?>
			<?php
			$brcustom = '<li>'.str_replace(array("\r","\n\n","\n"),array('',"\n","</li>\n<li>"),trim($brcustom,"\n\r")).'</li>';
			echo $brcustom;
			?>
			<?php } else { ?>
			<?php if($brdisplay == 'cat') {
			query_posts(array('showposts' => $brposts, 'cat' => $brcat ));
			} else if($brdisplay == 'latest') {
			query_posts(array('showposts' => $brposts ));
			}
			?>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                        <li><a href="<?php the_permalink(); ?>" rel="bookmark">&raquo; <?php the_title(); ?></a></li>
			<?php endwhile; else: ?>
			<!--else here-->
			<?php endif; ?>
			<?php wp_reset_query(); ?>
			<?php } ?>
                    </ul>
                </div>
		</div>
            </div>
	    <script>
		jQuery(document).ready(function($) {
		    //News Teaker
		    $(function() {
			var _scroll = {
				delay:  <?php echo eff_option('breaking_delay'); ?> ,
				easing: 'linear',
				items: 1,
				duration:  <?php echo eff_option('breaking_duration'); ?> ,
				timeoutDuration: 0,
				pauseOnHover: 'immediate'
			};
			$('#ticker').carouFredSel({
				width: 1000,
				align: false,
				<?php if (is_rtl()) { ?>
				    direction: "right",
				<?php } ?>
				items: {
					width: 'variable',
					height: 35,
					visible: 1
				},
				scroll: _scroll
			});
			$('ticker ul li:last').width(2000);
		    });
		});
	    </script>
<?php } ?>
<?php function eff_scroller() { ?>
	<?php
	    $ncdisplay= eff_option('nc_display');
	    $nccat = eff_option('nc_category');
	    $nctag = eff_option('nc_tag');
	    $nctitle = eff_option('nc_title');
	    $ncposts = eff_option('nc_posts');
	    
	    $ncstyle= eff_option('nc_style');

	    global $wpdb;
	    $tag_ID = $wpdb->get_var("SELECT * FROM ".$wpdb->terms." WHERE `name` = '".$nctag."'");
	?>
	    <?php if($ncdisplay == 'cat') {
		$nb_title = get_cat_name($nccat);
		$nb_link = get_category_link($nccat);
		} elseif ($ncdisplay == 'tag') {
		$nb_title = $nctag;
		$nb_link = get_tag_link($tag_ID);
		} else {
		$nb_title = $nctitle;
		$nb_link = '';
	    }
	    ?>
	    <?php if($ncstyle == 'style1') { ?>
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
				    <?php if($ncdisplay == 'cat') {
                                    query_posts(array('showposts' => $ncposts, 'cat' => $nccat ));
                                    } elseif ($ncdisplay == 'tag') {
                                    query_posts(array('showposts' => $ncposts, 'tag' => $nctag ));
                                    } else {
                                    query_posts(array('showposts' => $ncposts ));
                                    }
                                    ?>
                                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				    <div class="cr_item">
					<div class="post_thumb">
					    <a href="<?php the_permalink(); ?>">
						<?php
						$img = eff_post_image('caro1');
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
					<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					<span class="post_meta"><?php the_time($dateformat);  ?></span>
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
				    <?php if($ncdisplay == 'cat') {
                                    query_posts(array('showposts' => $ncposts, 'cat' => $nccat ));
                                    } elseif ($ncdisplay == 'tag') {
                                    query_posts(array('showposts' => $ncposts, 'tag' => $nctag ));
                                    } else {
                                    query_posts(array('showposts' => $ncposts ));
                                    }
                                    ?>
                                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				    <div class="cr_item">
					<div class="section_box_2">
					    <div class="post_thumb2">
					    <a href="<?php the_permalink(); ?>">
						<?php
						$img = eff_post_image('caro2');
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
					    </div>
					<div class="stylebox2">
					<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
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
<?php function eff_latest_videos() { ?>
	<?php
	    $lv_title= eff_option('lv_title');
	    $sOrder = eff_option('lv_order');
            $count = eff_option('lv_count');
	?>
	    <!--Crousel-->
		<div class="block rcrousel">
		    <div class="block_title">
			<div class="title_bg"><h2><a href="#"><?php echo $lv_title; ?></a></h2></div>
			<a href="#" class="lv_next">next</a>
			<a href="#" class="lv_prev">prev</a>
			<span></span>
		    </div>
		    
		    <section class="section_box">
			<div class="content_inner">
			    <div class="crousel_style1_lv">
				<div class="crousel1_lv">
				    <?php query_posts(array(  'showposts' => $count, 'meta_key' => 'eff_article_type', 'meta_value' => 'video', 'orderby' => $sOrder  )); ?>
                                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				    <div class="lv_item">
					<div class="post_thumb">
					    <a href="<?php the_permalink(); ?>">
						<?php
						$img = eff_post_image('medium');
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
					<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					<span class="post_meta"><?php the_time($dateformat);  ?></span>	
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
<?php function eff_slider() { ?>
	<?php if(eff_option('sliders') == 'cyc') { ?>  
	    <!--Slider-->
		    <section class="slider_section_box">
			<div class="slider">
			    <div class="slider_wrap">
				<div class="cycle_slider">
				    <?php
				    $f_display = eff_option('sli_display');
				    $f_cat = eff_option('sli_category');
				    $f_tag = eff_option('sli_tag');
				    $f_count = eff_option('slider_count');
				    ?>
				    
				    <?php if ($f_display == 'cat') { ?>
				    <?php query_posts(array('showposts' => $f_count, 'cat' => $f_cat )); ?>
				    <?php } elseif ($f_display == 'tag') { ?>
				    <?php query_posts(array('showposts' => $f_count, 'tag' => $f_tag )); ?>
				    <?php } else { ?>
				    <?php query_posts(array('showposts' => $f_count)); ?>
				    <?php } ?>
				    
				    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				    <div class="slider_item">
					<a href="<?php the_permalink(); ?>">
					    <?php
					    $img = eff_post_image('cycleslider');
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
					    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
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
				<?php if ($f_display == 'cat') { ?>
				<?php query_posts(array('showposts' => $f_count, 'cat' => $f_cat )); ?>
				<?php } elseif ($f_display == 'tag') { ?>
				<?php query_posts(array('showposts' => $f_count, 'tag' => $f_tag )); ?>
				<?php } else { ?>
				<?php query_posts(array('showposts' => $f_count)); ?>
				<?php } ?>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
				<li>
				    <a href="<?php the_permalink(); ?>" rel="bookmark">
					<?php
					$img = eff_post_image('medium');
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
	<?php } elseif(eff_option('sliders') == 'filex') { ?>
		    <section class="slider_section_box">
			<div class="slider">
			    <div class="flexslider"><!-- Slideshow -->
			    <ul class="slides">
				    <?php
				    $f_display = eff_option('sli_display');
				    $f_cat = eff_option('sli_category');
				    $f_tag = eff_option('sli_tag');
				    $f_count = eff_option('slider_count');
				    ?>
				    
				    <?php if ($f_display == 'cat') { ?>
				    <?php query_posts(array('showposts' => $f_count, 'cat' => $f_cat )); ?>
				    <?php } elseif ($f_display == 'tag') { ?>
				    <?php query_posts(array('showposts' => $f_count, 'tag' => $f_tag )); ?>
				    <?php } else { ?>
				    <?php query_posts(array('showposts' => $f_count)); ?>
				    <?php } ?>
			       <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<li class="slider_item">
				<a href="<?php the_permalink(); ?>">
				<?php
				$img = eff_post_image('cycleslider');
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
	<?php } elseif(eff_option('sliders') == 'caro') { ?>
	<div class="caro_slider">
	    <ul>
		<?php
		    $f_display = eff_option('sli_display');
		    $f_cat = eff_option('sli_category');
		    $f_tag = eff_option('sli_tag');
		    ?>
		    
		    <?php if ($f_display == 'cat') { ?>
		    <?php query_posts(array('showposts' => 2, 'cat' => $f_cat )); ?>
		    <?php } elseif ($f_display == 'tag') { ?>
		    <?php query_posts(array('showposts' => 2, 'tag' => $f_tag )); ?>
		    <?php } else { ?>
		    <?php query_posts(array('showposts' => 2)); ?>
		    <?php } ?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>    
		<li class="caro_item top">
		    <a href="<?php the_permalink(); ?>">
			<?php
			$img = eff_post_image('caroslider');
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
			<h2><?php the_title(); ?></h2>
		    </a>
		</li>
		<?php endwhile; else: ?>
		<!--else here-->
		<?php endif; ?>
		<?php wp_reset_query(); ?>
		
		<?php
		    $f_display = eff_option('sli_display');
		    $f_cat = eff_option('sli_category');
		    $f_tag = eff_option('sli_tag');
		    $f_count = eff_option('slider_count');
		    ?>
		    
		    <?php if ($f_display == 'cat') { ?>
		    <?php query_posts(array('showposts' => $f_count,'offset' => 2, 'cat' => $f_cat )); ?>
		    <?php } elseif ($f_display == 'tag') { ?>
		    <?php query_posts(array('showposts' => $f_count,'offset' => 2, 'tag' => $f_tag )); ?>
		    <?php } else { ?>
		    <?php query_posts(array('showposts' => $f_count,'offset' => 2)); ?>
		    <?php } ?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<li class="caro_item">
		    <a href="<?php the_permalink(); ?>">
			<?php
			$img = eff_post_image('caroslider2');
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
			<h2><?php the_title(); ?></h2>
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
		    <?php
			$f_display = eff_option('sli_display');
			$f_cat = eff_option('sli_category');
			$f_tag = eff_option('sli_tag');
			$f_count = eff_option('slider_count');
			?>
			
			<?php if ($f_display == 'cat') { ?>
			<?php query_posts(array('showposts' => $f_count, 'cat' => $f_cat )); ?>
			<?php } elseif ($f_display == 'tag') { ?>
			<?php query_posts(array('showposts' => $f_count, 'tag' => $f_tag )); ?>
			<?php } else { ?>
			<?php query_posts(array('showposts' => $f_count)); ?>
			<?php } ?>
		   <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		    <div class="def_slider_item">
			<a href="<?php the_permalink(); ?>">
			    <?php
			    $img = eff_post_image('defslider');
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
			    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>   
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
<?php function eff_top_banner() { ?>
	<?php if(eff_option('tb_size') == 'big') { ?>
	    <div class="top_banner_big">
                <?php if(eff_option('tb_img')) { ?>
		<a href="<?php echo eff_option('tb_url'); ?>">
		<img src="<?php echo eff_option('tb_img'); ?>" alt="">
		</a>
		<?php } elseif(eff_option('tb_code')) { 
		    echo eff_option('tb_code');
		} else { ?>
		<a href="#"><img src="<?php echo EFF_IMG; ?>/banner728.png" alt=""></a>
		<?php } ?>
            </div>
	<?php } else { ?>
	    <div class="top_banner">
                <?php if(eff_option('tb_img')) { ?>
		<a href="<?php echo eff_option('tb_url'); ?>">
		<img src="<?php echo eff_option('tb_img'); ?>" alt="">
		</a>
		<?php } elseif(eff_option('tb_code')) { 
		    echo eff_option('tb_code');
		} else { ?>
		<a href="#"><img src="<?php echo EFF_IMG; ?>/banner.png" alt=""></a>
		<?php } ?>
            </div>
	<?php } ?>
<?php } ?>
<?php function eff_bottom_banner() { ?>
	    <!--Bottom Banner-->
	    <div class="bottom_banner">
		    <?php if(eff_option('bb_img')) { ?>
		    <a href="<?php echo eff_option('bb_url'); ?>">
		    <img src="<?php echo eff_option('bb_img'); ?>" alt="">
		    </a>
		    <?php } elseif(eff_option('bb_code')) { 
			echo eff_option('bb_code');
		    } else { ?>
		    <a href="#"><img src="<?php echo EFF_IMG; ?>/banner728.png" alt=""></a>
		    <?php } ?>
	    </div>
	    <!--Bottom Banner-->
<?php } ?>
<?php function eff_blog() { ?>
    <?php if(eff_option('blog_style') == 'style2') { ?>
            <!--BLog style 2-->
            <div class="block">
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
                            <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                            <span class="post_meta"><span class="date"><?php the_time($dateformat);  ?></span><span class="author"><?php _e( 'Posted by: ' , 'framework' ); ?> <a rel="author" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>" title="<?php sprintf( esc_attr__( 'View all posts by %s', 'framework' ), get_the_author() ) ?>"><?php echo get_the_author() ?> </a></span><span class="category"><?php _e( 'Category: ' , 'framework' ); ?><?php printf('%1$s', get_the_category_list( ', ' ) ); ?></span><?php if($hpcomment == true) { ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a><?php } ?>
			    <?php
			    $rt_enable = get_post_meta($post->ID, 'eff_enable_review', true);
			    $rt_style = get_post_meta($post->ID, 'eff_review_style', true);
			    $percent_score = get_post_meta($post->ID, 'eff_rt_final_score', true);
			    $points_score = get_post_meta($post->ID, 'eff_rt_final_score_po', true);
			    $stars_score = get_post_meta($post->ID, 'eff_rt_final_score_stars', true);
			    if($rt_enable) {
				if($rt_style == 'stars') {
				    echo '<span class="rt_nb_rev rt_nb_star"><span class="rt_stars_post" title="'. $percent_score . '%">
					      <span class="rt_stars_post_rate" style="width:'. $percent_score . '%;"></span>
					 </span></span>';
				}
				if($rt_style == 'percent') {
				    echo '<span class="rt_nb_rev" title="'. $percent_score .'">
				    <span class="percent_post">'. $percent_score .'%</span>
				    </span>';
				}
		    
				if($rt_style == 'points') {
				    echo '<span class="rt_nb_rev" title="'. $points_score .'">
				    <span class="percent_post">'. $points_score .'</span>
				    </span>';
				}
		    
			    }
			    ?>
			    </span>
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
    <?php } elseif (eff_option('blog_style') == 'style1') { ?>
            <!--Blog Style-->
	    <div class="block">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
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
			    <span class="post_meta"><?php the_time($dateformat);  ?><?php if($hpcomment == true) { ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a><?php } ?>
			    <?php
			    $rt_enable = get_post_meta($post->ID, 'eff_enable_review', true);
			    $rt_style = get_post_meta($post->ID, 'eff_review_style', true);
			    $percent_score = get_post_meta($post->ID, 'eff_rt_final_score', true);
			    $points_score = get_post_meta($post->ID, 'eff_rt_final_score_po', true);
			    $stars_score = get_post_meta($post->ID, 'eff_rt_final_score_stars', true);
			    if($rt_enable) {
				if($rt_style == 'stars') {
				    echo '<span class="rt_nb_rev rt_nb_star"><span class="rt_stars_post" title="'. $percent_score . '%">
					      <span class="rt_stars_post_rate" style="width:'. $percent_score . '%;"></span>
					 </span></span>';
				}
				if($rt_style == 'percent') {
				    echo '<span class="rt_nb_rev" title="'. $percent_score .'">
				    <span class="percent_post">'. $percent_score .'%</span>
				    </span>';
				}
		    
				if($rt_style == 'points') {
				    echo '<span class="rt_nb_rev" title="'. $points_score .'">
				    <span class="percent_post">'. $points_score .'</span>
				    </span>';
				}
		    
			    }
			    ?>
			    </span>
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
		<?php endwhile; else: ?>
		<!--else here-->
		<?php endif; ?>
		<?php wp_reset_query(); ?>
	    </div>
	    <!--Blog Style-->
	    <?php eff_pagination(); ?>	    
    <?php } elseif (eff_option('blog_style') == 'masonry') { ?>
		    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		    <div class="brick">
			<article class="blog_masonry">
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
				<iframe width="100%" height="230" src="http://www.youtube.com/embed/<?php echo $mvideo_id; ?>" frameborder="0" allowfullscreen></iframe>
				 <?php } elseif ($video_type == 'vimo') { ?>
				<iframe src="http://player.vimeo.com/video/<?php echo $mvideo_id; ?>?title=0&amp;portrait=0&amp;badge=0" width="100%" height="230px" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
				<?php } elseif ($video_type == 'daily') { ?>
				<iframe frameborder="0" width="100%" height="230" src="http://www.dailymotion.com/embed/video/<?php echo $mvideo_id ?>?logo=0"></iframe>
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
				<img width="300px" height="210px" src="<?php echo $src; ?>">
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
				<?php } elseif ($type == 'featured') { ?>
				<?php $width = 300; $height = 205 ; ?>
				<div class="f_post_thumb">
				<?php eff_thumb('', $width , $height ); ?>
				</div>
				<?php } else { ?>
				    <a href="<?php the_permalink(); ?>">
				    <?php if (eff_post_image() != false) { ?>
				    <?php
				    $img = eff_post_image('larg');
				    $Fimg = aq_resize($img,300, 205, true);
				    ?>
				    <img src="<?php echo $Fimg; ?>" alt="<?php the_title(); ?>">
				    <?php } ?>
				    </a>
				<?php } ?>
			    <div class="mp_header">
			    <span class="post_type"><i class="<?php echo $postClass ; ?>"></i></span>
			    <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			    </div>
			    <span class="post_meta"><?php the_time($dateformat);  ?><?php if($hpcomment == true) { ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a><?php } ?>
			    <?php
			    $rt_enable = get_post_meta($post->ID, 'eff_enable_review', true);
			    $rt_style = get_post_meta($post->ID, 'eff_review_style', true);
			    $percent_score = get_post_meta($post->ID, 'eff_rt_final_score', true);
			    $points_score = get_post_meta($post->ID, 'eff_rt_final_score_po', true);
			    $stars_score = get_post_meta($post->ID, 'eff_rt_final_score_stars', true);
			    if($rt_enable) {
				if($rt_style == 'stars') {
				    echo '<span class="rt_nb_rev rt_nb_star"><span class="rt_stars_post" title="'. $percent_score . '%">
					      <span class="rt_stars_post_rate" style="width:'. $percent_score . '%;"></span>
					 </span></span>';
				}
				if($rt_style == 'percent') {
				    echo '<span class="rt_nb_rev" title="'. $percent_score .'">
				    <span class="percent_post">'. $percent_score .'%</span>
				    </span>';
				}
		    
				if($rt_style == 'points') {
				    echo '<span class="rt_nb_rev" title="'. $points_score .'">
				    <span class="percent_post">'. $points_score .'</span>
				    </span>';
				}
		    
			    }
			    ?>
			    </span>
			    
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
	
			</article>
		    </div>
		    <div class="clear"></div>
		    <?php endwhile; else: ?>
		    <!--else here-->
		    <?php endif; ?>
		    <?php wp_reset_query(); ?>
		    <script type="text/javascript">
			jQuery(document).ready(function($) {
			    // Masonry
			    $('.main_content_masonry').masonry({
			    // options
			    itemSelector : '.brick',
			    columnWidth : 320,
			    isAnimated: true,
			    animationOptions: {
			      duration: 750,
			      easing: 'linear',
			      queue: false
			    }
			  });
			});
		    </script>
    <?php } ?>  
<?php } ?>
<?php function eff_news_tabs($content) { ?>
	    <?php
		$tab_display = eff_option($content.'_display'); 
		$tab_tag = eff_option($content.'_tag'); 
		$tab_cat = eff_option($content.'_category');
		$tab_count = eff_option('tabs_posts');
	    ?>
	    
	    <div class="tabs_border">
	    <ul>
		<?php if($tab_display == 'cat') { ?>
		<?php query_posts(array('showposts' => $tab_count, 'cat' => $tab_cat )); ?>
		<?php } elseif($tab_display == 'tag') { ?>
		<?php query_posts(array('showposts' => $tab_count, 'tag' => $tab_tag )); ?>
		<?php } else { ?>
		<?php query_posts(array('showposts' => $tab_count )); ?>
		<?php } ?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<li>
		    <div class="post_thumb">
			<a href="<?php the_permalink(); ?>">
			    <?php
			    $img = eff_post_image('thumbnail');
			    $Fimg = aq_resize($img,60, 60, true);
			    ?>
			    <?php if (strpos(eff_post_image(), 'youtube')) { ?>
			    <img src="<?php echo eff_post_image(); ?>" width="60" height="60" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
			    
			    <?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
				<img src="<?php echo eff_post_image(); ?>" width="60" height="60" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
			    
			    <?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
				<img src="<?php echo eff_post_image(); ?>" width="60" height="60" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
			    
			    <?php } else { ?>
				<img src="<?php echo $Fimg; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
			    <?php } ?>
			</a>
		    </div>
		    <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		    <span class="post_meta"><?php the_time($dateformat);  ?><?php if($hpcomment == true) { ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a><?php } ?>
		    <?php
		    $rt_enable = get_post_meta($post->ID, 'eff_enable_review', true);
		    $rt_style = get_post_meta($post->ID, 'eff_review_style', true);
		    $percent_score = get_post_meta($post->ID, 'eff_rt_final_score', true);
		    $points_score = get_post_meta($post->ID, 'eff_rt_final_score_po', true);
		    $stars_score = get_post_meta($post->ID, 'eff_rt_final_score_stars', true);
		    if($rt_enable) {
			if($rt_style == 'stars') {
			    echo '<span class="rt_nb_rev rt_nb_star"><span class="rt_stars_post" title="'. $percent_score . '%">
				      <span class="rt_stars_post_rate" style="width:'. $percent_score . '%;"></span>
				 </span></span>';
			}
			if($rt_style == 'percent') {
			    echo '<span class="rt_nb_rev" title="'. $percent_score .'">
			    <span class="percent_post">'. $percent_score .'%</span>
			    </span>';
			}
	    
			if($rt_style == 'points') {
			    echo '<span class="rt_nb_rev" title="'. $points_score .'">
			    <span class="percent_post">'. $points_score .'</span>
			    </span>';
			}
	    
		    }
		    ?>
		    </span>
		</li>
		<?php endwhile; ?>
		<?php  else:  ?>
		    <!-- Else in here -->
		<?php  endif; ?>
		<?php wp_reset_query(); ?>
	    </ul>
	    </div>	    
<?php } ?>
<?php function eff_tabs() { ?>
    <?php
    $tab1 = "tab1";
    $tab2 = "tab2";
    $tab3 = "tab3";
    $tab4 = "tab4";
    $tab5 = "tab5";
    $tab6 = "tab6";
    ?>    
    <?php if(eff_option('tabs_style') == 'style2') { ?>   
	    <!--News Tabs Style 2-->
            <div class="block">
                <section class="section_box">
                    <div id="tabs_cat2" class="tab_cat2">
                        <ul class="tabs2_head">
			    <?php if(eff_option('tab1_title') != '') { ?>
                            <li><a href="#2tab1"><?php echo eff_option('tab1_title'); ?></a></li>
			    <?php } ?>
			    <?php if(eff_option('tab2_title') != '') { ?>
                            <li><a href="#2tab2"><?php echo eff_option('tab2_title'); ?></a></li>
			    <?php } ?>
			    <?php if(eff_option('tab3_title') != '') { ?>
                            <li><a href="#2tab3"><?php echo eff_option('tab3_title'); ?></a></li>
			    <?php } ?>
			    <?php if(eff_option('tab4_title') != '') { ?>
                            <li><a href="#2tab4"><?php echo eff_option('tab4_title'); ?></a></li>
			    <?php } ?>
			    <?php if(eff_option('tab5_title') != '') { ?>
                            <li><a href="#2tab5"><?php echo eff_option('tab5_title'); ?></a></li>
			    <?php } ?>
			    <?php if(eff_option('tab6_title') != '') { ?>
                            <li><a href="#2tab6"><?php echo eff_option('tab6_title'); ?></a></li>
			    <?php } ?>
                        </ul>
                        <div class="tabs2_wrap">
			    
			    <?php if(eff_option('tab1_title') != '') { ?>
                            <!--Tab1-->
                            <div id="2tab1" class="tabs_content">
                                <?php eff_news_tabs($tab1); ?>
                            </div>
                            <!--Tab1-->
                            <?php } ?>
			    
			    <?php if(eff_option('tab2_title') != '') { ?>
                            <!--Tab2-->
                            <div id="2tab2" class="tabs_content">
                                <?php eff_news_tabs($tab2); ?>
                            </div>
                            <!--Tab2-->
			    <?php } ?>
                            
			    <?php if(eff_option('tab3_title') != '') { ?>
                            <!--Tab3-->
                            <div id="2tab3" class="tabs_content">
                                <?php eff_news_tabs($tab3); ?>
                            </div>
                            <!--Tab3-->
			    <?php } ?>
                            
			    <?php if(eff_option('tab4_title') != '') { ?>
                            <!--Tab4-->
                            <div id="2tab4" class="tabs_content">
                                <?php eff_news_tabs($tab4); ?>
                            </div>
                            <!--Tab4-->
			    <?php } ?>
                            
			    <?php if(eff_option('tab5_title') != '') { ?>
                            <!--Tab5-->
                            <div id="2tab5" class="tabs_content">
                                <?php eff_news_tabs($tab5); ?>
                            </div>
                            <!--Tab5-->
			    <?php } ?>
			    
			    <?php if(eff_option('tab6_title') != '') { ?>
			    <!--Tab6-->
                            <div id="2tab6" class="tabs_content">
                                <?php eff_news_tabs($tab6); ?>
                            </div>
                            <!--Tab6-->
			    <?php } ?>
			    
                        </div>
                    </div>
                </section>
            </div>
            <!--News Tabs Style 2-->
    <?php } else { ?>    
	    <!--News Tabs-->
            <div class="block">
                <section class="section_box"  style="overflow: visible;">
                    <div id="tabs_category" class="tabs_cat">
                        <ul class="tabs_head">
                            <?php if(eff_option('tab1_title') != '') { ?>
                            <li><a href="#tab1"><?php echo eff_option('tab1_title'); ?></a></li>
			    <?php } ?>
			    <?php if(eff_option('tab2_title') != '') { ?>
                            <li><a href="#tab2"><?php echo eff_option('tab2_title'); ?></a></li>
			    <?php } ?>
			    <?php if(eff_option('tab3_title') != '') { ?>
                            <li><a href="#tab3"><?php echo eff_option('tab3_title'); ?></a></li>
			    <?php } ?>
			    <?php if(eff_option('tab4_title') != '') { ?>
                            <li><a href="#tab4"><?php echo eff_option('tab4_title'); ?></a></li>
			    <?php } ?>
			    <?php if(eff_option('tab5_title') != '') { ?>
                            <li><a href="#tab5"><?php echo eff_option('tab5_title'); ?></a></li>
			    <?php } ?>
			    <?php if(eff_option('tab6_title') != '') { ?>
                            <li><a href="#tab6"><?php echo eff_option('tab6_title'); ?></a></li>
			    <?php } ?>
                        </ul>
			
			
			<?php if(eff_option('tab1_title') != '') { ?>
                        <!--tab1-->
                        <div id="tab1" class="tabs_content">
                            <?php eff_news_tabs($tab1); ?>
                        </div>
                        <!--tab1-->
			<?php } ?>
			
			<?php if(eff_option('tab2_title') != '') { ?>
                        <!--tab2-->
                        <div id="tab2" class="tabs_content"> 
                            <?php eff_news_tabs($tab2); ?>
                        </div>
                        <!--tab2-->
			<?php } ?>
			
			<?php if(eff_option('tab3_title') != '') { ?>
                        <!--tab3-->
                        <div id="tab3" class="tabs_content"> 
                            <?php eff_news_tabs($tab3); ?>
                        </div>
                        <!--tab3-->
			<?php } ?>
			
			<?php if(eff_option('tab4_title') != '') { ?>
                        <!--tab4-->
                        <div id="tab4" class="tabs_content"> 
                            <?php eff_news_tabs($tab4); ?>
                        </div>
                        <!--tab4-->
			<?php } ?>
			
			<?php if(eff_option('tab5_title') != '') { ?>
                        <!--tab5-->
                        <div id="tab5" class="tabs_content"> 
                            <?php eff_news_tabs($tab5); ?>
                        </div>
                        <!--tab5-->
			<?php } ?>
			
			<?php if(eff_option('tab6_title') != '') { ?>
                        <!--tab6-->
                        <div id="tab6" class="tabs_content"> 
                            <?php eff_news_tabs($tab6); ?>
                        </div>
                        <!--tab6-->
			<?php } ?>
                    </div>
                </section>
            </div>
            <!--News Tabs-->  
    <?php } ?>
<?php } ?>
<?php function hp_banner($num) { ?>
        <div class="ads-banner" >
        <?php if(eff_option('hb'.$num.'_code') != '' ) { ?>
        <?php echo eff_option('hb'.$num.'_code'); ?>
        <?php } else { ?>
        <?php if(eff_option('hb'.$num.'_img') != '') { ?>
            <a href="<?php echo eff_option('hb'.$num.'_url'); ?>"><img src="<?php echo eff_option('hb'.$num.'_img'); ?>" alt="" /></a>
            <?php } else { ?>
            <a href="#"><img src="<?php echo EFF_IMG; ?>/ads-619.png" alt=""></a>
            <?php } ?>
        <?php } ?>
        </div>
<?php } ?>
<?php function eff_bottom_box($num){ ?>
	<?php
	    $bbcat = eff_option('bb'.$num.'_category');
	    $bbnum = eff_option('bb'.$num.'_number');
	    $bb_title = get_cat_name($bbcat);
	    $bb_link = get_category_link($bbcat);
	    ?>
            
	    <div class="block bottom_box cat_<?php echo $bbcat ; ?>">
		<div class="bblock_title">
		   <div class="title_bg"> <h2><a href="<?php echo $bb_link; ?>"><?php echo $bb_title; ?></a></h2></div>
		    <span></span>
		</div>
		
		<section class="section_box_2">
				<?php query_posts(array('showposts' => 1, 'cat' => $bbcat )); ?>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div class="post_thumb2">
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
				</div>
				<div class="stylebox2">
				    <div class="first_news">
					<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					<?php endwhile; else: ?>
					<!--else here-->
					<?php endif; ?>
					<?php wp_reset_query(); ?>
				    </div>
				    <ul>
					<?php query_posts(array('showposts' => $bbnum,'offset' => 1, 'cat' => $bbcat )); ?>
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<li>
					    <h2>&raquo; <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
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