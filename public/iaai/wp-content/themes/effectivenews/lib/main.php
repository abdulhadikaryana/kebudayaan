<?php
/*------------------------------------------*/
/*	Theme constants
/*------------------------------------------*/
define ('EFF_URI' , get_template_directory_uri());
define ('EFF_DIR' , get_template_directory());
define ('EFF_JS' , EFF_URI . '/js');
define ('EFF_CSS' , EFF_URI . '/css');
define ('EFF_IMG' , EFF_URI . '/images');
define ('EFF_FW' , EFF_DIR . '/lib');
define ('EFF_FUN', EFF_FW . '/functions');
define ('EFF_WIDGETS', EFF_FW . '/widgets');
define ('EFF_SC', EFF_FW . '/shortcodes');
define ('EFF_TINY', EFF_FW . '/tinymce');
define ('EFF_ADMIN_CSS' , EFF_URI . '/lib/css');

require EFF_FW   . '/social/social-bartender.php';
require EFF_FW   . '/update_notifier.php';
/*------------------------------------------*/
/*	Theme Functions
/*------------------------------------------*/
    foreach ( glob( EFF_FUN . '/*.php' ) as $file )
	{
		require_once $file;
	}
/*------------------------------------------*/
/*	Shortcodes & tinymce
/*------------------------------------------*/
    require EFF_SC   . '/shortcodes.php';
    
    foreach ( glob( EFF_TINY . '/*.php' ) as $file )
	{
		require_once $file;
	}
	
/*------------------------------------------*/
/*	Theme Widgets
/*------------------------------------------*/
    foreach ( glob( EFF_WIDGETS . '/*.php' ) as $file )
	{
		require_once $file;
	}
/*------------------------------------------*/
/*	Theme Translation
/*------------------------------------------*/
load_theme_textdomain( 'framework', get_template_directory().'/languages' );
 
$locale = get_locale();
$locale_file = get_template_directory()."/languages/$locale.php";
if ( is_readable($locale_file) )
	require_once($locale_file);
/*------------------------------------------*/
/*	Theme Menus
/*------------------------------------------*/
if ( function_exists( 'register_nav_menu' ) ) {
  register_nav_menus(
   array(
    'main'   => __('Main', 'framework'),
    'topnav'   => __('Top Nav', 'framework'),
   )
  );
 }
/*------------------------------------------*/
/*	Theme Support
/*------------------------------------------*/
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'automatic-feed-links' );
add_theme_support('bbpress');
add_theme_support( 'woocommerce' );
add_filter( 'use_default_gallery_style', '__return_false' );
/*------------------------------------------*/
/*	Theme Metaboxes
/*------------------------------------------*/
require_once  EFF_FW . '/metaboxes/meta-box.php';
require_once  EFF_FW . '/metaboxes/meta.php';
/*------------------------------------------*/
/*	Theme Admin
/*------------------------------------------*/
require EFF_FW   . '/admin/index.php';
/*------------------------------------------*/
/*	Theme Sidebars
/*------------------------------------------*/
if ( function_exists('register_sidebar') ) {

      register_sidebar(array(
	'name' => __('Main sidebar', 'framewrok'),
        'id' => 'main-sidebar',
	'description' => 'main sidebar.',
	'before_widget' => '<div class="widget %2$s">',
	'after_widget' => '</div></section></div>',
	'before_title' => '<div class="widget_title"><h2>',
	'after_title' => '</h2><span></span></div>
			<section class="section_widget"><div class="widget_inner">'
      ));
if(eff_option('sidebar') == '3cleft' || eff_option('sidebar') == '3cright') { 
      register_sidebar(array(
	'name' => __('Secondary sidebar', 'framewrok'),
        'id' => 'secondary-sidebar',
	'description' => 'secondary sidebar.',
	'before_widget' => '<div class="widget %2$s">',
	'after_widget' => '</div></section></div>',
	'before_title' => '<div class="widget_title"><h2>',
	'after_title' => '</h2><span></span></div>
			<section class="section_widget"><div class="widget_inner">'
      ));
}
if ( class_exists( 'Woocommerce' ) ) {
      register_sidebar(array(
	'name' => __('WooCommerce sidebar', 'framewrok'),
        'id' => 'woocomerce_sidebar',
	'description' => 'woocommerce sidebar.',
	'before_widget' => '<div class="widget %2$s">',
	'after_widget' => '</div></section></div>',
	'before_title' => '<div class="widget_title"><h2>',
	'after_title' => '</h2><span></span></div>
			<section class="section_widget"><div class="widget_inner">'
      ));
}
// footers
      register_sidebar(array(
	'name' => __('Footer 1', 'framewrok'),
        'id' => 'footer1',
	'description' => 'Footer1 sidebar.',
	'before_widget' => '<div class="widget">',
	'after_widget' => '</div>',
	'before_title' => '<div class="widget_title"><h2>',
	'after_title' => '</h2></div>'
      ));

      register_sidebar(array(
	'name' => __('Footer 2', 'framewrok'),
        'id' => 'footer2',
	'description' => 'Footer2 sidebar.',
	'before_widget' => '<div class="widget">',
	'after_widget' => '</div>',
	'before_title' => '<div class="widget_title"><h2>',
	'after_title' => '</h2></div>'
      ));

      register_sidebar(array(
	'name' => __('Footer 3', 'framewrok'),
        'id' => 'footer3',
	'description' => 'Footer3 sidebar.',
	'before_widget' => '<div class="widget">',
	'after_widget' => '</div>',
	'before_title' => '<div class="widget_title"><h2>',
	'after_title' => '</h2></div>'
      ));

      register_sidebar(array(
	'name' => __('Footer 4', 'framewrok'),
        'id' => 'footer4',
	'description' => 'Footer4 sidebar.',
	'before_widget' => '<div class="widget">',
	'after_widget' => '</div>',
	'before_title' => '<div class="widget_title"><h2>',
	'after_title' => '</h2></div>'
      ));
      
      register_sidebar(array(
	'name' => __('Footer 5', 'framewrok'),
        'id' => 'footer5',
	'description' => 'Footer5 sidebar.',
	'before_widget' => '<div class="widget">',
	'after_widget' => '</div>',
	'before_title' => '<div class="widget_title"><h2>',
	'after_title' => '</h2></div>'
      ));
      
      register_sidebar(array(
	'name' => __('Footer 6', 'framewrok'),
        'id' => 'footer6',
	'description' => 'Footer6 sidebar.',
	'before_widget' => '<div class="widget">',
	'after_widget' => '</div>',
	'before_title' => '<div class="widget_title"><h2>',
	'after_title' => '</h2></div>'
      ));
 }
