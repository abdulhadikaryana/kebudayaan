<?php 

add_action('widgets_init','eff_widget_review');

function eff_widget_review() {
	register_widget('eff_widget_review');
	
	}

class eff_widget_review extends WP_Widget {
	function eff_widget_review() {
			
		$widget_ops = array('classname' => 'widget_review','description' => __('Widget display Review posts','framework'));
		$this->WP_Widget('eff_widget_review',__('Widget - Review posts','framework'),$widget_ops);
		}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
                $items_num = $instance['items_num'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
                        
?>
<?php
                /** 
                 * Latest Reviews
                **/
                global $post;
                $eff_latest_reviews = new WP_Query(
                        array(
                                'post_type' => 'post',
                                'meta_key' => 'eff_enable_review',
                                'meta_value' => 1,
                                'posts_per_page' => $items_num,
                        )
                );
                ?>
	<ul>
		<?php while ( $eff_latest_reviews->have_posts() ) : $eff_latest_reviews->the_post(); ?>
                
                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
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
                </li>
                <?php endwhile; ?>
                <?php wp_reset_query(); ?>
        </ul>

<?php 
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
                $instance['items_num'] = strip_tags( $new_instance['items_num'] );

		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Latest Reviews','framework'),
                            'items_num' => '5',
 			);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
                
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:','framework'); ?></label>
		<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat" />
		</p>
                
                <p>
        	<label for="<?php echo $this->get_field_id( 'items_num' ); ?>"><?php _e('Maximum posts to show:', 'framework'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'items_num' ); ?>" name="<?php echo $this->get_field_name( 'items_num' ); ?>" value="<?php echo $instance['items_num']; ?>" size="1" />
		</p>

   <?php 
}
	} //end class