<?php
/*-----------------------------------------------------------------------------------*/		
//content width
/*-----------------------------------------------------------------------------------*/
if ( ! isset( $content_width ) )
	$content_width = 630;
/*------------------------------------------*/
/*	Admin Function
/*------------------------------------------*/
	function eff_option($option, $array=null) {
	    global $smof_data;
	    if ($array) {
		if(isset($smof_data[$option])) {
			return $smof_data[$option][$array];
		}
	    } else {
		if(isset($smof_data[$option])) {
			return $smof_data[$option];
		}
	    }
	}
                
//Page title
/*-----------------------------------------------------------------------------------*/
function eff_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'framework' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'eff_wp_title', 10, 2 );

//Meta Description
/*-----------------------------------------------------------------------------------*/
function eff_meta_desc()
{
    global $post;
    if ( ! is_singular() )
        return;
    $meta = strip_tags( $post->post_content );
    $meta = str_replace( array( "\\n", "\\r", "\\t" ), ' ', $meta);
    $meta = substr( $meta, 0, 125 );
    echo "<meta name='description' content='{$meta}' />";
}

//Meta keywords CVS Tags
/*-----------------------------------------------------------------------------------*/
function csv_tags() {
	$posttags = get_the_tags();
	foreach((array)$posttags as $tag) {
		$csv_tags .= $tag->name . ',';
	}
	echo '<meta name="keywords" content="'.$csv_tags.'" />';
}

// Canonical url
/*-----------------------------------------------------------------------------------*/
function eff_canonical_url() {
    		if ( is_singular() ) {
        		$canonical_url = "\t";
        		$canonical_url .= '<link rel="canonical" href="' . get_permalink() . '" />';
        		$canonical_url .= "\n\n";        
        		echo apply_filters('eff_canonical_url', $canonical_url);
				}
}

// Create Content Type
/*-----------------------------------------------------------------------------------*/
function eff_create_contenttype() {
    $content  = "\t";
    $content .= "<meta http-equiv=\"Content-Type\" content=\"";
    $content .= get_bloginfo('html_type'); 
    $content .= "; charset=";
    $content .= get_bloginfo('charset');
    $content .= "\" />";
    $content .= "\n\n";
    echo apply_filters('eff_create_contenttype', $content);
}

// Meta Tag Robots
/*-----------------------------------------------------------------------------------*/
function eff_create_robots() {
        global $paged;
		$content = "\t";
		if((is_home() && ($paged < 2 )) || is_front_page() || is_single() || is_page() || is_attachment()) {
				$content .= "<meta name=\"robots\" content=\"index,follow\" />";
		} elseif (is_search()) {
			$content .= "<meta name=\"robots\" content=\"noindex,nofollow\" />";
		} else {	
			$content .= "<meta name=\"robots\" content=\"noindex,follow\" />";
		}
		$content .= "\n\n";
		if (get_option('blog_public')) {
				echo apply_filters('eff_create_robots', $content);
		}
}
function eff_show_robots() {
    $display = TRUE;
    $display = apply_filters('eff_show_robots', $display);
    if ($display) {
        eff_create_robots();
    }
}

//Favicon Function
/*-----------------------------------------------------------------------------------*/
function eff_favico() {
	if (eff_option('custom_favicon') !== '') {
	echo '<link rel="shortcut icon" href="'. eff_option('custom_favicon') .'">'."\n";
	} else { ?>
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri() ?>/favicon.ico" />
	<?php }
}
add_action('wp_head', 'eff_favico');

//Google analytics
/*-----------------------------------------------------------------------------------*/
function eff_analytics(){
	$output = eff_option('google_analytics');
	if ( $output != '' )
		echo stripslashes( $output ) . "\n";
}
add_action( 'wp_footer','eff_analytics' );

//Load Responsive Meta
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_head', 'load_responsive_meta_tags', 10 );
if ( ! function_exists( 'load_responsive_meta_tags' ) ) {
	function load_responsive_meta_tags () {
		$html = '';

		$html .= "\n" . '<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->' . "\n";
		$html .= '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />' . "\n";

		/* Remove this if not responsive design */
		$html .= "\n" . '<!--  Mobile viewport scale | Disable user zooming as the layout is optimised -->' . "\n";
		$html .= '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">' . "\n";

		echo $html;
	} // End load_responsive_meta_tags()
}

/*	Stiky Nav
/*-------------------------------------------------------------------------------*/
function eff_stiky() { ?>
	<script>	
	jQuery(document).ready(function($) {
		var stickyHeaderTop = $('.navigation').offset().top;
		$(window).scroll(function(){
		    if( $(window).scrollTop() > stickyHeaderTop ) {
			//$('.navigation').css({position: 'fixed', top: '0px', float: 'right'});
			$('.navigation').addClass("sticky_nav");
		    } else {
			$('.navigation').removeClass("sticky_nav");
		    }
		});
	});
	</script>
<?php }

//image size
add_image_size( 'newsbox1', 277, 147, true );
add_image_size( 'newsbox2', 277, 153, true );
add_image_size( 'small-thumb', 50, 50, true );
add_image_size( 'newsbox3', 250, 143, true );
add_image_size( 'newsbox5', 306, 222, true );
add_image_size( 'newspic', 70, 70, true );
add_image_size( 'newspic2', 223, 138, true );
add_image_size( 'newspic3', 71, 60, true );
add_image_size( 'caro1', 125, 67, true );
add_image_size( 'caro2', 154, 103, true );
add_image_size( 'cycleslider', 609, 340, true );
add_image_size( 'caroslider', 314, 169, true );
add_image_size( 'caroslider2', 210, 170, true );
add_image_size( 'defslider', 630, 350, true );
// begain eff_post_image
/*-----------------------------------------------------------------------------------*/
function eff_post_image($size = ''){
		global $post;
		$image = '';
		//get the post thumbnail
		$image_id = get_post_thumbnail_id($post->ID);
		$image = wp_get_attachment_image_src($image_id,  
		$size);
		$image = $image[0];
		if ($image) return $image;
		//if the post is video post and haven't a feutre image
		$type = get_post_meta($post->ID, 'eff_article_type', true);
		$vtype = get_post_meta($post->ID, 'eff_video_type', true);
		$vId = get_post_meta($post->ID, 'eff_video_id', true);
		if($type == 'video') {
						if($vtype == 'youtube') {
						  $image = 'http://img.youtube.com/vi/'.$vId.'/0.jpg';
						} elseif ($vtype == 'vimeo') {
						$hash = unserialize(wp_remote_get("http://vimeo.com/api/v2/video/$vId.php"));
						  $image = $hash[0]['thumbnail_large'];
						} elseif ($vtype == 'daily') {
						  $image = 'http://www.dailymotion.com/thumbnail/video/'.$vId;
						}
				}
		if ($image) return $image;
		//If there is still no image, get the first image from the post
		return eff_get_first_image();
		}
		function eff_get_first_image() {
		  global $post, $posts;
		  $first_img = '';
		  ob_start();
		  ob_end_clean();
		  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		  $first_img = $matches[1][0];
		  
		  if(empty($first_img)) {
		    $first_img = "/images/default.jpg";
		  }
		  return $first_img;
		}
		
		// First Image 
		function catch_that_image() {
		global $post, $posts;
		$first_img = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		$first_img = $matches [1] [0];
	      
		if(empty($first_img)){ //Defines a default image
		  $first_img = EFF_IMG . "/default.png";
		}
		return $first_img;
	      }

// Feature Image 
/*-----------------------------------------------------------------------------------*/
function eff_thumb($img='' , $width='' , $height=''){
	global $post;
	
		$image_id = get_post_thumbnail_id($post->ID);  
		$image_url = wp_get_attachment_image($image_id, array($width,$height), false, array( 'alt'   => get_the_title() ,'title' =>  get_the_title()  ));  
		echo $image_url;
}

// Title Limit 
/*-----------------------------------------------------------------------------------*/
function short_title($num) {
 
	$limit = $num+1;
	 
	$title = str_split(get_the_title());
	 
	$length = count($title);
	 
	if ($length>=$num) {
	 
	$title = array_slice( $title, 0, $num);
	 
	$title = implode("",$title)."...";
	 
	echo $title;
	 
} else { 
	the_title();
	}
}

#  Empty Pragraph Fix
/*-----------------------------------------------------------------------------------*/
  /*
    Plugin Name: Shortcode empty Paragraph fix
    Plugin URI: http://www.johannheyne.de/wordpress/shortcode-empty-paragraph-fix/
    Description: Fix issues when shortcodes are embedded in a block of content that is filtered by wpautop.
    Author URI: http://www.johannheyne.de
    Version: 0.1
    Put this in /wp-content/plugins/ of your Wordpress installation
    */
    add_filter('the_content', 'shortcode_empty_paragraph_fix');
    function shortcode_empty_paragraph_fix($content)
    {   
        $array = array (
            '<p>[' => '[', 
            ']</p>' => ']', 
            ']<br />' => ']'
        );

        $content = strtr($content, $array);

		return $content;
    }

