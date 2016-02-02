<?php

class OrbitN_Homepage_Carousel_Widget extends WP_Widget {
	
	function OrbitN_Homepage_Carousel_Widget()
	{
		$widget_ops = array('classname' => 'orn_homepage_carousel', 'description' => 'Homepage post carousel.');

		$control_ops = array('id_base' => 'orn_homepage_carousel-widget');

		$this->WP_Widget('orn_homepage_carousel-widget', '&#58;&#58; Home Carousel Posts - Orbit News &#58;&#58;', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{	
		extract($args);
		global $post;
		$title = $instance['title'];
		$post_type = $instance['post_type'];
		$categories = $instance['categories'];
		$posts = $instance['posts'];
		$gallery = $instance['gallery'];
		$orderby    = $instance['orderby'];
		$order      = $instance['order'];
		
		echo $before_widget;
		?>
		<?php
		$recent_posts = new WP_Query(array(
			'posts_per_page' => $posts,
			'cat' => $categories,
			'ignore_sticky_posts' => 1 ,
			'orderby' => $orderby,
			'order'	=> $order
		));
		if($recent_posts->found_posts >= 3):
		?>
		<div class="clearfix <?php if( $gallery ) { echo 'mb25'; } else { echo 'mb10'; } ?> oh">
			<h4 class="cat-title cat-icon"><a href="<?php echo get_category_link($categories); ?>"><?php echo $title; ?></a></h4>
			
			<div class="carousel-container">
				<div class="carousel-navigation">
					<a class="carousel-prev"></a>
					<a class="carousel-next"></a>
                </div>
			
				<div class="carousel-item-holder row" data-index="0">

						<?php
						$post_types = get_post_types();
						unset($post_types['page'], $post_types['attachment'], $post_types['revision'], $post_types['nav_menu_item']);
						
						if($post_type == 'all') {
							$post_type_array = $post_types;
						} else {
							$post_type_array = $post_type;
						}
						
						if($categories != 'all') {
							$categories_array = array($categories);
						}
						?>
						
						<?php while($recent_posts->have_posts()): $recent_posts->the_post(); ?>
					<div class="four column carousel-item">
                    	<div class="carousel-images">
							<?php 
							$post_format = get_post_format();
                            if ( has_post_format('video') || has_post_format('gallery') || has_post_format('audio') ) {
                                echo '<div class="carousel-icons">';
                                echo '<a href="'. esc_url( get_post_format_link( $post_format ) ). '">';
                                echo '<span title="'.( get_post_format_string( $post_format ) ).'" class="has-tip format-icon '. $post_format .'-ico"></span>';
                                echo '</a>';
                                echo '</div>';
                            }
                            ?>
                            <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>">
								<?php 
                                // Post Thumbnail
                                if( has_post_thumbnail() ) { 	
                                    the_post_thumbnail('carousel-thumb');
                                } else { 	
                                    echo '<img src='. get_template_directory_uri() .'/images/fallback/carousel-thumb.gif alt="No Image Avaliable">';
                                } 
                                ?>
                            </a>
                        </div>		
						<?php if( !$gallery ) { ?>
                        <div class="post-container">
                        	<h2 class="post-title"><a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'><?php the_title(); ?></a></h2>
                            <div class="post-content"><p><?php custom_excerpt('25') ?></p></div>
                        </div>
                        <div class="post-meta">
	                        <?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
                        	<span class="comments"><a href="#"><?php comments_popup_link( '0', '1', '%', '', ''); ?></a></span>
                            <?php endif; ?>
    						<span class="pdate"><a href="<?php the_permalink(); ?>"><?php the_time('F j, Y'); ?></a></span>

                        </div>
						<?php } ?>
                    </div>
						
						<?php endwhile; ?>

				</div>
			</div>
		</div>
		<?php endif; ?>
		<?php
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['title'] = $new_instance['title'];
		$instance['post_type'] = $new_instance['post_type'];
		$instance['categories'] = $new_instance['categories'];
		$instance['posts'] = $new_instance['posts'];
		$instance['gallery'] = $new_instance['gallery'];
		$instance['orderby']    = $new_instance['orderby'];
		$instance['order']      = $new_instance['order'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Carousel', 'post_type' => 'all', 'categories' => 'all', 'posts' => 6,  'gallery' => 0, 'orderby' => 'date', 'order' => 'DESC'  );
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('categories'); ?>">Filter by Category:</label> 
			<select id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" class="widefat categories">
				<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>all categories</option>
				<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('orderby'); ?>">Order By:</label> 
			<select id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>" class="widefat">
				<option value='date' <?php if ('date' == $instance['orderby']) echo 'selected="selected"'; ?>>Date</option>
				<?php $ordersby = array( 'Name' => 'name', 'Popularity' => 'comment_count', 'Random' => 'rand', 'Title' => 'title' ); ?>
				<?php foreach( $ordersby as $orderby_label => $orderby_value ) { ?>
				<option value='<?php echo $orderby_value; ?>' <?php if ($orderby_value == $instance['orderby']) echo 'selected="selected"'; ?>><?php echo $orderby_label; ?></option>
				<?php } ?>
			</select>
		</p>	
		<p>
			<label for="<?php echo $this->get_field_id('order'); ?>">Order:</label> 
			<select id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>" class="widefat">
				<option value='DESC' <?php if ('DESC' == $instance['order']) echo 'selected="selected"'; ?>>Descending</option>
				<option value='ASC'  <?php if ('ASC'  == $instance['order']) echo 'selected="selected"'; ?>>Ascending</option>
			</select>
		</p>	
		
		<p>
			<label for="<?php echo $this->get_field_id('posts'); ?>">Number of posts:</label>
			<input class="widefat" style="width: 30px;" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" value="<?php echo $instance['posts']; ?>" />
		</p>
        <p>
        	<input id="<?php echo $this->get_field_id('gallery'); ?>" class="checkbox" name="<?php echo $this->get_field_name('gallery'); ?>" type="checkbox" value="1" <?php checked( $instance['gallery'] , 1 ); ?> />
			<label for="<?php echo $this->get_field_id('gallery'); ?>">Show As Gallery</label>
            <br />
            <small>If checked only the image will show on carousel without title, meta and excerpt.</small>
		</p>
	<?php }
}
?>