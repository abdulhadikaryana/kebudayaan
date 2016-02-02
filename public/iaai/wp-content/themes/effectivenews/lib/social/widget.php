<?php

// Props @nickhamze 

function sh_sb_widget_register_widgets() {
    register_widget( 'sh_sb_widget' );
}

class sh_sb_widget extends WP_Widget {

    function sh_sb_widget() {
        $widget_ops = array( 
			'classname' => 'sh_sb_widget_class', 
			'description' => 'Display your Custom Social Icons links.' 
			); 
        $this->WP_Widget( 'sh_sb_widget', 'Social icons', $widget_ops );
    }
 
    function form($instance) {
        $defaults = array( 'title' => '', 'disable_styles' => false ); 
        $instance = wp_parse_args( (array) $instance, $defaults );
        $title = $instance['title'];
        
        ?>
        <p><strong><?php _e( 'Set up Social Bartender', 'theme' ); ?> <a href="/wp-admin/themes.php?page=sh_sb_settings_page.php"><?php _e( 'here.', 'theme' ); ?></a></strong></p>
        
        <p>
        	<?php _e( 'Title (optional):', 'theme' ); ?>
        	<input class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>"  type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        
        
        <?php
    }
 
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
 		$instance['disable_styles'] = $new_instance['disable_styles'];
 		
        return $new_instance;
    }
 
    function widget($args, $instance) {
        extract($args);
 		
        echo $before_widget; 

	        $title = apply_filters( 'widget_title', $instance['title'] );
	 		//$disable_styles = $instance['disable_styles'];
	 		
	        if ( !empty( $title ) ) { 
	        	echo $before_title . $title . $after_title; 
	        };
	        
	         ?>
	        
		        <style>
				.widget-social-icons ul {
				    margin: 0 auto;
				    overflow: hidden;
				}
			        .widget-social-icons ul li{
					display: block;
					float: left;
					padding: 6px 2.9px !important;
					border-bottom: 0 !important;
					text-align: center;
					margin-right: 1px;
					}
				.widget-social-icons ul li a, .widget-social-icons ul li a img{
				    display: block;
				}
		        </style>
	        
	        <?php ?>
	        
		<div class="widget-social-icons">
		<ul><?php social_bartender(); ?></ul>
	        </div>
        <?php
	if ( !empty( $title ) ) {
	    echo $after_widget;
	} else {
	?>
	</div>
	<style>
	    .sidebar .widget-social-icons{
		margin-bottom: 30px;
		overflow: hidden;
		clear: both;
	    }
	</style>
	<?php
	}
    }
}

function sh_sb_widget_styles(){
	wp_enqueue_style( 'sh-sb-widget', EFF_SOC.'css/widget.css' );
}

add_action( 'widgets_init', 'sh_sb_widget_register_widgets' );
?>