// Comment Template
/*-----------------------------------------------------------------------------------*/
function custom_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li id="li-comment-<?php comment_ID() ?>" class="single_comment">
     <div id="comment-<?php comment_ID(); ?>" class="comment1">
      <div class="comment-author vcard user_avatar">
         <?php echo get_avatar($comment,$size='60',$default=eff_option('custom_gravatar')); ?>
      </div>
      <?php if ($comment->comment_approved == '0') : ?>
         <em class="wait_mod"><?php _e('Your comment is awaiting moderation.' , 'framework'); ?></em>
      <?php endif; ?>
      <div class="comment-data">
  	<h4 class="comment_author_name"><?php printf(__('%s ', 'framwork'), get_comment_author_link()) ?></h4>
            <span class="comment-meta commentmetadata "><?php printf(__('%1$s at %2$s', 'framework'), get_comment_date(),  get_comment_time()) ?><?php edit_comment_link(__('(Edit)', 'framework'),'  ','') ?></span>
      </div>
	<div class="comment_content">
	  <?php comment_text() ?>
	</div>
	<div class="replay"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>
     </div>
<?php
        }

// Theme Option in Admin Bar
/*-----------------------------------------------------------------------------------*/
function admin_bar_theme_option_option() {  
	global $wp_admin_bar;   
		if ( !is_super_admin() || !is_admin_bar_showing() )      
		return;    
		$wp_admin_bar->add_menu(        
			array( 'id' => 'edit-theme',            
			'title' => __('Theme Option' , 'framework'),
                        'href' => admin_url( 'admin.php?page=optionsframework')       
		)    
		);
	}

add_action( 'admin_bar_menu', 'admin_bar_theme_option_option', 100 );

// Move to Trash in Admin Bar
/*-----------------------------------------------------------------------------------*/
function fb_add_admin_bar_trash_menu() {
  global $wp_admin_bar;
  if ( !is_super_admin() || !is_admin_bar_showing() )
      return;
  $current_object = get_queried_object();
  if ( empty($current_object) )
      return;
  if ( !empty( $current_object->post_type ) && 
     ( $post_type_object = get_post_type_object( $current_object->post_type ) ) && 
     current_user_can( $post_type_object->cap->edit_post, $current_object->ID ) 
  ) {
    $wp_admin_bar->add_menu( 
        array( 'id' => 'delete', 
            'title' => __('Move to Trash' , 'framework'), 
            'href' => get_delete_post_link($current_object->term_id) 
        ) 
    );
  }
}
add_action( 'admin_bar_menu', 'fb_add_admin_bar_trash_menu', 35 );

//Custom Dashboard login page logo
/*-----------------------------------------------------------------------------------*/
function eff_login_logo(){
	if( eff_option('wp_logo') )
    echo '<style  type="text/css"> h1 a {  background-image:url('.eff_option('wp_logo').')  !important;background-size: auto !important; } </style>';  
}  
add_action('login_head',  'eff_login_logo');

// changing the logo link from wordpress.org to your site
function eff_login_url() {  return home_url(); }

add_filter('login_headerurl', 'eff_login_url');

// changing the alt text on the logo to show your site name
function eff_login_title() { return get_option('blogname'); }

add_filter('login_headertitle', 'eff_login_title');

// Remove the p from around imgs
/*-----------------------------------------------------------------------------------*/
function eff_filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// Fix Widget Title
/*-----------------------------------------------------------------------------------*/
function widget_empty_title($output='') {
	if ($output == '') {
		return ' ';
	}
	return $output;
}
add_filter('widget_title', 'widget_empty_title');

# WPML Language Switcher
/*-----------------------------------------------------------------------------------*/
if (function_exists('icl_get_languages')) {
function language_selector_flags(){
    $languages = icl_get_languages('skip_missing=0&orderby=code');
    if(!empty($languages)){
        foreach($languages as $l){
            if(!$l['active']) echo '<a href="'.$l['url'].'">';
            echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
            if(!$l['active']) echo '</a>';
        }
    }
}
}

# breadcrumbs
/*-----------------------------------------------------------------------------------*/
function the_breadcrumb() {
 if(eff_option('breadcrumb')) {
  $delimiter = "<span class='delimiter'>&raquo;</span>";
  $home = __('Home', 'framework'); // text for the 'Home' link
  $before = '<span class="current">'; // tag before the current crumb
  $after = '</span>'; // tag after the current crumb
 
  if ( !is_home() && !is_front_page() || is_paged() ) {
 
    echo '<div id="crumbs">';
 
    global $post;
    $homeLink = home_url();
    echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
 
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $before . '' . single_cat_title('', false) . '' . $after;
 
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('d') . $after;
 
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('F') . $after;
 
    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;
 
    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
        echo $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        echo $before . get_the_title() . $after;
      }
 
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && !$post->post_parent ) {
      echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
 
    } elseif ( is_search() ) {
      echo $before . __('Search results for ', 'framework') . '"' . get_search_query() . '"' . $after;
 
    } elseif ( is_tag() ) {
      echo $before . __('Posts tagged ', 'framework') . '"' . single_tag_title('', false) . '"' . $after;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $before . __('Articles posted by ', 'framework') . $userdata->display_name . $after;
 
    } elseif ( is_404() ) {
      echo $before . __('Error 404 ', 'framework') . $after;
    }
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page', 'framework') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
    echo '</div>';
 
  }
 }
}

# Login Form
/*-----------------------------------------------------------------------------------*/
function eff_login_form( $login_only  = 0 ) {
	global $user_ID, $user_identity, $user_level;
	
	if ( $user_ID ) : ?>
		<?php if( empty( $login_only ) ): ?>
		<div id="user-login">
			<p class="welcome-text"><?php _e( 'Welcome' , 'framework' ) ?> <strong><?php echo $user_identity ?></strong> .</p>
			<span class="author-avatar"><?php echo get_avatar( $user_ID, $size = '85',$default=eff_option('custom_gravatar')); ?></span>
			<ul>
				<li><a href="<?php echo home_url() ?>/wp-admin/"><?php _e( 'Dashboard' , 'framework' ) ?> </a></li>
				<li><a href="<?php echo home_url() ?>/wp-admin/profile.php"><?php _e( 'Your Profile' , 'framework' ) ?> </a></li>
				<li><a href="<?php echo wp_logout_url(); ?>"><?php _e( 'Logout' , 'framework' ) ?> </a></li>
			</ul>
			<div class="clear"></div>
			<div class="author-s_icons">
			    <?php if ( get_the_author_meta( 'url' ) ) : ?>
			    <a class="tip_n" href="<?php the_author_meta( 'url' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( " 's site", 'framework' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-site.png" alt="" /></a>
			    <?php endif ?>
			    <?php if ( get_the_author_meta( 'facebook' ) ) : ?>
			    <a class="tip_n" href="<?php the_author_meta( 'facebook' ); ?>" title="<?php the_author_meta( 'display_name' ); ?> <?php _e( '  on Facebook', 'framework' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-fb.png" alt="" /></a>
			    <?php endif ?>
			    <?php if ( get_the_author_meta( 'twitter' ) ) : ?>
			    <a class="tip_n" href="http://twitter.com/<?php the_author_meta( 'twitter' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( '  on Twitter', 'framework' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-twitter.png" alt="" /></a>
			    <?php endif ?>	
			    <?php if ( get_the_author_meta( 'google' ) ) : ?>
			    <a class="tip_n" href="<?php the_author_meta( 'google' ); ?>" title="<?php the_author_meta( 'display_name' ); ?> <?php _e( '  on Google+', 'framework' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-google.png" alt="" /></a>
			    <?php endif ?>	
			    <?php if ( get_the_author_meta( 'linkedin' ) ) : ?>
			    <a class="tip_n" href="<?php the_author_meta( 'linkedin' ); ?>" title="<?php the_author_meta( 'display_name' ); ?> <?php _e( '  on Linkedin', 'framework' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-linkedin.png" alt="" /></a>
			    <?php endif ?>				
			    <?php if ( get_the_author_meta( 'flickr' ) ) : ?>
			    <a class="tip_n" href="<?php the_author_meta( 'flickr' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( '  on Flickr', 'framework' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-flickr.png" alt="" /></a>
			    <?php endif ?>	
			    <?php if ( get_the_author_meta( 'youtube' ) ) : ?>
			    <a class="tip_n" href="<?php the_author_meta( 'youtube' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( '  on YouTube', 'framework' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-youtube.png" alt="" /></a>
			    <?php endif ?>
			    <?php if ( get_the_author_meta( 'pinterest' ) ) : ?>
			    <a class="tip_n" href="<?php the_author_meta( 'pinterest' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( '  on Pinterest', 'framework' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-pinterest.png" alt="" /></a>
			    <?php endif ?>
			    <?php if ( get_the_author_meta( 'dribbble' ) ) : ?>
			    <a class="tip_n" href="<?php the_author_meta( 'dribbble' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( '  on Dribbble', 'framework' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-dribbble.png" alt="" /></a>
			    <?php endif ?>
			</div>
			<div class="clear"></div>
		</div>
		<?php endif; ?>
	<?php else: ?>
		<div id="login-form">
			<form action="<?php echo home_url() ?>/wp-login.php" method="post">
				<p id="log-username"><input type="text" name="log" id="log" value="<?php _e( 'Username' , 'framework' ) ?>" onfocus="if (this.value == '<?php _e( 'Username' , 'framework' ) ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e( 'Username' , 'framework' ) ?>';}"  size="33" /></p>
				<p id="log-pass"><input type="password" name="pwd" id="pwd" value="<?php _e( 'Password' , 'framework' ) ?>" onfocus="if (this.value == '<?php _e( 'Password' , 'framework' ) ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e( 'Password' , 'framework' ) ?>';}" size="33" /></p>
				<input type="submit" name="submit" value="<?php _e( 'Log in' , 'framework' ) ?>" class="login-button" />
				<label for="rememberme"><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> <?php _e( 'Remember Me' , 'framework' ) ?></label>
				<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
			</form>
			<ul class="login-links">
				<?php if ( get_option('users_can_register') ) : ?> <li><a href="<?php echo home_url() ?>/wp-register.php"><?php _e( 'Register' , 'framework' ) ?></a></li><?php endif; ?>
				<li><a href="<?php echo home_url() ?>/wp-login.php?action=lostpassword"><?php _e( 'Lost your password?' , 'framework' ) ?></a></li>
			</ul>
		</div>
	<?php endif;
}

