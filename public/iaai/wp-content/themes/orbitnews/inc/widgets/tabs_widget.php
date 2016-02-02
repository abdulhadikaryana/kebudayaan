<?php


class OrbitN_Tabs_Widget extends WP_Widget {
	
	function OrbitN_Tabs_Widget()
	{
		$widget_ops = array('classname' => 'tabs-widget', 'description' => 'Popular posts, Recent Posts and Comments tabbed widget.');

		$control_ops = array('id_base' => 'orn_tabs-widget');

		$this->WP_Widget('orn_tabs-widget', '&#58;&#58; Tabs - Orbit News &#58;&#58;', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);
		global $post; 
		$posts = $instance['posts'];
		$recent_post_count = $instance['recent_post'];
		$comments = $instance['comments'];
		$show_popular_posts = isset($instance['show_popular_posts']) ? 'true' : 'false';
		$show_recent_post = isset($instance['show_recent_post']) ? 'true' : 'false';
		$show_comments = isset($instance['show_comments']) ? 'true' : 'false';
		
		echo $before_widget;
		
		if(!empty($title)) {
			echo $before_title.$title.$after_title;
		}		
		?>
		<!-- BEGIN WIDGET -->
	
			<ul class="tab-links no-bullet clearfix">
				<?php if($show_popular_posts == 'true'): ?><li><a href="#popular-tab"><?php _e('Popular', 'orbitnews'); ?></a></li><?php endif; ?>
				<?php if($show_recent_post == 'true'): ?><li><a href="#recent-tab"><?php _e('Recent', 'orbitnews'); ?></a></li><?php endif; ?>
				<?php if($show_comments == 'true'): ?><li><a href="#comments-tab"><?php _e('Comments', 'orbitnews'); ?></a></li><?php endif; ?>
			</ul>
			
			
				<?php if($show_popular_posts == 'true'): ?>
				<div id="popular-tab" class="tab_content">
                <ul>
					<?php
					$popular_posts = new WP_Query(
							 array(
							 	'posts_per_page' => $posts,
                    			'orderby' => 'comment_count',
                    			'order' => 'DESC',
								'ignore_sticky_posts' => 1 
							)
					);
					if($popular_posts->have_posts()): ?>
						<?php while($popular_posts->have_posts()): $popular_posts->the_post(); ?>
						<li>
                        	<a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'>
							<?php 
								if( has_post_thumbnail() ) { 
									the_post_thumbnail('widget-thumb');
								} else { 
									echo '<img src='. get_template_directory_uri() .'/images/fallback/widget-thumb.gif alt="No Image Avaliable">';
								}
							?>
                            </a>
							<h3><a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'><?php the_title(); ?></a></h3>
							<div class="post-date">
							<?php the_time('F j, Y'); ?> 
                            <?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>,
							<?php comments_popup_link('0 Comments', '1 Comment', '% Comments', '', 'Off'); ?>
   					        <?php endif; ?>
                            </div>
                        </li>
						
						<?php endwhile; ?>
                </ul>
					<?php endif; ?>
				</div>
				<?php 	endif; 
						wp_reset_postdata();
				?>
								
				<?php if($show_recent_post == 'true'): ?>
				<div id="recent-tab" class="tab_content">
                <ul>
					<?php
					$new_posts = new WP_Query(
               			 array(
                    			'posts_per_page' => $recent_post_count,
                    			'ignore_sticky_posts' => 1
                    	)
                	);
					if($new_posts->have_posts()): ?>
						<?php while($new_posts->have_posts()): $new_posts->the_post(); ?>
						<li>
							<a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'>
							<?php 
                            	if( has_post_thumbnail() ) { 
                                    the_post_thumbnail('widget-thumb');
                                } else { 
                                    echo '<img src='. get_template_directory_uri() .'/images/fallback/widget-thumb.gif alt="No Image Avaliable">';
                                }
                            ?>
                            </a>
							<h3><a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'><?php the_title(); ?></a></h3>
							<div class="post-date"><?php the_time('F j, Y'); ?></div>
                        </li>
						
						<?php endwhile; ?>
				</ul>
					<?php endif; ?>
				</div>
				<?php 	endif; 
                		wp_reset_postdata(); 
				?>
				<?php if($show_comments == 'true'): ?>
				<div id="comments-tab" class="tab_content">
                	<ul>
                    	
					<?php
					$number = $instance['comments'];
					global $wpdb;
					$recent_comments = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved, comment_type, comment_author_url, SUBSTRING(comment_content,1,110) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT $number";
					$the_comments = $wpdb->get_results($recent_comments);
					foreach ($the_comments as $comment) { ?>
                    		<li>
								<a href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>" title="<?php echo strip_tags($comment->comment_author); ?> on <?php echo $comment->post_title; ?>"><?php echo get_avatar($comment, '60'); ?></a>
								<h3><a href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>" title="<?php echo strip_tags($comment->comment_author); ?> on <?php echo $comment->post_title; ?>"><?php echo strip_tags($comment->comment_author); ?> <?php _e('says:', 'orbitnews'); ?></a></h3>
								<div class="author-comment">
									<?php 
									$trimcomment = strip_tags($comment->com_excerpt); 
									echo wp_trim_words( $trimcomment, $num_words = 12); 
									?>
                                </div>
                            </li>
					<?php } ?>
                    	
                    </ul>
				</div>
				<?php endif; ?>
				

		<!-- END WIDGET -->
		<?php
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['posts'] = $new_instance['posts'];
		$instance['recent_post'] = $new_instance['recent_post'];
		$instance['comments'] = $new_instance['comments'];
		$instance['show_popular_posts'] = $new_instance['show_popular_posts'];
		$instance['show_recent_post'] = $new_instance['show_recent_post'];
		$instance['show_comments'] = $new_instance['show_comments'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('posts' => 4, 'comments' => '4', 'recent_post' => 4, 'show_popular_posts' => 'on', 'show_comments' => 'on', 'show_recent_post' =>  'on');
		$instance = wp_parse_args((array) $instance, $defaults); ?>

		<p>
			<label for="<?php echo $this->get_field_id('posts'); ?>"><?php _e('Number of posts:', 'orbitnews'); ?></label>
			<input class="widefat" style="width: 30px;" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" value="<?php echo $instance['posts']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('recent_post'); ?>"><?php _e('Number of recent posts:', 'orbitnews'); ?></label>
			<input class="widefat" style="width: 30px;" id="<?php echo $this->get_field_id('recent_post'); ?>" name="<?php echo $this->get_field_name('recent_post'); ?>" value="<?php echo $instance['recent_post']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('comments'); ?>"><?php _e('Number of comments:', 'orbitnews'); ?></label>
			<input class="widefat" style="width: 30px;" id="<?php echo $this->get_field_id('comments'); ?>" name="<?php echo $this->get_field_name('comments'); ?>" value="<?php echo $instance['comments']; ?>" />
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_popular_posts'], 'on'); ?> id="<?php echo $this->get_field_id('show_popular_posts'); ?>" name="<?php echo $this->get_field_name('show_popular_posts'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_popular_posts'); ?>"><?php _e('Show popular posts', 'orbitnews'); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_recent_post'], 'on'); ?> id="<?php echo $this->get_field_id('show_recent_post'); ?>" name="<?php echo $this->get_field_name('show_recent_post'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_recent_post'); ?>"><?php _e('Show Recent Posts', 'orbitnews'); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_comments'], 'on'); ?> id="<?php echo $this->get_field_id('show_comments'); ?>" name="<?php echo $this->get_field_name('show_comments'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_comments'); ?>"><?php _e('Show comments', 'orbitnews'); ?></label>
		</p>

	<?php }
}