/*------------------------------------------*/
/*	Theme Enhancments
/*------------------------------------------*/
//shortcodes in widgets
add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode', 11);
// Quick Tags
add_action('admin_print_scripts', 'my_custom_quicktags');
function my_custom_quicktags() {
	wp_enqueue_script(
		'my_custom_quicktags',
		EFF_URI . '/lib/quicktags.js',
		array('quicktags')
	);
}
/*------------------------------------------*/
/*	Theme Style
/*------------------------------------------*/
function eff_create_stylesheet() {
    $content = "\t";
    $content .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"";
    $content .= get_bloginfo('stylesheet_url');
    $content .= "\" />";
    $content .= "\n\n";
    echo apply_filters('eff_create_stylesheet', $content);
    if(eff_option('responsive') == true) {
	wp_enqueue_style('responsive');
    }
    if(eff_option('t_style') == 'dark') {
	wp_enqueue_style('dark');
    }
    if(eff_option('skin') == 'peru') {
	wp_enqueue_style('peru');
    } elseif(eff_option('skin') == 'orang') {
	wp_enqueue_style('orang');
    } elseif(eff_option('skin') == 'blue') {
	wp_enqueue_style('blue');
    } elseif(eff_option('skin') == 'green') {
	wp_enqueue_style('green');
    } elseif(eff_option('skin') == 'pink') {
	wp_enqueue_style('pink');
    } elseif(eff_option('skin') == 'gray') {
	wp_enqueue_style('gray');
    }
    if(!is_front_page()) {
	wp_enqueue_style('sccss');
	wp_enqueue_style('prettyphoto');
	}
    if(!is_front_page()) {
	wp_enqueue_script('jquery-ui-accordion');
	wp_enqueue_script('tabset');
	wp_enqueue_script('prettyphoto');
	wp_enqueue_script('post');
    }
    if(is_single() && eff_option('meta_resize')) {
	wp_enqueue_script('resize');
	}
    if(is_front_page() && eff_option('blog_style') == 'masonry') {
	wp_enqueue_script( 'masonry' );
	}
    require EFF_FW   . '/custom_css.php';
}
add_action('wp_head', 'eff_create_stylesheet', 1, 1);

// bg slider
function eff_bg_slider() { ?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
		$(".background").backstretch([
		<?php
		$comma = false;
		$slides = eff_option('body_bg_sl');
		foreach ($slides as $slide) {
			if ($comma) echo ","; else $comma=true;
			echo '"'.$slide['url'].'"';
		}
		?>,
		], {duration: 4000, fade: 750},"next");
		});
	</script>
<?php }
if(eff_option('slide_bg') == true) { 
add_action('wp_head', 'eff_bg_slider');
}

// Image effect
function eff_img_jquery() { ?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
		$(function() {
			$('.post_thumb ,.post_thumb2 ,.flickr_badge_image').on('inview', function(event, isInView) {
			if (isInView) {
				$(this).addClass('inview');
			}
			});
		});
	});
	</script>
	<style>
		.post_thumb2 img, .post_thumb img {
			opacity: 0;
		}
	</style>
<?php }
if(eff_option('img_effect') == true) { 
add_action('wp_head', 'eff_img_jquery');
}
/*------------------------------------------*/
/*	SEO
/*------------------------------------------*/
function eff_seo() {
	if(eff_option('meta_desc') == true) { 
	eff_meta_desc();
	}
	if( is_home() || is_front_page() ) { ?>
	<meta name="keywords" content="<?php echo eff_option('keywords'); ?>" />
	<meta name="description" content="<?php bloginfo('description'); ?>" />
	<?php
	} elseif (is_single() || is_page() ) {
	csv_tags();
	}
}
if(eff_option('eff_seo') == true) { 
add_action('wp_head', 'eff_seo');
}

// Load Facebook open graph
if(eff_option('fb_og') == true) {
add_action( 'wp_head', 'fb_og' );
}

// Load Google Fonts 
add_action( 'wp_head', 'eff_google_webfonts' );