# Author Fields
/*-----------------------------------------------------------------------------------*/
function eff_show_extra_profile_fields( $contactmethods ) {
		$contactmethods['facebook'] = 'FaceBook URL';
		$contactmethods['twitter'] = 'Twitter Username';
		$contactmethods['google'] = 'Google+';
		$contactmethods['youtube'] = 'YouTube URL';
		$contactmethods['linkedin'] = 'linkedIn URL';
		$contactmethods['flickr'] = 'Flickr URL';
		$contactmethods['pinterest'] = 'Pinterest URL';
		$contactmethods['dribbble'] = 'Dribbble URL';
	return $contactmethods;		
	}
add_filter('user_contactmethods','eff_show_extra_profile_fields',10,1);

## Save user's social accounts

add_action( 'personal_options_update', 'eff_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'eff_save_extra_profile_fields' );

function eff_save_extra_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) ) return false;
	update_user_meta( $user_id, 'google', $_POST['google'] );
	update_user_meta( $user_id, 'pinterest', $_POST['pinterest'] );
	update_user_meta( $user_id, 'twitter', $_POST['twitter'] );
	update_user_meta( $user_id, 'facebook', $_POST['facebook'] );
	update_user_meta( $user_id, 'linkedin', $_POST['linkedin'] );
	update_user_meta( $user_id, 'flickr', $_POST['flickr'] );
	update_user_meta( $user_id, 'youtube', $_POST['youtube'] );
	update_user_meta( $user_id, 'dribbble', $_POST['dribbble'] );
}
add_filter('user_contactmethods','hide_profile_fields',10,1);

function hide_profile_fields( $contactmethods ) {
    unset($contactmethods['aim']);
    unset($contactmethods['jabber']);
    unset($contactmethods['yim']);
    return $contactmethods;
}

# Social icons
/*-----------------------------------------------------------------------------------*/
function bottom_social() { ?>
	<div class="social_bottom">
	    <ul class="b_social_icons">
		<?php if(eff_option('bs_twitter')) { ?>
		<li class="twitter"><a href="<?php echo eff_option('bs_twitter'); ?>">twitter</a></li>
		<?php } ?>
		<?php if(eff_option('bs_fb')) { ?>
		<li class="facebook"><a href="<?php echo eff_option('bs_fb'); ?>">facebook</a></li>
		<?php } ?>
		<?php if(eff_option('bs_gplus')) { ?>
		<li class="gplus"><a href="<?php echo eff_option('bs_gplus'); ?>">google plus</a></li>
		<?php } ?>
		<?php if(eff_option('bs_linked')) { ?>
		<li class="linkedin"><a href="<?php echo eff_option('bs_linked'); ?>">LinkedIn</a></li>
		<?php } ?>
		<?php if(eff_option('bs_youtube')) { ?>
		<li class="youtube"><a href="<?php echo eff_option('bs_youtube'); ?>">youtube</a></li>
		<?php } ?>
		<?php if(eff_option('bs_feed')) { ?>
		<li class="feedburner"><a href="<?php echo eff_option('bs_feed'); ?>">feedburner</a></li>
		<?php } ?>
		<?php if(eff_option('bs_picasa')) { ?>
		<li class="picasa"><a href="<?php echo eff_option('bs_picasa'); ?>">picasa</a></li>
		<?php } ?>
		<?php if(eff_option('bs_digg')) { ?>
		<li class="digg"><a href="<?php echo eff_option('bs_digg'); ?>">digg</a></li>
		<?php } ?>
		<?php if(eff_option('bs_vimeo')) { ?>
		<li class="vimeo"><a href="<?php echo eff_option('bs_vimeo'); ?>">Vimeo</a></li>
		<?php } ?>
	    </ul>
	</div>
<?php }
function header_social() { ?>
	<div class="custom-social-icons">
	    <ul>
		<?php social_bartender(); ?>
	    </ul>
	</div>
<?php }

//Post Pagination
/*-----------------------------------------------------------------------------------*/
function custom_nextpage_links($defaults) {
$args = array(
'before' => '<div class="my-paginated-posts"><p>' . __('Pages &rarr;&nbsp;', 'framwork'),
'after' => '</p></div>',
);
$r = wp_parse_args($args, $defaults);
return $r;
}
add_filter('wp_link_pages_args','custom_nextpage_links');

# Mobile Menus
/*-----------------------------------------------------------------------------------*/
function wp_top_menu_select( $args = array() ) {
 
    $defaults = array(
        'theme_location' => 'topnav',
        'menu_class' => 'mobileTopMenu',
    );
 
    $args = wp_parse_args( $args, $defaults );
 
    if ( ( $menu_locations = get_nav_menu_locations() ) && isset( $menu_locations[ $args['theme_location'] ] ) ) {
        $menu = wp_get_nav_menu_object( $menu_locations[ $args['theme_location'] ] );
        $menu_items = wp_get_nav_menu_items( $menu->term_id );
        ?>
            <select id="mobileTopMenu" class="<?php echo $args['menu_class'] ?>">
                <option value=""><?php _e( 'Go To..' ); ?></option>
                <?php foreach( (array) $menu_items as $key => $menu_item ) :
		    $title = $menu_item->title;
		    $url = $menu_item->url;
		    if ( $menu_item->menu_item_parent ) {
				$title = ' - ' . $title;
		    }
		?>
                    <option value="<?php echo $url ?>"><?php echo $title ?></option>
                <?php endforeach; ?>
            </select>
        <?php
    }
}
function wp_nav_menu_select( $args = array() ) {
 
    $defaults = array(
        'theme_location' => 'main',
        'menu_class' => 'mobileMainMenu',
    );
 
    $args = wp_parse_args( $args, $defaults );
 
    if ( ( $menu_locations = get_nav_menu_locations() ) && isset( $menu_locations[ $args['theme_location'] ] ) ) {
        $menu = wp_get_nav_menu_object( $menu_locations[ $args['theme_location'] ] );
        $menu_items = wp_get_nav_menu_items( $menu->term_id );
        ?>
            <select id="mobileMainMenu" class="<?php echo $args['menu_class'] ?>">
                <option value=""><?php _e( 'Go To..' ); ?></option>
                <?php foreach( (array) $menu_items as $key => $menu_item ) :
		    $title = $menu_item->title;
		    $url = $menu_item->url;
		    if ( $menu_item->menu_item_parent ) {
				$title = ' - ' . $title;
		    }
		?>
                    <option value="<?php echo $url ?>"><?php echo $title ?></option>
                <?php endforeach; ?>
            </select>
        <?php
    }
}

# notification
/*-----------------------------------------------------------------------------------*/
function eff_notification() { ?>
	<div class="notification ondemand hide">     
                <p>
		    <?php if(eff_option('notification_text')) { ?>
			<?php echo eff_option('notification_text'); ?>
		    <?php } ?>
		    <?php if(eff_option('notification_link')) { ?>
		    <a href="<?php echo eff_option('notification_url'); ?>" target="_blank"><?php echo eff_option('notification_link'); ?></a>
		    <?php } ?>
		</p>
            <a class="close" href="javascript:">
            <img src="<?php echo get_template_directory_uri(); ?>/images/icon-close.png" />
            </a> 
        </div>
	<script>
	jQuery(document).ready(function($) {
	    //notification
	    $('.notification.ondemand').notify();
	    $('.button').click(function () {
	    $('.notification').removeClass('hide').addClass('hide').removeClass('visible');
	    $('.notification.' + $(this).attr('id') + '').notify({ type: $(this).attr('id') });
	    });
	}); 
	</script>
<?php }

// Category Options
/*-----------------------------------------------------------------------------------*/
add_action ( 'edit_category_form_fields', 'eff_category_style');
add_action ( 'category_add_form_fields', 'eff_category_style');
    function eff_category_style( $tag ) {
	$t_id = $tag->term_id;
	$cat_meta = get_option( "category_$t_id");
    ?>
	<div class="form-field">
	<tr class="form-field">
	<th scope="row" valign="top"><label><?php _e('Color'); ?></label></th>
	<td>
	<input id="color" name="Cat_meta[color]" type="text" value="<?php echo $cat_meta['color'] ? $cat_meta['color'] : ''; ?>"/><br />
	<div id="colorpicker"></div>
	</td>
	</tr>
	</div>
	
	<div class="form-field">
	<tr class="form-field">
	<th scope="row" valign="top"><label><?php _e('Background Image'); ?></label></th>
	<td>	
	<label for="upload_image">
	    <input id="upload_image" type="text" size="36" name="Cat_meta[bg]" value="<?php echo $cat_meta['bg'] ? $cat_meta['bg'] : ''; ?>" style="width: auto !important;"/> 
	    <input id="upload_image_button" class="button" type="button" value="Upload Image" style="width: auto !important;"/>
	    <br />Enter a URL or upload an image
	</label>
	</td>
	</tr>
	</div>

    <?php
    }
