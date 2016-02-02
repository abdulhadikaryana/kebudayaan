<?php
/**
 * OrbitNews functions and definitions
 *
 * @package OrbitNews
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 615;
}

if (!function_exists('orbitnews_setup')): 
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */ 
function orbitnews_setup() {
	
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on OrbitNews, use a find and replace
	 * to change 'orbitnews' to the name of your theme in all the template files
	 */
	load_theme_textdomain('orbitnews', get_template_directory() . '/languages');
	
	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support('automatic-feed-links');
	
	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	
	add_theme_support('post-thumbnails');
	
	set_post_thumbnail_size(620, 350, true);
	add_image_size('full-thumb', 935, 526, true);
	add_image_size('post-thumb', 300, 220, true);
	add_image_size('carousel-thumb', 300, 250, true);
	add_image_size('medium-thumb', 455, 334, true);
	add_image_size('small-thumb', 200, 160, true);
	add_image_size('widget-thumb', 60, 60, true);
	add_image_size('home-small-thumb', 50, 50, true);

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus(array(
		'top_menu' => __('Top Menu', 'orbitnews'),
		'main_menu' => __('Main Menu', 'orbitnews')
	));
	
	/**
	 * Enable support for Post Formats
	 */
	add_theme_support('post-formats', array(
		'audio',
		'video',
		'gallery'
	));
	
	/**
	 * Setup the WordPress core custom background feature.
	 */
	add_theme_support( 'custom-background', array() );

	/**
	 * Orbit News doesn't use Wordpress Custom Headers
	 */
	$defaults = array(
		'default-image'          => '',
		'random-default'         => false,
		'width'                  => 0,
		'height'                 => 0,
		'flex-height'            => false,
		'flex-width'             => false,
		'default-text-color'     => '',
		'header-text'            => true,
		'uploads'                => true,
		'wp-head-callback'       => '',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
	);
	add_theme_support( 'custom-header', $defaults );
}
endif; // orbitnews_setup
add_action('after_setup_theme', 'orbitnews_setup');

/**
 *  Display edit button for admin 
 */
function orbitnews_admin_edit() {
	if ( current_user_can('update_themes') && !(is_front_page()) && is_singular() && current_user_can('edit_pages') && current_user_can('edit_posts')  ) {
		edit_post_link( '', '<span class="edit-link" title="Edit Post/Page">', '</span>');
	}
}
add_action('wp_footer', 'orbitnews_admin_edit'); // Add Edit Post Icon for Admins

/**
 * WordPress Root Directory
 */
function get_wp_path() {
	return str_replace( '\\', '/', ABSPATH );
}

/**
 * Add Favicon link to theme header
 */
function orbitnews_show_favicon() {
	$favicon_url = ot_get_option( 'orn_favicon' );
	if ( empty( $favicon_url ) ) {
		return false;
	}
	
	$favicon_dir = str_replace( get_site_url(), get_wp_path(), $favicon_url );
	if ( file_exists( $favicon_dir ) ) {
		echo '<link rel="shortcut icon" href="' . $favicon_url . '">';
	} else {
		echo '<!-- No FavIcons Found -->';
	}
}
add_action('wp_head', 'orbitnews_show_favicon'); 

/**
 * Enqueue html5 script in head section for old browsers
 */
