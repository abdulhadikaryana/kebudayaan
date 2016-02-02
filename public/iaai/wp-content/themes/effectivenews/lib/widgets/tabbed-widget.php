<?php
global $post;
add_action( 'widgets_init', 'eff_tab_widgets' );

function eff_tab_widgets() {
	register_widget( 'eff_tab_widgets' );
}

class eff_tab_widgets extends WP_Widget {


	
	function eff_tab_widgets() {
	
		/* Widget settings */
		$widget_ops = array( 'classname' => 'eff_tab_widget', 'description' => __('A tabbed widget that display popular posts, recent posts, comments and tags.', 'framework') );

		/* Widget control settings */
		//$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'eff_tab_widget' );

		/* Create the widget */
		$this->WP_Widget( 'eff_tab_widget', __('Widget - Tabbed', 'framework'), $widget_ops );
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		global $wpdb;
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$tab1 = $instance['tab1'];
		$tab2 = $instance['tab2'];
		$tab3 = $instance['tab3'];
		$tab4 = $instance['tab4'];
	

		/* Before widget (defined by themes). */
	

		/* Display the widget title if one was input (before and after defined by themes). */
		

		//Randomize tab order in a new array
		$tab = array();
		
		?>
<div class="widget">
        <section class="section_widget">
		<div id="tabs_widget">
			
				<ul class="tabs_widget_head">
				    <li><a href="#tab_popular"><?php _e('Popular' , 'framework') ?></a></li>
				    <li><a href="#tab_recent"><?php _e('Recent' , 'framework') ?></a></li>
				    <li><a href="#tab_comments"><?php _e('Comments' , 'framework') ?></a></li>
				</ul>
				
				<div id="tab_popular" class="tabs_widget_content">
					<div>
					    <ul>
						<?php query_posts(array(  "ignore_sticky_posts" => 1, 'showposts' => 4, "orderby" => "comment_count")); ?>
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<li>
						    <div>
							<div class="post_thumb2">
							<a href="<?php the_permalink(); ?>">
							<?php 
							    $thumb = eff_post_image(); 
							    $ntImage = aq_resize( $thumb, 80, 68, true );
							?>
							    <?php if (strpos(eff_post_image(), 'youtube')) { ?>
								<img src="<?php echo eff_post_image(); ?>" width="85" height="68" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
								
							    <?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
								<img src="<?php echo eff_post_image(); ?>" width="85" height="68" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
							    
							    <?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
								<img src="<?php echo eff_post_image(); ?>" width="85" height="68" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
							    
							    <?php } else { ?>
								<img src="<?php echo $ntImage; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
							    <?php } ?>
							</a>
							</div>
						    </div>
						    <h2><a href="<?php the_permalink(); ?>"><?php short_title(50); ?></a></h2>
						    <span class="post_meta"><?php the_time('F d, Y');  ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a></span></span>
						</li>
						<?php endwhile; ?>
						<?php  else:  ?>
						<!-- Else in here -->
						<?php  endif; ?>
						<?php wp_reset_query(); ?>
					    </ul>
					</div>
				</div>
				
				<div id="tab_recent" class="tabs_widget_content">
					<div>
					    <ul>
						<?php query_posts(array(  "ignore_sticky_posts" => 1, 'showposts' => 4 )); ?>
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<li>
						    <div>
							<div class="post_thumb2">
							<a href="<?php the_permalink(); ?>">
							<?php 
							    $thumb = eff_post_image(); 
							    $ntImage = aq_resize( $thumb, 80, 72, true );
							?>
							    <?php if (strpos(eff_post_image(), 'youtube')) { ?>
								<img src="<?php echo eff_post_image(); ?>" width="80" height="68" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
								
							    <?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
								<img src="<?php echo eff_post_image(); ?>" width="80" height="68" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
							    
							    <?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
								<img src="<?php echo eff_post_image(); ?>" width="80" height="68" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
							    
							    <?php } else { ?>
								<img src="<?php echo $ntImage; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
							    <?php } ?>
							</a>
							</div>
						    </div>
						    <h2><a href="<?php the_permalink(); ?>"><?php short_title(50); ?></a></h2>
						    <span class="post_meta"><?php the_time('F d, Y');  ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a></span></span>
						</li>
						<?php endwhile; ?>
						<?php  else:  ?>
						<!-- Else in here -->
						<?php  endif; ?>
						<?php wp_reset_query(); ?>
					    </ul>
					</div>
				</div>
				
				<div id="tab_comments" class="tabs_widget_content">
					<div>
					    <ul>
						<?php
						global $wpdb;
		
						$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved, comment_type, comment_author_url, SUBSTRING(comment_content,1,70) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT 4";
						$comments = $wpdb->get_results($sql);
						foreach ($comments as $comment) :
						?>
						<li>
						    <div>
							<a href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>" title="<?php echo strip_tags($comment->comment_author); ?> <?php _e('on ', 'framework'); ?><?php echo $comment->post_title; ?>">
							    <?php echo get_avatar( $comment, '72',$default=eff_option('custom_gravatar') ); ?>
							</a>
						    </div>
						    <h2><a href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>" title="<?php echo strip_tags($comment->comment_author); ?> <?php _e('on ', 'framework'); ?><?php echo $comment->post_title; ?>"><?php echo strip_tags($comment->comment_author); ?>:
						    <?php 
							$excerpt = $comment->com_excerpt;
							echo wp_html_excerpt($excerpt,75);
							?> ... 
						    </a></h2>
						</li>
						<?php endforeach; ?>
			
						<?php wp_reset_query(); ?>
					    </ul>
					</div>
				</div>
		
		</div>
	</section>
</div>
        
		<?php

		/* After widget (defined by themes). */
		
	}

	/* ---------------------------- */
	/* ------- Update Widget -------- */
	/* ---------------------------- */
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );

		/* No need to strip tags */
		$instance['tab1'] = $new_instance['tab1'];
		$instance['tab2'] = $new_instance['tab2'];
		$instance['tab3'] = $new_instance['tab3'];
		$instance['tab4'] = $new_instance['tab4'];
		
		return $instance;
	}
	
	/* ---------------------------- */
	/* ------- Widget Settings ------- */
	/* ---------------------------- */
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	
	function form( $instance ) {
	
		/* Set up some default widget settings. */
		$defaults = array(
		'title' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<?php _e('No Setting' , 'framework'); ?>
		</p>

		
	
	<?php
	}
}
?>