add_action ( 'edited_category', 'save_eff_category_style');
add_action ( 'create_category', 'save_eff_category_style');
    function save_eff_category_style( $term_id ) {
	if ( isset( $_POST['Cat_meta'] ) ) {
	$t_id = $term_id;
	$cat_meta = get_option( "category_$t_id");
	$cat_keys = array_keys($_POST['Cat_meta']);
	foreach ($cat_keys as $key){
	if (isset($_POST['Cat_meta'][$key])){
	$cat_meta[$key] = $_POST['Cat_meta'][$key];
	}
    }
update_option( "category_$t_id", $cat_meta );
}
}

add_action ( 'edit_category_form_fields', 'add_styles_scripts_color');
add_action ( 'category_add_form_fields', 'add_styles_scripts_color');
function add_styles_scripts_color(){
    //Access the global $wp_version variable to see which version of WordPress is installed.
    global $wp_version;
 
    //If the WordPress version is greater than or equal to 3.5, then load the new WordPress color picker.
    if ( 3.5 <= $wp_version ){
        //Both the necessary css and javascript have been registered already by WordPress, so all we have to do is load them with their handle.
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
    }
    //If the WordPress version is less than 3.5 load the older farbtasic color picker.
    else {
        //As with wp-color-picker the necessary css and javascript have been registered already by WordPress, so all we have to do is load them with their handle.
        wp_enqueue_style( 'farbtastic' );
        wp_enqueue_script( 'farbtastic' );
    }
    //Load our custom javascript file
    wp_enqueue_script( 'wp-color-picker-settings', get_template_directory_uri() . '/js/admin.js' );
    wp_enqueue_media();
    }

//Woocomerce support 
/*-----------------------------------------------------------------------------------*/
function hide_woocommerce_page_title($content) {
	return false;
}

add_filter('woocommerce_show_page_title','hide_woocommerce_page_title');

function eff_get_woocommerce_page_id(){
	//check woocommerce
	if ( class_exists( 'Woocommerce' ) ) {
		if(is_woocommerce()) return woocommerce_get_page_id('shop');
		if(is_account_page()) return woocommerce_get_page_id('myaccount');
		if(is_cart()) return woocommerce_get_page_id('cart');
	}
	return;
}

//FaceBook Open Graph
/*-----------------------------------------------------------------------------------*/
function fb_og(){
    if (have_posts()):while(have_posts()):the_post(); endwhile; endif;?>
    <meta property="fb:app_id" content="508692752556567" />  
    <meta property="fb:admins" content="1849668240" /> 
    <?php if (is_single()) { ?>  
    <meta property="og:url" content="<?php the_permalink() ?>"/>  
    <meta property="og:title" content="<?php the_title(); ?>" />  
    <meta property="og:description" content="<?php echo strip_shortcodes(get_the_excerpt($post->ID)); ?>" />  
    <meta property="og:type" content="<?php if (is_single() || is_page()) { echo "article"; } else { echo "website";} ?>"/>
    <meta property="og:image" content="<?php echo get_fbimage(); ?>" />    
    <?php }  
}
//Generating the best Image Thumbnail
function get_fbimage() {
  $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', '' );
  if ( has_post_thumbnail($post->ID) ) {
    $fbimage = $src[0];
  } else {
    global $post, $posts;
    $fbimage = '';
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i',
    $post->post_content, $matches);
    $fbimage = $matches [1] [0];
  }
  if(empty($fbimage)) {
    $fbimage = eff_option('logo_img');
  }
  return $fbimage;
}


//Detects the Charset of String and Converts it to UTF-8
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'eff_encoding_convert') ) {
	function eff_encoding_convert($str_to_convert) {
		if ( function_exists( 'mb_detect_encoding') ) {
			$str_lang_encoding = mb_detect_encoding($str_to_convert);
			//if no encoding detected, assume UTF-8
			if (!$str_lang_encoding) {
				//UTF-8 assumed
				$str_lang_converted_utf = $str_to_convert;
			} else {
				//Convert to UTF-8
				$str_lang_converted_utf = mb_convert_encoding($str_to_convert, 'UTF-8', $str_lang_encoding);
			}
		} else {
			$str_lang_converted_utf = $str_to_convert;
		}

		return $str_lang_converted_utf;
	}
}

//Exclude Pages from Search Results
/*-----------------------------------------------------------------------------------*/
if(eff_option('ex_pages') == true) {
add_filter('pre_get_posts','SearchFilter');
function SearchFilter($query) {
    if ($query->is_search) {
    $query->set('post_type', 'post');
    }
    return $query;
    }
}

//Exclude Category from Search Results
/*-----------------------------------------------------------------------------------*/
if(eff_option('ex_cat')) {
add_filter( 'pre_get_posts', 'ja_search_filter' );
$excats = eff_option('ex_cat');
function ja_search_filter( $query ) {
 
    if ( $query->is_search && !is_admin() )
	    $query->set( 'cat',''.$excats.'' );

    return $query;
    }
}