function orbitnews_html5_js() { ?>
<!--[if lt IE 9]>
<script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?php }
add_action( 'wp_head', 'orbitnews_html5_js' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function orbitnews_widgets_init() {
	
	// Require Widgets file
	require get_template_directory() . '/inc/widgets/widgets.php';
	
	// Register Orbit News Widgets
	register_widget( 'Flickr_Widget' );
	register_widget( 'Tweets_Widget' );
	register_widget( 'Ads_150_Widget' );
	register_widget( 'Facebook_Like_Widget' );
	register_widget( 'OrbitN_Tabs_Widget' );
	register_widget( 'OrbitN_Oembed_Video_Widget' );
	register_widget( 'OrbitN_Homepage_2col_Widget' );
	register_widget( 'OrbitN_Homepage_Ads_460_Widget' );
	register_widget( 'OrbitN_Homepage_Carousel_Widget' );

	// Register Orbit News Default Sidebars
    register_sidebar(array(
        'name' => "Default Sidebar",
        'id' => 'default-sidebar',
		"description" => "Default Sidebar. Go to theme options to create New Sidebars",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>'

    ));
    register_sidebar(array(
        "name" => "Home Widget Area",
		'id' => 'home_page',
        "description" => "Add Multiple Home Widgets to this Area",
        "before_title" => '',
        "after_title" => '',
        'before_widget' => '',
        'after_widget' => ''
    ));
    register_sidebar(array(
        "name" => "Footer Widget Area",
        'id' => 'footer',
		"description" => "Add no more than 3 Widgets to this Area",
        "before_title" => '<h3 class="widget-title">',
        "after_title" => "</h3>",
        'before_widget' => '<li id="%1$s" class="widget four column %2$s">',
        "after_widget" => "</li>"
    ));
	
	// Register Orbit News Custom Sidebars
		$orn_customsidebars = ot_get_option( 'orn_customsidebars' );
		if(!empty( $orn_customsidebars ) && count( $orn_customsidebars ) > 0) {  
		  foreach( $orn_customsidebars as $customsidebar) {  
			foreach( $customsidebar as $mysidebar ) {
			  register_sidebar( array(  
				  'name' => $mysidebar ,
				  'id' => sanitize_title($mysidebar),  
				  'before_widget' => '<li id="%1$s" class="widget %2$s">',
				  'after_widget' => '</li>',
				  'before_title' => '<h3 class="widget-title">',
				  'after_title' => '</h3>'
			  ) );  
			} 	// enc foreach $customsidebar
		  }  	// end foreach $orn_customsidebars
		} 		// end !empty( $orn_customsidebars )
}
add_action('widgets_init', 'orbitnews_widgets_init');

/**
 * Enqueue scripts and styles for FrontEnd
 */
function orbitnews_scripts() {
	// Enqueue Theme styles
	wp_enqueue_style('orbitnews-foundation', get_template_directory_uri() . '/layouts/foundation.css');    
	wp_enqueue_style('orbitnews-style', get_stylesheet_uri());
	wp_enqueue_style('orbitnews-responsive', get_template_directory_uri() . '/layouts/responsive.css');
	$theme_scheme =  ot_get_option( 'orn_color_scheme' );
	wp_enqueue_style('orbitnews-color-scheme', get_stylesheet_directory_uri() . '/layouts/colors/'. $theme_scheme .'.css'); 
	
	// Enqueue Google Fonts
	$font1 = ot_get_option('orn_font_body');
	$font2 = ot_get_option('orn_font_navigation');
	$font3 = ot_get_option('orn_font_title');
	$body_font    = ( ( $font1 == 'default') ? 'Open+Sans:400,700' : $font1 );
	$nav_font     = ( ( $font2 == 'default') ? 'Oswald:400,700'    : $font2 );
	$title_font   = ( ( $font3 == 'default') ? 'PT+Sans:400,700'   : $font3 );
	$google_fonts = array_unique( array( $body_font, $nav_font, $title_font ) );
	$protocol 	  = is_ssl() ? 'https' : 'http';
	foreach ( $google_fonts as $google_font ) {
		$font_name = str_replace( '+','-',strtolower(strtok($google_font, ":" )) );
		wp_enqueue_style("orbitnews-font-$font_name", "$protocol://fonts.googleapis.com/css?family=$google_font", array(), false, 'all');
	}
	
	// Enqueue Theme Scripts
	wp_enqueue_script("jquery");
	wp_enqueue_script("jquery-masonry");
	wp_enqueue_script('orbitnews-superfish', get_template_directory_uri() . '/js/jquery.superfish.js', array("jquery"), '', true); 
	wp_enqueue_script('orbitnews-flexslider', get_template_directory_uri() . '/js/jquery.flexslider.min.js ', array("jquery"), '2.1', true); 
	wp_enqueue_script('orbitnews-foundation-modern', get_template_directory_uri() . '/js/foundation/modernizr.foundation.js', array("jquery"), '2.6.2', true);
	wp_enqueue_script('orbitnews-foundation-app', get_template_directory_uri() . '/js/foundation/app.js', array("jquery"), '3.2.5', true);
	wp_enqueue_script('orbitnews-foundation-tabs', get_template_directory_uri() . '/js/foundation/jquery.foundation.tabs.js', array("jquery"), '3.2.5', true);
	wp_enqueue_script('orbitnews-foundation-alerts', get_template_directory_uri() . '/js/foundation/jquery.foundation.alerts.js', array("jquery"), '3.2.5', true);   
	wp_enqueue_script('orbitnews-foundation-accordion', get_template_directory_uri() . '/js/foundation/jquery.foundation.accordion.js', array("jquery"), '3.2.5', true);
	wp_enqueue_script('orbitnews-foundation-tooltips', get_template_directory_uri() . '/js/foundation/jquery.foundation.tooltips.js', array("jquery"), '2.0.2', true);
	wp_enqueue_script('orbitnews-foundation-forms', get_template_directory_uri() . '/js/foundation/jquery.foundation.forms.js', array("jquery"), '1.0', true);    
	wp_enqueue_script('orbitnews-colorbox', get_template_directory_uri() . '/js/jquery.colorbox.min.js', array("jquery"), '1.4.33', true);    
	wp_enqueue_script('orbitnews-jcarousel', get_template_directory_uri() . '/js/jcarousel.js', array("jquery"), '', true);   
	//wp_enqueue_script('orbitnews-masonry', get_template_directory_uri() . '/js/jquery.masonry.min.js', array("jquery"), '', true);  
	wp_enqueue_script('orbitnews-flickrfeed', get_template_directory_uri() . '/js/jflickrfeed.min.js', array("jquery"), '', true); 
	wp_enqueue_script('orbitnews-scripts', get_template_directory_uri() . '/js/script.js', array("jquery"), '', true);
	
	// Enqueue Maps script only for contact Page
	if ( is_page_template('templates/template-contact.php') ) {
		wp_enqueue_script('orbitnews-google-maps', 'http://maps.google.com/maps/api/js?sensor=false', array("jquery"), '', true);   
		wp_enqueue_script('orbitnews-gmap', get_template_directory_uri() . '/js/jquery.gmap.min.js', array("jquery"), '2.1.5', true );	
	}
	
    // Enqueue Comment Reply Script
    if	(is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }	 
}
add_action('wp_enqueue_scripts', 'orbitnews_scripts');

/**
 * Enqueue admin scripts on certain pages
 */	
function orbitnews_admin_scripts($hook) {
	// Admin script for meta boxes and option tree title fix
	if ( ( 'post-new.php' == $hook ) || ( 'post.php' == $hook ) || ( 'appearance_page_ot-theme-options' == $hook ) ) {
		wp_enqueue_script( 'orn_admin_script', get_template_directory_uri(). '/backend/js/orn_admin_script.js', array('jquery'), '', true);
	}
}
add_action('admin_enqueue_scripts', 'orbitnews_admin_scripts');

// Include TGM Plugin Activator
require get_template_directory() . '/inc/tgm-config.php';

// Shortcodes for this theme.
require get_template_directory() . '/inc/shortcodes.php';

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Custom functions that act independently of the theme templates.
require get_template_directory() . '/inc/extras.php';

// Customizer additions
require get_template_directory() . '/inc/customizer.php';

// Theme Update Notifier
require get_template_directory() . '/inc/update-notifier.php';

/**
 * Option-Tree
 */
// Optional: set 'ot_show_pages' filter to false.
// This will hide the settings & documentation pages.
add_filter( 'ot_show_pages', '__return_false' );
add_filter( 'ot_show_settings_import', '__return_true' );
add_filter( 'ot_show_settings_export', '__return_true' );
add_filter( 'ot_show_docs', '__return_true' );
add_filter( 'ot_show_options_ui', '__return_true' );

// Optional: set 'ot_show_new_layout' filter to false.
// This will hide the "New Layout" section on the Theme Options page.
add_filter( 'ot_show_new_layout', '__return_true' );

// Required: set 'ot_theme_mode' filter to true.
add_filter( 'ot_theme_mode', '__return_true' );

// Required: include OptionTree.
load_template( trailingslashit( get_template_directory() ) . 'option-tree/ot-loader.php' );

// Load OT Meta Boxes for Theme 
load_template( trailingslashit( get_template_directory() ) . 'inc/meta-boxes.php' );

// Load OptionTree Theme Options
load_template( trailingslashit( get_template_directory() ) . '/inc/theme-options.php' );

// Load OptionTree Theme Configs
require get_template_directory() . '/inc/ot.php';
