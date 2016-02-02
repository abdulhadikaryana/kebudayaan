<?php 

add_action('widgets_init','eff_widget_posts_cat');

function eff_widget_posts_cat() {
	register_widget('widget_posts_cat');
	
	}

class widget_posts_cat extends WP_Widget {
	function widget_posts_cat() {
			
		$widget_ops = array('classname' => 'category-posts','description' => __('Widget display Posts list From categories with thumbinals order by : Popular, Random, Recent','framework'));
		$this->WP_Widget('postscat',__('Widget - Category Posts List','framework'),$widget_ops);

		}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$orderby = $instance['orderby'];
		$count = $instance['count'];
                $catsid = $instance['cats_id'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
			global $post;
?>
    <div class="widget-inner">
<?php if($orderby == 'Popular') { ?>
		<ul class="post_list icon-">
		<?php query_posts(array(  "ignore_sticky_posts" => 1, 'showposts' => $count, "orderby" => "comment_count", 'cat' => $catsid)); ?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<li>
			<div class="post_thumb">
			<?php if(eff_post_image() == false) {} else { ?>
			<a href="<?php the_permalink(); ?>">
				    <?php 
					$thumb = eff_post_image(); 
					$ntImage = aq_resize( $thumb, 50, 50, true );
				    ?>
				<?php if (strpos(eff_post_image(), 'youtube')) { ?>
				    <img src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
				    
				<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
				    <img src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
				
				<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
				    <img src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
				
				<?php } else { ?>
				    <img src="<?php echo $ntImage; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
				<?php } ?>
			    <?php } ?>
			</a>
			</div>
			    <h2><a href="<?php the_permalink(); ?>"><?php short_title(35); ?></a></h2>
			    <span class="post_meta"><?php the_time('F d, Y');  ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a></span>
		</li>

		<?php endwhile; ?>
		<?php  else:  ?>
		<!-- Else in here -->
		<?php  endif; ?>
		<?php wp_reset_query(); ?>
		</ul>
<?php } elseif($orderby == 'Random') { ?>
		<ul class="post_list">
		<?php query_posts(array(  "ignore_sticky_posts" => 1, 'showposts' => $count, "orderby" => "rand", 'cat' => $catsid)); ?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<li>
			<div class="post_thumb">
			<?php if(eff_post_image() == false) {} else { ?>
			<a href="<?php the_permalink(); ?>">
				    <?php 
					$thumb = eff_post_image(); 
					$ntImage = aq_resize( $thumb, 50, 50, true );
				    ?>
				<?php if (strpos(eff_post_image(), 'youtube')) { ?>
				    <img src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
				    
				<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
				    <img src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
				
				<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
				    <img src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
				
				<?php } else { ?>
				    <img src="<?php echo $ntImage; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
				<?php } ?>
			    <?php } ?>
			</a>
			</div>
			    <h2><a href="<?php the_permalink(); ?>"><?php short_title(35); ?></a></h2>
			    <span class="post_meta"><?php the_time('F d, Y');  ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a></span>
		</li>

		<?php endwhile; ?>
		<?php  else:  ?>
		<!-- Else in here -->
		<?php  endif; ?>
		<?php wp_reset_query(); ?>
		</ul>
<?php } elseif($orderby == 'Recent') { ?>
		<ul class="post_list">
		<?php query_posts(array(  "ignore_sticky_posts" => 1, 'showposts' => $count, 'cat' => $catsid )); ?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<li>
			<div class="post_thumb">
			<?php if(eff_post_image() == false) {} else { ?>
			<a href="<?php the_permalink(); ?>">
				    <?php 
					$thumb = eff_post_image(); 
					$ntImage = aq_resize( $thumb, 50, 50, true );
				    ?>
				<?php if (strpos(eff_post_image(), 'youtube')) { ?>
				    <img src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
				    
				<?php } elseif (strpos(eff_post_image(), 'vimeo')) { ?>
				    <img src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
				
				<?php } elseif (strpos(eff_post_image(), 'dailymotion')) {?>
				    <img src="<?php echo eff_post_image(); ?>" width="50" height="50" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
				
				<?php } else { ?>
				    <img src="<?php echo $ntImage; ?>"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
				<?php } ?>
			    <?php } ?>
			</a>
			</div>
			    <h2><a href="<?php the_permalink(); ?>"><?php short_title(35); ?></a></h2>
			    <span class="post_meta"><?php the_time('F d, Y');  ?><a href="<?php the_permalink(); ?>" class="comments"><?php comments_number('(0) Comments','(1) Comment','(%) Comments'); ?></a></span>
		</li>

		<?php endwhile; ?>
		<?php  else:  ?>
		<!-- Else in here -->
		<?php  endif; ?>
		<?php wp_reset_query(); ?>
		</ul>
<?php } ?>
    </div>

<?php 
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
                $instance['cats_id'] = implode(',' , $new_instance['cats_id']  );
		$instance['count'] = $new_instance['count'];
		$instance['orderby'] = $new_instance['orderby'];

		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Most Popular','framework'), 
			'count' => 3,
 			);
		$instance = wp_parse_args( (array) $instance, $defaults ); 
                
                $categories_obj = get_categories();
		$categories = array();

		foreach ($categories_obj as $eff_cat) {
			$categories[$eff_cat->cat_ID] = $eff_cat->cat_name;
		}
                ?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:','framework'); ?></label>
		<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat" />
		</p>
                
                <p>
                <?php $cats_id = explode ( ',' , $instance['cats_id'] ) ; ?>
                <label for="<?php echo $this->get_field_id( 'cats_id' ); ?>"><?php _e('Category :','framework'); ?></label>
                <select multiple="multiple" id="<?php echo $this->get_field_id( 'cats_id' ); ?>[]" name="<?php echo $this->get_field_name( 'cats_id' ); ?>[]">
                        <?php foreach ($categories as $key => $option) { ?>
                        <option value="<?php echo $key ?>" <?php if ( in_array( $key , $cats_id ) ) { echo ' selected="selected"' ; } ?>><?php echo $option; ?></option>
                        <?php } ?>
                </select>
		</p>
                
		<p>
		<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e('orderby', 'framework') ?></label>
		<select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>" class="widefat">
		<option <?php if ( 'Popular' == $instance['orderby'] ) echo 'selected="selected"'; ?>>Popular</option>
		<option <?php if ( 'Random' == $instance['orderby'] ) echo 'selected="selected"'; ?>>Random</option>
		<option <?php if ( 'Recent' == $instance['orderby'] ) echo 'selected="selected"'; ?>>Recent</option>
		</select>
		</p>


		<p>
		<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Number Of Posts:','framework'); ?></label>
		<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" class="widefat" />
		</p>

   <?php 
}
	} //end class