//Google Fonts
/*-----------------------------------------------------------------------------------*/
$google_fonts = array(	array( 'name' => "ABeeZee", 'variant' => ''),
			array( 'name' => "Abel", 'variant' => ''), 
			array( 'name' => "Abril Fatface", 'variant' => ''), 
			array( 'name' => "Aclonica", 'variant' => ''),
			array( 'name' => "Acme", 'variant' => ''), 
			array( 'name' => "Actor", 'variant' => ''), 
			array( 'name' => "Adamina", 'variant' => ''), 
			array( 'name' => "Advent Pro", 'variant' => ''), 
			array( 'name' => "Aguafina Script", 'variant' => ''), 
			array( 'name' => "Akronim", 'variant' => ''),
			array( 'name' => "Aladin", 'variant' => ''),
			array( 'name' => "Aldrich", 'variant' => ''),
			array( 'name' => "Alef", 'variant' => ''),
			array( 'name' => "Alegreya SC", 'variant' => ''), 
			array( 'name' => "Alegreya", 'variant' => ''), 
			array( 'name' => "Alex Brush", 'variant' => ''), 
			array( 'name' => "Alfa Slab One", 'variant' => ''),
			array( 'name' => "Alice", 'variant' => ''), 
			array( 'name' => "Alike Angular", 'variant' => ''),
			array( 'name' => "Alike", 'variant' => ''), 
			array( 'name' => "Allan", 'variant' => ''), 
			array( 'name' => "Allerta Stencil", 'variant' => ''),
			array( 'name' => "Allerta", 'variant' => ''), 
			array( 'name' => "Allura", 'variant' => ''), 
			array( 'name' => "Almendra Display", 'variant' => ''),
			array( 'name' => "Almendra SC", 'variant' => ''),
			array( 'name' => "Almendra", 'variant' => ''),
			array( 'name' => "Amarante", 'variant' => ''),
			array( 'name' => "Amaranth", 'variant' => ''), 
			array( 'name' => "Amatic SC", 'variant' => ''), 
			array( 'name' => "Amethysta", 'variant' => ''), 
			array( 'name' => "Anaheim", 'variant' => ''), 
			array( 'name' => "Andada", 'variant' => ''), 
			array( 'name' => "Andika", 'variant' => ''), 
			array( 'name' => "Annie Use Your Telescope", 'variant' => ''), 
			array( 'name' => "Anonymous Pro", 'variant' => ''), 
			array( 'name' => "Antic Didone", 'variant' => ''), 
			array( 'name' => "Antic Slab", 'variant' => ''), 
			array( 'name' => "Antic", 'variant' => ''), 
			array( 'name' => "Anton", 'variant' => ''),
			array( 'name' => "Arapey", 'variant' => ''), 
			array( 'name' => "Arbutus Slab", 'variant' => ''), 
			array( 'name' => "Arbutus", 'variant' => ''),
			array( 'name' => "Architects Daughter", 'variant' => ''),
			array( 'name' => "Archivo Black", 'variant' => ''),
			array( 'name' => "Archivo Narrow", 'variant' => ''),
			array( 'name' => "Arimo", 'variant' => ''), 
			array( 'name' => "Arizonia", 'variant' => ''), 
			array( 'name' => "Armata", 'variant' => ''), 
			array( 'name' => "Artifika", 'variant' => ''), 
			array( 'name' => "Arvo", 'variant' => ''), 
			array( 'name' => "Asap", 'variant' => ''), 
			array( 'name' => "Asset", 'variant' => ''), 
			array( 'name' => "Astloch", 'variant' => ''), 
			array( 'name' => "Asul", 'variant' => ''), 
			array( 'name' => "Atomic Age", 'variant' => ''), 
			array( 'name' => "Aubrey", 'variant' => ''), 
			array( 'name' => "Audiowide", 'variant' => ''), 
			array( 'name' => "Autour One", 'variant' => ''), 
			array( 'name' => "Average Sans", 'variant' => ''), 
			array( 'name' => "Average", 'variant' => ''),
			array( 'name' => "Averia Gruesa Libre", 'variant' => ''), 
			array( 'name' => "Averia Libre", 'variant' => ''), 
			array( 'name' => "Averia Sans Libre", 'variant' => ''), 
			array( 'name' => "Averia Serif Libre", 'variant' => ''), 
			array( 'name' => "Bad Script", 'variant' => ''), 
			array( 'name' => "Balthazar", 'variant' => ''), 
			array( 'name' => "Bangers", 'variant' => ''), 
			array( 'name' => "Basic", 'variant' => ''), 
			array( 'name' => "Baumans", 'variant' => ''), 
			array( 'name' => "Belgrano", 'variant' => ''), 
			array( 'name' => "Belleza", 'variant' => ''), 
			array( 'name' => "BenchNine", 'variant' => ''),
			array( 'name' => "Bentham", 'variant' => ''), 
			array( 'name' => "Berkshire Swash", 'variant' => ''), 
			array( 'name' => "Bevan", 'variant' => ''), 
			array( 'name' => "Bigelow Rules", 'variant' => ''),
			array( 'name' => "Bigshot One", 'variant' => ''), 
			array( 'name' => "Bilbo Swash Caps", 'variant' => ''),
			array( 'name' => "Bilbo", 'variant' => ''), 
			array( 'name' => "Bitter", 'variant' => ''), 
			array( 'name' => "Black Ops One", 'variant' => ''),
			array( 'name' => "Bonbon", 'variant' => ''), 
			array( 'name' => "Boogaloo", 'variant' => ''), 
			array( 'name' => "Bowlby One SC", 'variant' => ''), 
			array( 'name' => "Bowlby One", 'variant' => ''), 
			array( 'name' => "Brawler", 'variant' => ''), 
			array( 'name' => "Bree Serif", 'variant' => ''), 
			array( 'name' => "Bubblegum Sans", 'variant' => ''), 
			array( 'name' => "Bubbler One", 'variant' => ''), 
			array( 'name' => "Buda", 'variant' => ''), 
			array( 'name' => "Buenard", 'variant' => ''), 
			array( 'name' => "Butcherman", 'variant' => ''), 
			array( 'name' => "Butterfly Kids", 'variant' => ''), 
			array( 'name' => "Cabin Condensed", 'variant' => ''),
			array( 'name' => "Cabin Sketch", 'variant' => ''), 
			array( 'name' => "Cabin", 'variant' => ''), 
			array( 'name' => "Caesar Dressing", 'variant' => ''), 
			array( 'name' => "Cagliostro", 'variant' => ''), 
			array( 'name' => "Calligraffitti", 'variant' => ''),
			array( 'name' => "Cambo", 'variant' => ''), 
			array( 'name' => "Candal", 'variant' => ''), 
			array( 'name' => "Cantarell", 'variant' => ''), 
			array( 'name' => "Cantata One", 'variant' => ''), 
			array( 'name' => "Cantora One", 'variant' => ''), 
			array( 'name' => "Capriola", 'variant' => ''), 
			array( 'name' => "Cardo", 'variant' => ''), 
			array( 'name' => "Carme", 'variant' => ''), 
			array( 'name' => "Carrois Gothic SC", 'variant' => ''), 
			array( 'name' => "Carrois Gothic", 'variant' => ''), 
			array( 'name' => "Carter One", 'variant' => ''), 
			array( 'name' => "Caudex", 'variant' => ''), 
			array( 'name' => "Cedarville Cursive", 'variant' => ''), 
			array( 'name' => "Ceviche One", 'variant' => ''), 
			array( 'name' => "Changa One", 'variant' => ''), 
			array( 'name' => "Chango", 'variant' => ''), 
			array( 'name' => "Chau Philomene One", 'variant' => ''), 
			array( 'name' => "Chela One", 'variant' => ''), 
			array( 'name' => "Chelsea Market", 'variant' => ''), 
			array( 'name' => "Cherry Cream Soda", 'variant' => ''), 
			array( 'name' => "Cherry Swash", 'variant' => ''), 
			array( 'name' => "Chewy", 'variant' => ''), 
			array( 'name' => "Chicle", 'variant' => ''), 
			array( 'name' => "Chivo", 'variant' => ''), 
			array( 'name' => "Cinzel Decorative", 'variant' => ''), 
			array( 'name' => "Cinzel", 'variant' => ''), 
			array( 'name' => "Clicker Script", 'variant' => ''), 
			array( 'name' => "Coda Caption", 'variant' => ''), 
			array( 'name' => "Coda", 'variant' => ''), 
			array( 'name' => "Codystar", 'variant' => ''), 
			array( 'name' => "Combo", 'variant' => ''), 
			array( 'name' => "Comfortaa", 'variant' => ''), 
			array( 'name' => "Coming Soon", 'variant' => ''), 
			array( 'name' => "Concert One", 'variant' => ''), 
			array( 'name' => "Condiment", 'variant' => ''), 
			array( 'name' => "Contrail One", 'variant' => ''), 
			array( 'name' => "Convergence", 'variant' => ''), 
			array( 'name' => "Cookie", 'variant' => ''), 
			array( 'name' => "Copse", 'variant' => ''), 
			array( 'name' => "Corben", 'variant' => ''), 
			array( 'name' => "Courgette", 'variant' => ''), 
			array( 'name' => "Cousine", 'variant' => ''), 
			array( 'name' => "Coustard", 'variant' => ''), 
			array( 'name' => "Covered By Your Grace", 'variant' => ''), 
			array( 'name' => "Crafty Girls", 'variant' => ''), 
			array( 'name' => "Creepster", 'variant' => ''), 
			array( 'name' => "Crete Round", 'variant' => ''), 
			array( 'name' => "Crimson Text", 'variant' => ''), 
			array( 'name' => "Croissant One", 'variant' => ''), 
			array( 'name' => "Crushed", 'variant' => ''), 
			array( 'name' => "Cuprum", 'variant' => ''), 
			array( 'name' => "Cutive Mono", 'variant' => ''), 
			array( 'name' => "Cutive", 'variant' => ''), 
			array( 'name' => "Damion", 'variant' => ''),
			array( 'name' => "Dancing Script", 'variant' => ''), 
			array( 'name' => "Dawning of a New Day", 'variant' => ''), 
			array( 'name' => "Days One", 'variant' => ''), 
			array( 'name' => "Delius Swash Caps", 'variant' => ''), 
			array( 'name' => "Delius Unicase", 'variant' => ''),
			array( 'name' => "Delius", 'variant' => ''), 
			array( 'name' => "Della Respira", 'variant' => ''), 
			array( 'name' => "Denk One", 'variant' => ''), 
			array( 'name' => "Devonshire", 'variant' => ''), 
			array( 'name' => "Didact Gothic", 'variant' => ''), 
			array( 'name' => "Diplomata SC", 'variant' => ''), 
			array( 'name' => "Diplomata", 'variant' => ''), 
			array( 'name' => "Domine", 'variant' => ''), 
			array( 'name' => "Donegal One", 'variant' => ''), 
			array( 'name' => "Doppio One", 'variant' => ''), 
			array( 'name' => "Dorsa", 'variant' => ''), 
			array( 'name' => "Dosis", 'variant' => ''), 
			array( 'name' => "Dr Sugiyama", 'variant' => ''), 
			array( 'name' => "Droid Sans Mono", 'variant' => ''), 
			array( 'name' => "Droid Sans", 'variant' => ''), 
			array( 'name' => "Droid Serif", 'variant' => ''), 
			array( 'name' => "Duru Sans", 'variant' => ''), 
			array( 'name' => "Dynalight", 'variant' => ''), 
			array( 'name' => "Eagle Lake", 'variant' => ''), 
			array( 'name' => "Eater", 'variant' => ''), 
			array( 'name' => "EB Garamond", 'variant' => ''), 
			array( 'name' => "Economica", 'variant' => ''), 
			array( 'name' => "Electrolize", 'variant' => ''), 
			array( 'name' => "Elsie Swash Caps", 'variant' => ''), 
			array( 'name' => "Elsie", 'variant' => ''), 
			array( 'name' => "Emblema One", 'variant' => ''), 
			array( 'name' => "Emilys Candy", 'variant' => ''), 
			array( 'name' => "Engagement", 'variant' => ''), 
			array( 'name' => "Englebert", 'variant' => ''), 
			array( 'name' => "Enriqueta", 'variant' => ''), 
			array( 'name' => "Erica One", 'variant' => ''), 
			array( 'name' => "Esteban", 'variant' => ''), 
			array( 'name' => "Euphoria Script", 'variant' => ''), 
			array( 'name' => "Ewert", 'variant' => ''), 
			array( 'name' => "Exo", 'variant' => ''), 
			array( 'name' => "Expletus Sans", 'variant' => ''), 
			array( 'name' => "Fanwood Text", 'variant' => ''), 
			array( 'name' => "Fascinate Inline", 'variant' => ''), 
			array( 'name' => "Fascinate", 'variant' => ''), 
			array( 'name' => "Faster One", 'variant' => ''),
			array( 'name' => "Fauna One", 'variant' => ''),
			array( 'name' => "Federant", 'variant' => ''),
			array( 'name' => "Federo", 'variant' => ''),
			array( 'name' => "Felipa", 'variant' => ''),
			array( 'name' => "Fenix", 'variant' => ''),
			array( 'name' => "Finger Paint", 'variant' => ''),
			array( 'name' => "Fjalla One", 'variant' => ''),
			array( 'name' => "Fjord One", 'variant' => ''),
			array( 'name' => "Flamenco", 'variant' => ''),
			array( 'name' => "Flavors", 'variant' => ''),
			array( 'name' => "Fondamento", 'variant' => ''),
			array( 'name' => "Fontdiner Swanky", 'variant' => ''),
			array( 'name' => "Forum", 'variant' => ''),
			array( 'name' => "Francois One", 'variant' => ''),
			array( 'name' => "Freckle Face", 'variant' => ''),
			array( 'name' => "Fredericka the Great", 'variant' => ''),
			array( 'name' => "Fredoka One", 'variant' => ''), 
			array( 'name' => "Fresca", 'variant' => ''),
			array( 'name' => "Frijole", 'variant' => ''),
			array( 'name' => "Fruktur", 'variant' => ''),
			array( 'name' => "Fugaz One", 'variant' => ''),
			array( 'name' => "Gabriela", 'variant' => ''),
			array( 'name' => "Gafata", 'variant' => ''), 
			array( 'name' => "Galdeano", 'variant' => ''),
			array( 'name' => "Galindo", 'variant' => ''),
			array( 'name' => "Gentium Basic", 'variant' => ''),
			array( 'name' => "Gentium Book Basic", 'variant' => ''),
			array( 'name' => "Geo", 'variant' => ''), 
			array( 'name' => "Geostar Fill", 'variant' => ''), 
			array( 'name' => "Geostar", 'variant' => ''), 
			array( 'name' => "Germania One", 'variant' => ''),
			array( 'name' => "Gilda Display", 'variant' => ''),
			array( 'name' => "Give You Glory", 'variant' => ''), 
			array( 'name' => "Glass Antiqua", 'variant' => ''), 
			array( 'name' => "Glegoo", 'variant' => ''), 
			array( 'name' => "Gloria Hallelujah", 'variant' => ''), 
			array( 'name' => "Goblin One", 'variant' => ''), 
			array( 'name' => "Gochi Hand", 'variant' => ''), 
			array( 'name' => "Gorditas", 'variant' => ''), 
			array( 'name' => "Goudy Bookletter 1911", 'variant' => ''), 
			array( 'name' => "Graduate", 'variant' => ''), 
			array( 'name' => "Grand Hotel", 'variant' => ''), 
			array( 'name' => "Gravitas One", 'variant' => ''), 
			array( 'name' => "Great Vibes", 'variant' => ''), 
			array( 'name' => "Griffy", 'variant' => ''), 
			array( 'name' => "Gruppo", 'variant' => ''), 
			array( 'name' => "Gudea", 'variant' => ''), 
			array( 'name' => "Habibi", 'variant' => ''), 
			array( 'name' => "Hammersmith One", 'variant' => ''), 
			array( 'name' => "Hanalei Fill", 'variant' => ''), 
			array( 'name' => "Hanalei", 'variant' => ''), 
			array( 'name' => "Handlee", 'variant' => ''), 
			array( 'name' => "Happy Monkey", 'variant' => ''), 
			array( 'name' => "Headland One", 'variant' => ''), 
			array( 'name' => "Henny Penny", 'variant' => ''), 
			array( 'name' => "Herr Von Muellerhoff", 'variant' => ''), 
			array( 'name' => "Holtwood One SC", 'variant' => ''), 
			array( 'name' => "Homemade Apple", 'variant' => ''), 
			array( 'name' => "Homenaje", 'variant' => ''), 
			array( 'name' => "Iceberg", 'variant' => ''), 
			array( 'name' => "Iceland", 'variant' => ''), 
			array( 'name' => "IM Fell Double Pica SC", 'variant' => ''), 
			array( 'name' => "IM Fell Double Pica", 'variant' => ''), 
			array( 'name' => "IM Fell DW Pica SC", 'variant' => ''), 
			array( 'name' => "IM Fell DW Pica", 'variant' => ''), 
			array( 'name' => "IM Fell English SC", 'variant' => ''), 
			array( 'name' => "IM Fell English", 'variant' => ''), 
			array( 'name' => "IM Fell French Canon SC", 'variant' => ''), 
			array( 'name' => "IM Fell French Canon", 'variant' => ''), 
			array( 'name' => "IM Fell Great Primer SC", 'variant' => ''), 
			array( 'name' => "IM Fell Great Primer", 'variant' => ''),
			array( 'name' => "Imprima", 'variant' => ''),
			array( 'name' => "Inconsolata", 'variant' => ''),
			array( 'name' => "Inder", 'variant' => ''), 
			array( 'name' => "Indie Flower", 'variant' => ''),
			array( 'name' => "Inika", 'variant' => ''), 
			array( 'name' => "Irish Grover", 'variant' => ''),
			array( 'name' => "Istok Web", 'variant' => ''), 
			array( 'name' => "Italiana", 'variant' => ''), 
			array( 'name' => "Italianno", 'variant' => ''), 
			array( 'name' => "Jacques Francois Shadow", 'variant' => ''),
			array( 'name' => "Jacques Francois", 'variant' => ''), 
			array( 'name' => "Jim Nightshade", 'variant' => ''), 
			array( 'name' => "Jockey One", 'variant' => ''), 
			array( 'name' => "Jolly Lodger", 'variant' => ''), 
			array( 'name' => "Josefin Sans", 'variant' => ''), 
			array( 'name' => "Josefin Slab", 'variant' => ''), 
			array( 'name' => "Joti One", 'variant' => ''), 
			array( 'name' => "Judson", 'variant' => ''), 
			array( 'name' => "Julee", 'variant' => ''), 
			array( 'name' => "Julius Sans One", 'variant' => ''), 
			array( 'name' => "Junge", 'variant' => ''), 
			array( 'name' => "Jura", 'variant' => ''), 
			array( 'name' => "Just Another Hand", 'variant' => ''), 
			array( 'name' => "Just Me Again Down Here", 'variant' => ''), 
			array( 'name' => "Kameron", 'variant' => ''), 
			array( 'name' => "Karla", 'variant' => ''), 
			array( 'name' => "Kaushan Script", 'variant' => ''), 
			array( 'name' => "Kavoon", 'variant' => ''), 
			array( 'name' => "Keania One", 'variant' => ''), 
			array( 'name' => "Kelly Slab", 'variant' => ''), 
			array( 'name' => "Kenia", 'variant' => ''), 
			array( 'name' => "Kite One", 'variant' => ''), 
			array( 'name' => "Knewave", 'variant' => ''), 
			array( 'name' => "Kotta One", 'variant' => ''), 
			array( 'name' => "Kranky", 'variant' => ''), 
			array( 'name' => "Kreon", 'variant' => ''), 
			array( 'name' => "Kristi", 'variant' => ''), 
			array( 'name' => "Krona One", 'variant' => ''), 
			array( 'name' => "La Belle Aurore", 'variant' => ''), 
			array( 'name' => "Lancelot", 'variant' => ''), 
			array( 'name' => "Lato", 'variant' => ''), 
			array( 'name' => "League Script", 'variant' => ''), 
			array( 'name' => "Leckerli One", 'variant' => ''), 
			array( 'name' => "Ledger", 'variant' => ''),
			array( 'name' => "Lekton", 'variant' => ''), 
			array( 'name' => "Lemon", 'variant' => ''),
			array( 'name' => "Libre Baskerville", 'variant' => ''), 
			array( 'name' => "Life Savers", 'variant' => ''), 
			array( 'name' => "Lilita One", 'variant' => ''), 
			array( 'name' => "Lily Script One", 'variant' => ''), 
			array( 'name' => "Limelight", 'variant' => ''), 
			array( 'name' => "Linden Hill", 'variant' => ''), 
			array( 'name' => "Lobster Two", 'variant' => ''), 
			array( 'name' => "Lobster", 'variant' => ''),
			array( 'name' => "Londrina Outline", 'variant' => ''), 
			array( 'name' => "Londrina Shadow", 'variant' => ''),
			array( 'name' => "Londrina Sketch", 'variant' => ''), 
			array( 'name' => "Londrina Solid", 'variant' => ''), 
			array( 'name' => "Lora", 'variant' => ''), 
			array( 'name' => "Love Ya Like A Sister", 'variant' => ''), 
			array( 'name' => "Loved by the King", 'variant' => ''), 
			array( 'name' => "Lovers Quarrel", 'variant' => ''), 
			array( 'name' => "Luckiest Guy", 'variant' => ''), 
			array( 'name' => "Lusitana", 'variant' => ''), 
			array( 'name' => "Lustria", 'variant' => ''), 
			array( 'name' => "Macondo Swash Caps", 'variant' => ''), 
			array( 'name' => "Macondo", 'variant' => ''), 
			array( 'name' => "Magra", 'variant' => ''),
			array( 'name' => "Maiden Orange", 'variant' => ''), 
			array( 'name' => "Mako", 'variant' => ''), 
			array( 'name' => "Marcellus SC", 'variant' => ''), 
			array( 'name' => "Marcellus", 'variant' => ''), 
			array( 'name' => "Marck Script", 'variant' => ''), 
			array( 'name' => "Margarine", 'variant' => ''), 
			array( 'name' => "Marko One", 'variant' => ''), 
			array( 'name' => "Marmelad", 'variant' => ''), 
			array( 'name' => "Marvel", 'variant' => ''), 
			array( 'name' => "Mate SC", 'variant' => ''), 
			array( 'name' => "Mate", 'variant' => ''), 
			array( 'name' => "Maven Pro", 'variant' => ''), 
			array( 'name' => "McLaren", 'variant' => ''), 
			array( 'name' => "Meddon", 'variant' => ''), 
			array( 'name' => "MedievalSharp", 'variant' => ''), 
			array( 'name' => "Medula One", 'variant' => ''), 
			array( 'name' => "Megrim", 'variant' => ''), 
			array( 'name' => "Meie Script", 'variant' => ''), 
			array( 'name' => "Merienda One", 'variant' => ''), 
			array( 'name' => "Merienda", 'variant' => ''), 
			array( 'name' => "Merriweather Sans", 'variant' => ''), 
			array( 'name' => "Merriweather", 'variant' => ''), 
			array( 'name' => "Metal Mania", 'variant' => ''), 
			array( 'name' => "Metamorphous", 'variant' => ''), 
			array( 'name' => "Metrophobic", 'variant' => ''), 
			array( 'name' => "Michroma", 'variant' => ''), 
			array( 'name' => "Milonga", 'variant' => ''), 
			array( 'name' => "Miltonian Tattoo", 'variant' => ''), 
			array( 'name' => "Miltonian", 'variant' => ''), 
			array( 'name' => "Miniver", 'variant' => ''), 
			array( 'name' => "Miss Fajardose", 'variant' => ''), 
			array( 'name' => "Modern Antiqua", 'variant' => ''), 
			array( 'name' => "Molengo", 'variant' => ''), 
			array( 'name' => "Molle", 'variant' => ''), 
			array( 'name' => "Monda", 'variant' => ''), 
			array( 'name' => "Monofett", 'variant' => ''), 
			array( 'name' => "Monoton", 'variant' => ''), 
			array( 'name' => "Monsieur La Doulaise", 'variant' => ''), 
			array( 'name' => "Montaga", 'variant' => ''), 
			array( 'name' => "Montez", 'variant' => ''), 
			array( 'name' => "Montserrat Alternates", 'variant' => ''), 
			array( 'name' => "Montserrat Subrayada", 'variant' => ''), 
			array( 'name' => "Montserrat", 'variant' => ''), 
			array( 'name' => "Mountains of Christmas", 'variant' => ''), 
			array( 'name' => "Mouse Memoirs", 'variant' => ''), 
			array( 'name' => "Mr Bedfort", 'variant' => ''), 
			array( 'name' => "Mr Dafoe", 'variant' => ''), 
			array( 'name' => "Mr De Haviland", 'variant' => ''), 
			array( 'name' => "Mrs Saint Delafield", 'variant' => ''), 
			array( 'name' => "Mrs Sheppards", 'variant' => ''), 
			array( 'name' => "Muli", 'variant' => ''), 
			array( 'name' => "Mystery Quest", 'variant' => ''), 
			array( 'name' => "Neucha", 'variant' => ''), 
			array( 'name' => "Neuton", 'variant' => ''), 
			array( 'name' => "New Rocker", 'variant' => ''), 
			array( 'name' => "News Cycle", 'variant' => ''), 
			array( 'name' => "Niconne", 'variant' => ''), 
			array( 'name' => "Nixie One", 'variant' => ''), 
			array( 'name' => "Nobile", 'variant' => ''), 
			array( 'name' => "Norican", 'variant' => ''), 
			array( 'name' => "Nosifer", 'variant' => ''), 
			array( 'name' => "Nothing You Could Do", 'variant' => ''), 
			array( 'name' => "Noticia Text", 'variant' => ''), 
			array( 'name' => "Noto Sans", 'variant' => ''), 
			array( 'name' => "Noto Serif", 'variant' => ''), 
			array( 'name' => "Nova Cut", 'variant' => ''), 
			array( 'name' => "Nova Flat", 'variant' => ''), 
			array( 'name' => "Nova Mono", 'variant' => ''), 
			array( 'name' => "Nova Oval", 'variant' => ''), 
			array( 'name' => "Nova Round", 'variant' => ''), 
			array( 'name' => "Nova Script", 'variant' => ''), 
			array( 'name' => "Nova Slim", 'variant' => ''), 
			array( 'name' => "Nova Square", 'variant' => ''), 
			array( 'name' => "Numans", 'variant' => ''), 
			array( 'name' => "Nunito", 'variant' => ''), 
			array( 'name' => "Offside", 'variant' => ''), 
			array( 'name' => "Old Standard TT", 'variant' => ''), 
			array( 'name' => "Oldenburg", 'variant' => ''), 
			array( 'name' => "Oleo Script Swash Caps", 'variant' => ''), 
			array( 'name' => "Oleo Script", 'variant' => ''), 
			array( 'name' => "Open Sans Condensed", 'variant' => ''), 
			array( 'name' => "Open Sans", 'variant' => ''), 
			array( 'name' => "Oranienbaum", 'variant' => ''), 
			array( 'name' => "Orbitron", 'variant' => ''), 
			array( 'name' => "Oregano", 'variant' => ''), 
			array( 'name' => "Orienta", 'variant' => ''), 
			array( 'name' => "Original Surfer", 'variant' => ''), 
			array( 'name' => "Oswald", 'variant' => ''),
			array( 'name' => "Over the Rainbow", 'variant' => ''), 
			array( 'name' => "Overlock SC", 'variant' => ''), 
			array( 'name' => "Overlock", 'variant' => ''), 
			array( 'name' => "Ovo", 'variant' => ''), 
			array( 'name' => "Oxygen Mono", 'variant' => ''), 
			array( 'name' => "Oxygen", 'variant' => ''), 
			array( 'name' => "Pacifico", 'variant' => ''), 
			array( 'name' => "Paprika", 'variant' => ''), 
			array( 'name' => "Parisienne", 'variant' => ''), 
			array( 'name' => "Passero One", 'variant' => ''), 
			array( 'name' => "Passion One", 'variant' => ''), 
			array( 'name' => "Pathway Gothic One", 'variant' => ''), 
			array( 'name' => "Patrick Hand SC", 'variant' => ''), 
			array( 'name' => "Patrick Hand", 'variant' => ''), 
			array( 'name' => "Patua One", 'variant' => ''), 
			array( 'name' => "Paytone One", 'variant' => ''), 
			array( 'name' => "Peralta", 'variant' => ''), 
			array( 'name' => "Permanent Marker", 'variant' => ''), 
			array( 'name' => "Petit Formal Script", 'variant' => ''), 
			array( 'name' => "Petrona", 'variant' => ''), 
			array( 'name' => "Philosopher", 'variant' => ''), 
			array( 'name' => "Piedra", 'variant' => ''), 
			array( 'name' => "Pinyon Script", 'variant' => ''), 
			array( 'name' => "Pirata One", 'variant' => ''), 
			array( 'name' => "Plaster", 'variant' => ''), 
			array( 'name' => "Play", 'variant' => ''), 
			array( 'name' => "Playball", 'variant' => ''),
			array( 'name' => "Playfair Display SC", 'variant' => ''), 
			array( 'name' => "Playfair Display", 'variant' => ''), 
			array( 'name' => "Podkova", 'variant' => ''), 
			array( 'name' => "Poiret One", 'variant' => ''), 
			array( 'name' => "Poller One", 'variant' => ''), 
			array( 'name' => "Poly", 'variant' => ''), 
			array( 'name' => "Pompiere", 'variant' => ''), 
			array( 'name' => "Pontano Sans", 'variant' => ''), 
			array( 'name' => "Port Lligat Sans", 'variant' => ''), 
			array( 'name' => "Port Lligat Slab", 'variant' => ''), 
			array( 'name' => "Prata", 'variant' => ''), 
			array( 'name' => "Press Start 2P", 'variant' => ''), 
			array( 'name' => "Princess Sofia", 'variant' => ''), 
			array( 'name' => "Prociono", 'variant' => ''), 
			array( 'name' => "Prosto One", 'variant' => ''), 
			array( 'name' => "PT Mono", 'variant' => ''), 
			array( 'name' => "PT Sans Caption", 'variant' => ''), 
			array( 'name' => "PT Sans Narrow", 'variant' => ''), 
			array( 'name' => "PT Sans", 'variant' => ''), 
			array( 'name' => "PT Serif Caption", 'variant' => ''), 
			array( 'name' => "PT Serif", 'variant' => ''), 
			array( 'name' => "Puritan", 'variant' => ''), 
			array( 'name' => "Purple Purse", 'variant' => ''), 
			array( 'name' => "Quando", 'variant' => ''), 
			array( 'name' => "Quantico", 'variant' => ''),
			array( 'name' => "Quattrocento Sans", 'variant' => ''), 
			array( 'name' => "Quattrocento", 'variant' => ''), 
			array( 'name' => "Questrial", 'variant' => ''), 
			array( 'name' => "Quicksand", 'variant' => ''), 
			array( 'name' => "Quintessential", 'variant' => ''), 
			array( 'name' => "Qwigley", 'variant' => ''),
			array( 'name' => "Racing Sans One", 'variant' => ''), 
			array( 'name' => "Radley", 'variant' => ''), 
			array( 'name' => "Raleway Dots", 'variant' => ''), 
			array( 'name' => "Raleway", 'variant' => ''),
			array( 'name' => "Rambla", 'variant' => ''), 
			array( 'name' => "Rammetto One", 'variant' => ''), 
			array( 'name' => "Ranchers", 'variant' => ''), 
			array( 'name' => "Rancho", 'variant' => ''),
			array( 'name' => "Rationale", 'variant' => ''), 
			array( 'name' => "Redressed", 'variant' => ''),
			array( 'name' => "Reenie Beanie", 'variant' => ''),
			array( 'name' => "Revalia", 'variant' => ''), 
			array( 'name' => "Ribeye Marrow", 'variant' => ''),
			array( 'name' => "Ribeye", 'variant' => ''),
			array( 'name' => "Righteous", 'variant' => ''),
			array( 'name' => "Risque", 'variant' => ''),
			array( 'name' => "Roboto Condensed", 'variant' => ''),
			array( 'name' => "Roboto Slab", 'variant' => ''), 
			array( 'name' => "Roboto", 'variant' => ''),
			array( 'name' => "Rochester", 'variant' => ''), 
			array( 'name' => "Rock Salt", 'variant' => ''),
			array( 'name' => "Rokkitt", 'variant' => ''), 
			array( 'name' => "Romanesco", 'variant' => ''),
			array( 'name' => "Ropa Sans", 'variant' => ''),
			array( 'name' => "Rosario", 'variant' => ''), 
			array( 'name' => "Rosarivo", 'variant' => ''),
			array( 'name' => "Rouge Script", 'variant' => ''),
			array( 'name' => "Ruda", 'variant' => ''),
			array( 'name' => "Rufina", 'variant' => ''),
			array( 'name' => "Ruge Boogie", 'variant' => ''),
			array( 'name' => "Ruluko", 'variant' => ''),
			array( 'name' => "Rum Raisin", 'variant' => ''),
			array( 'name' => "Ruslan Display", 'variant' => ''),
			array( 'name' => "Russo One", 'variant' => ''),
			array( 'name' => "Ruthie", 'variant' => ''),
			array( 'name' => "Rye", 'variant' => ''),
			array( 'name' => "Sacramento", 'variant' => ''),
			array( 'name' => "Sail", 'variant' => ''),
			array( 'name' => "Salsa", 'variant' => ''),
			array( 'name' => "Sanchez", 'variant' => ''),
			array( 'name' => "Sancreek", 'variant' => ''), 
			array( 'name' => "Sansita One", 'variant' => ''),
			array( 'name' => "Sarina", 'variant' => ''), 
			array( 'name' => "Satisfy", 'variant' => ''), 
			array( 'name' => "Scada", 'variant' => ''), 
			array( 'name' => "Schoolbell", 'variant' => ''), 
			array( 'name' => "Seaweed Script", 'variant' => ''), 
			array( 'name' => "Sevillana", 'variant' => ''), 
			array( 'name' => "Seymour One", 'variant' => ''), 
			array( 'name' => "Shadows Into Light Two", 'variant' => ''), 
			array( 'name' => "Shadows Into Light", 'variant' => ''), 
			array( 'name' => "Shanti", 'variant' => ''), 
			array( 'name' => "Share Tech Mono", 'variant' => ''), 
			array( 'name' => "Share Tech", 'variant' => ''), 
			array( 'name' => "Share", 'variant' => ''), 
			array( 'name' => "Shojumaru", 'variant' => ''), 
			array( 'name' => "Short Stack", 'variant' => ''),  
			array( 'name' => "Sigmar One", 'variant' => ''), 
			array( 'name' => "Signika Negative", 'variant' => ''), 
			array( 'name' => "Signika", 'variant' => ''), 
			array( 'name' => "Simonetta", 'variant' => ''), 
			array( 'name' => "Sintony", 'variant' => ''), 
			array( 'name' => "Sirin Stencil", 'variant' => ''), 
			array( 'name' => "Six Caps", 'variant' => ''), 
			array( 'name' => "Skranji", 'variant' => ''), 
			array( 'name' => "Slackey", 'variant' => ''), 
			array( 'name' => "Smokum", 'variant' => ''), 
			array( 'name' => "Smythe", 'variant' => ''), 
			array( 'name' => "Sniglet", 'variant' => ''), 
			array( 'name' => "Snippet", 'variant' => ''), 
			array( 'name' => "Snowburst One", 'variant' => ''), 
			array( 'name' => "Sofadi One", 'variant' => ''), 
			array( 'name' => "Sofia", 'variant' => ''), 
			array( 'name' => "Sonsie One", 'variant' => ''), 
			array( 'name' => "Sorts Mill Goudy", 'variant' => ''), 
			array( 'name' => "Source Code Pro", 'variant' => ''), 
			array( 'name' => "Source Sans Pro", 'variant' => ''), 
			array( 'name' => "Special Elite", 'variant' => ''), 
			array( 'name' => "Spicy Rice", 'variant' => ''), 
			array( 'name' => "Spinnaker", 'variant' => ''), 
			array( 'name' => "Spirax", 'variant' => ''), 
			array( 'name' => "Squada One", 'variant' => ''), 
			array( 'name' => "Stalemate", 'variant' => ''), 
			array( 'name' => "Stalinist One", 'variant' => ''), 
			array( 'name' => "Stardos Stencil", 'variant' => ''), 
			array( 'name' => "Stint Ultra Condensed", 'variant' => ''), 
			array( 'name' => "Stint Ultra Expanded", 'variant' => ''), 
			array( 'name' => "Stoke", 'variant' => ''), 
			array( 'name' => "Strait", 'variant' => ''), 
			array( 'name' => "Sue Ellen Francisco", 'variant' => ''), 
			array( 'name' => "Sunshiney", 'variant' => ''),
			array( 'name' => "Supermercado One", 'variant' => ''), 
			array( 'name' => "Swanky and Moo Moo", 'variant' => ''), 
			array( 'name' => "Syncopate", 'variant' => ''), 
			array( 'name' => "Tangerine", 'variant' => ''), 
			array( 'name' => "Tauri", 'variant' => ''), 
			array( 'name' => "Telex", 'variant' => ''), 
			array( 'name' => "Tenor Sans", 'variant' => ''), 
			array( 'name' => "Text Me One", 'variant' => ''), 
			array( 'name' => "The Girl Next Door", 'variant' => ''), 
			array( 'name' => "Tienne", 'variant' => ''), 
			array( 'name' => "Tinos", 'variant' => ''), 
			array( 'name' => "Titan One", 'variant' => ''), 
			array( 'name' => "Titillium Web", 'variant' => ''), 
			array( 'name' => "Trade Winds", 'variant' => ''), 
			array( 'name' => "Trocchi", 'variant' => ''), 
			array( 'name' => "Trochut", 'variant' => ''), 
			array( 'name' => "Trykker", 'variant' => ''), 
			array( 'name' => "Tulpen One", 'variant' => ''), 
			array( 'name' => "Ubuntu Condensed", 'variant' => ''), 
			array( 'name' => "Ubuntu Mono", 'variant' => ''), 
			array( 'name' => "Ubuntu", 'variant' => ''), 
			array( 'name' => "Ultra", 'variant' => ''), 
			array( 'name' => "Uncial Antiqua", 'variant' => ''), 
			array( 'name' => "Underdog", 'variant' => ''), 
			array( 'name' => "Unica One", 'variant' => ''), 
			array( 'name' => "UnifrakturCook", 'variant' => ''), 
			array( 'name' => "UnifrakturMaguntia", 'variant' => ''), 
			array( 'name' => "Unkempt", 'variant' => ''), 
			array( 'name' => "Unlock", 'variant' => ''), 
			array( 'name' => "Unna", 'variant' => ''), 
			array( 'name' => "Vampiro One", 'variant' => ''), 
			array( 'name' => "Varela Round", 'variant' => ''), 
			array( 'name' => "Varela", 'variant' => ''), 
			array( 'name' => "Vast Shadow", 'variant' => ''), 
			array( 'name' => "Vibur", 'variant' => ''), 
			array( 'name' => "Vidaloka", 'variant' => ''), 
			array( 'name' => "Viga", 'variant' => ''), 
			array( 'name' => "Voces", 'variant' => ''), 
			array( 'name' => "Volkhov", 'variant' => ''), 
			array( 'name' => "Vollkorn", 'variant' => ''), 
			array( 'name' => "Voltaire", 'variant' => ''), 
			array( 'name' => "VT323", 'variant' => ''), 
			array( 'name' => "Waiting for the Sunrise", 'variant' => ''), 
			array( 'name' => "Wallpoet", 'variant' => ''), 
			array( 'name' => "Walter Turncoat", 'variant' => ''), 
			array( 'name' => "Warnes", 'variant' => ''), 
			array( 'name' => "Wellfleet", 'variant' => ''), 
			array( 'name' => "Wendy One", 'variant' => ''), 
			array( 'name' => "Wire One", 'variant' => ''), 
			array( 'name' => "Yanone Kaffeesatz", 'variant' => ''), 
			array( 'name' => "Yellowtail", 'variant' => ''), 
			array( 'name' => "Yeseva One", 'variant' => ''), 
			array( 'name' => "Yesteryear", 'variant' => ''), 
			array( 'name' => "Zeyada", 'variant' => '')				
);

if ( ! function_exists( 'eff_google_webfonts' ) ) {
	function eff_google_webfonts() {
		global $google_fonts;
		$fonts = 'Droid Serif|PT Serif|';
		$output = '';

		// Setup effective Options array
		global $smof_data;

		// Go through the options
		if ( !empty($smof_data) ) {
			foreach ( $smof_data as $option ) {
	
				if ( is_array($option) && isset($option['face']) ) {
					foreach ($google_fonts as $font) {
						if ( $option['face'] == $font['name'] AND !strstr($fonts, $font['name']) ) {
							$fonts .= $font['name'].$font['variant']."|";
						} 
					} 
				} 
			} 

			// Output google font css in header
			if ( $fonts ) {
				$fonts = str_replace( " ","+",$fonts);
				$output .= "\n<!-- Google Webfonts -->\n";
				$output .= '<link href="http'. ( is_ssl() ? 's' : '' ) .'://fonts.googleapis.com/css?family=' . $fonts .'" rel="stylesheet" type="text/css" />'."\n";
				$output = str_replace( '|"','"',$output);

				echo $output;
			}
		}
	}
}

?>