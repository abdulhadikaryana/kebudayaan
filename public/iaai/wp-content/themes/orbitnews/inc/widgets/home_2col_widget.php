<?php

class OrbitN_Homepage_2col_Widget extends WP_Widget {
	
	function OrbitN_Homepage_2col_Widget()
	{
		$widget_ops = array('classname' => 'orn_homepage_2col', 'description' => 'Homepage 2-column posts widget.');

		$control_ops = array('id_base' => 'orn_homepage_2col-widget');

		$this->WP_Widget('orn_homepage_2col-widget', '&#58;&#58; Home Two-Column Posts - Orbit News &#58;&#58;', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);
		
		global $post;
		$title = $instance['title'];
		$post_type = 'all';
		$categories = $instance['categories'];
		$posts = $instance['posts'];

		$title_2 = $instance['title_2'];
		$post_type_2 = 'all';
		$categories_2 = $instance['categories_2'];
		$posts_2 = $instance['posts_2'];
		
		echo $before_widget;
		?>
		
		<?php
		$post_types = get_post_types();
		unset($post_types['page'], $post_types['attachment'], $post_types['revision'], $post_types['nav_menu_item']);
		
		if($post_type == 'all') {
			$post_type_array = $post_types;
		} else {
			$post_type_array = $post_type;
		}
		?>
		<section class="row">
        	<!-- Start First Column Posts -->
            <article class="six column">
                <h4 class="cat-title cat-icon"><a href="<?php echo get_category_link($categories); ?>"><?php echo $title; ?></a></h4>
                
                <?php
                
                $recent_posts = new WP_Query(array(
                    'posts_per_page' => $posts,
                    'cat' => $categories,
                    'ignore_sticky_posts' => 1 
                ));
                $counter = 1; while($recent_posts->have_posts()): $recent_posts->the_post(); 
                if($counter == 1): 
                ?>
                <div class="post-image">
                    <?php 
                    // Post format icon if avaliable
                    $post_format = get_post_format();
                    if ( has_post_format('video') || has_post_format('gallery') || has_post_format('audio') ) {
                        echo '<div class="post-icons">';
                        echo '<a href="'. esc_url( get_post_format_link( $post_format ) ). '">';
                        echo '<span title="'.( get_post_format_string( $post_format ) ).'" class="has-tip format-icon '. $post_format .'-ico"></span>';
                        echo '</a>';
                        echo '</div>';
                    }
                    ?>
                    <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>">
                        <?php
                        if( has_post_thumbnail() ) { 
                            // Post Thumbanail 
                            the_post_thumbnail('post-thumb'); 
                        } else { 
                            // Fallback image if no post thumbnail
                            echo '<img src='. get_template_directory_uri() .'/images/fallback/post-thumb.gif alt="No Image Avaliable">';	
                        }
                        ?>
                    </a>
                </div>
                <div class="post-container">
                    <h2 class="post-title"><a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'><?php the_title(); ?></a></h2>
                    <div class="post-content"><p><?php custom_excerpt('25') ?></p></div>
                </div>
                <div class="post-meta">
                    <?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
                    <span class="comments"><?php comments_popup_link( '0', '1', '%', '', ''); ?></span>
                    <?php endif; ?>
                    <span class="author"><?php the_author_posts_link(); ?></span>
                    <span class="pdate"><a href="<?php the_permalink(); ?>"><?php the_time('F j, Y'); ?></a></span>
    
                </div>
                <div class="other-posts">    
                	<ul class="no-bullet">
                <?php else: ?>
                        <li>
                            <?php if( has_post_thumbnail() ) { ?>
                                <a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'>
                                    <?php the_post_thumbnail('home-small-thumb'); ?>
                                </a>
                            <?php } else { ?>
                                <a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'>
                                    <img src='<?php echo get_template_directory_uri() ?>/images/fallback/home-small-thumb.gif' alt='No Image Avaliable' width='50' height='50' />
                                </a>
                            <?php } ?>
                            <h3 class="post-title"><a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'><?php the_title(); ?></a></h3>
                            <span class="pdate"><a href="<?php the_permalink(); ?>"><?php the_time('F j, Y'); ?></a></span>
                        </li>
                <?php endif; ?>
                <?php $counter++; endwhile; ?>
					</ul>
                </div>
            </article>
            <!-- End of First Column Posts -->
            <?php
            $post_types = get_post_types();
            unset($post_types['page'], $post_types['attachment'], $post_types['revision'], $post_types['nav_menu_item']);
            
            if($post_type_2 == 'all') {
                $post_type_2_array = $post_types;
            } else {
                $post_type_2_array = $post_type;
            }
            ?>
            <!-- Start Second Column Posts -->
            <article class="six column">
                <h4 class="cat-title cat-icon"><a href="<?php echo get_category_link($categories_2); ?>"><?php echo $title_2; ?></a></h4>
    
                <?php
                $recent_posts = new WP_Query(array(
                    'posts_per_page' => $posts_2,
                    'cat' => $categories_2,
                    'ignore_sticky_posts' => 1 
                ));
                $counter = 1; while($recent_posts->have_posts()): $recent_posts->the_post();
                if($counter == 1):
                ?>
                <div class="post-image">
                    <?php 
                    // Post format icon if avaliable
					$post_format = get_post_format();
                    if ( has_post_format('video') || has_post_format('gallery') || has_post_format('audio') ) {
                        echo '<div class="post-icons">';
                        echo '<a href="'. esc_url( get_post_format_link( $post_format ) ). '">';
                        echo '<span title="'.( get_post_format_string( $post_format ) ).'" class="has-tip format-icon '. $post_format .'-ico"></span>';
                        echo '</a>';
                        echo '</div>';
                    }
                    ?>
                    <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>">
                        <?php
                        if( has_post_thumbnail() ) { 
                            // Post Thumbanail 
                            the_post_thumbnail('post-thumb'); 
                        } else { 
                            // Fallback image if no post thumbnail
                            echo '<img src='. get_template_directory_uri() .'/images/fallback/post-thumb.gif alt="No Image Avaliable">';	
                        }
                        ?>
                    </a>
                </div>
                <div class="post-container">
                    <h2 class="post-title"><a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'><?php the_title(); ?></a></h2>
                    <div class="post-content"><p><?php custom_excerpt('25') ?></p></div>
                </div>
                <div class="post-meta">
                    <?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
                    <span class="comments"><?php comments_popup_link( '0', '1', '%', '', ''); ?></span>
                    <?php endif; ?>
                    <span class="author"><?php the_author_posts_link(); ?></span>
                    <span class="pdate"><a href="<?php the_permalink(); ?>"><?php the_time('F j, Y'); ?></a></span>
    
                </div>
                <div class="other-posts">    
                    <ul class="no-bullet">
                <?php else: ?>
                        <li>
                            <?php if( has_post_thumbnail() ) { ?>
                                <a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'>
                                    <?php the_post_thumbnail('home-small-thumb'); ?>
                                </a>
                            <?php } else { ?>
                                <a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'>
                                    <img src='<?php echo get_template_directory_uri() ?>/images/fallback/home-small-thumb.gif' alt='No Image Avaliable' />
                                </a>
                            <?php } ?>
                            <h3 class="post-title"><a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'><?php the_title(); ?></a></h3>
                            <span class="pdate"><a href="<?php the_permalink(); ?>"><?php the_time('F j, Y'); ?></a></span>
                        </li>
                <?php endif; ?>
                <?php $counter++; endwhile; ?>
                    </ul>
                </div>
            </article>
            <!-- End of Second Column Posts -->
        </section>
		<?php
		
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
				
		$instance['title'] = $new_instance['title'];
		$instance['post_type'] = 'all';
		$instance['categories'] = $new_instance['categories'];
		$instance['posts'] = $new_instance['posts'];
		$instance['show_images'] = true;
		
		$instance['title_2'] = $new_instance['title_2'];
		$instance['post_type_2'] = 'all';
		$instance['categories_2'] = $new_instance['categories_2'];
		$instance['posts_2'] = $new_instance['posts_2'];
		$instance['show_images_2'] = true;
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Recent Posts', 'post_type' => 'all', 'categories' => 'all', 'posts' => 4, 'title_2' => 'Recent Posts', 'post_type_2' => 'all', 'categories_2' => 'all', 'posts_2' => 4);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<small>Tip: When showing posts from certain Category change title to Category Name</small>	
		<h3>First Column</h3>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('categories'); ?>">Filter by Category:</label> 
			<select id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" class="widefat categories" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>all categories</option>
				<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('posts'); ?>">Number of posts:</label>
			<input class="widefat" style="width: 30px;" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" value="<?php echo $instance['posts']; ?>" />
		</p>
		
        <br />
        
        <h3>Second Column</h3>
		
		<p>
			<label for="<?php echo $this->get_field_id('title_2'); ?>">Title:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title_2'); ?>" name="<?php echo $this->get_field_name('title_2'); ?>" value="<?php echo $instance['title_2']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('categories_2'); ?>">Filter by Category:</label> 
			<select id="<?php echo $this->get_field_id('categories_2'); ?>" name="<?php echo $this->get_field_name('categories_2'); ?>" class="widefat categories" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['categories_2']) echo 'selected="selected"'; ?>>all categories</option>
				<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['categories_2']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('posts_2'); ?>">Number of posts:</label>
			<input class="widefat" style="width: 30px;" id="<?php echo $this->get_field_id('posts_2'); ?>" name="<?php echo $this->get_field_name('posts_2'); ?>" value="<?php echo $instance['posts_2']; ?>" />
		</p>
	<?php }
}
