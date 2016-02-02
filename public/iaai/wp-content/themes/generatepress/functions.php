<?php
/**
 * Generate functions and definitions
 *
 * @package Generate
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 1000; /* pixels */
	
define( 'GENERATE_VERSION', '1.0.5');
define( 'GENERATE_URI', get_template_directory_uri() );
define( 'GENERATE_DIR', get_template_directory() );

add_action( 'after_setup_theme', 'generate_setup' );
if ( ! function_exists( 'generate_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function generate_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Generate, use a find and replace
	 * to change 'generate' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'generate', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	
	/**
	  * Allow shortcodes in widgets
	  */
	add_filter('widget_text', 'do_shortcode');

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'generate' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

}
endif; // generate_setup

/**
 * Set default options
 */
function generate_get_defaults()
{
	$generate_defaults = array(
		'container_width' => '1100',
		'header_layout_setting' => 'fluid-header',
		'center_header' => '',
		'center_nav' => '',
		'nav_layout_setting' => 'fluid-nav',
		'nav_position_setting' => 'nav-below-header',
		'content_layout_setting' => 'separate-containers',
		'layout_setting' => 'right-sidebar',
		'blog_layout_setting' => 'right-sidebar',
		'footer_layout_setting' => 'fluid-footer',
		'footer_widget_setting' => '3',
		'background_color' => '#efefef',
		'text_color' => '#3a3a3a',
		'link_color' => '#1e73be',
		'link_color_hover' => '#000000',
		'link_color_visited' => '',
	);
	
	return apply_filters( 'generate_option_defaults', $generate_defaults );
}

/**
 * Register widgetized area and update sidebar with default widgets
 */
add_action( 'widgets_init', 'generate_widgets_init' );
function generate_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Right Sidebar', 'generate' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget inner-padding %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Left Sidebar', 'generate' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget inner-padding %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Header', 'generate' ),
		'id'            => 'header',
		'before_widget' => '<aside id="%1$s" class="widget inner-padding %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget 1', 'generate' ),
		'id'            => 'footer-1',
		'before_widget' => '<aside id="%1$s" class="widget inner-padding %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget 2', 'generate' ),
		'id'            => 'footer-2',
		'before_widget' => '<aside id="%1$s" class="widget inner-padding %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget 3', 'generate' ),
		'id'            => 'footer-3',
		'before_widget' => '<aside id="%1$s" class="widget inner-padding %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget 4', 'generate' ),
		'id'            => 'footer-4',
		'before_widget' => '<aside id="%1$s" class="widget inner-padding %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}

/**
 * Enqueue scripts and styles
 */
add_action( 'wp_enqueue_scripts', 'generate_scripts' );
function generate_scripts() {

	// Generate stylesheets
	wp_enqueue_style( 'generate-style-grid', get_template_directory_uri() . '/css/structure.css', false, GENERATE_VERSION, 'all' );
	wp_enqueue_style( 'generate-style', get_template_directory_uri() . '/css/style.css', false, GENERATE_VERSION, 'all' );
	wp_enqueue_style( 'generate-child', get_stylesheet_uri(), false, GENERATE_VERSION, 'all' );
	wp_enqueue_style( 'superfish', get_template_directory_uri() . '/css/superfish.css', false, GENERATE_VERSION, 'all' );
	wp_enqueue_style( 'fontawesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' );

	// Generate scripts
	wp_enqueue_script( 'generate-navigation', get_template_directory_uri() . '/js/navigation.js', array(), GENERATE_VERSION, true );
	wp_enqueue_script( 'generate-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), GENERATE_VERSION, true );
	wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish.js', array('jquery'), GENERATE_VERSION, true );
	wp_enqueue_script( 'hoverIntent', get_template_directory_uri() . '/js/hoverIntent.js', array('superfish'), GENERATE_VERSION, true );
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), GENERATE_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'generate-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}

/**
 * Remove Open Sans from the front-end of the website
 * @since 0.1
 */
add_action('wp_enqueue_scripts', 'generate_remove_wp_open_sans');
function generate_remove_wp_open_sans() 
{
	wp_deregister_style( 'open-sans' );
	wp_register_style( 'open-sans', false );
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Element Classes
 */
require get_template_directory() . '/inc/element-classes.php';

/**
 * Load Metaboxes
 */
require get_template_directory() . '/inc/metaboxes.php';

/**
 * Load Options
 */
require get_template_directory() . '/inc/options.php';

/**
 * Load Addon options
 */
require get_template_directory() . '/inc/addons.php';


/**
 * Construct the sidebars
 * @since 0.1
 */
add_action('generate_sidebars','generate_contruct_sidebars');
function generate_contruct_sidebars()
{
	global $post;
	$generate_settings = get_option( 'generate_settings', generate_get_defaults() );
	$stored_meta = '';
	
	// Prevent PHP notices
	if ( isset( $post ) ) :
		$stored_meta = get_post_meta( $post->ID, '_generate-sidebar-layout-meta', true );
	endif;
	
	// If the metabox is set, use it instead of the global settings
	if ( '' !== $stored_meta ) :
		$generate_settings['layout_setting'] = $stored_meta;
	endif;
	
	// If we're on the blog, single post etc.. replace value with the blog layout setting
	if ( is_home() || 
		is_single() || 
		is_category() || 
		is_tag() || 
		is_archive() || 
		is_tax() || 
		is_author() || 
		is_date() || 
		is_search() || 
		is_attachment() ) :
		$generate_settings['layout_setting'] = null;
		$generate_settings['layout_setting'] = $generate_settings['blog_layout_setting'];
	endif;

	// When to show the right sidebar
	$rs = array('right-sidebar','both-sidebars','both-right','both-left');

	// When to show the left sidebar
	$ls = array('left-sidebar','both-sidebars','both-right','both-left');

	// If right sidebar, show it
	if ( in_array( $generate_settings['layout_setting'], $rs ) ) :
		get_sidebar(); 
	endif;

	// If left sidebar, show it
	if ( in_array( $generate_settings['layout_setting'], $ls ) ) :
		get_sidebar('left'); 
	endif;
}

add_action('generate_credits','generate_add_footer_info');
function generate_add_footer_info()
{
	?>
	<span class="copyright"><?php _e('Copyright','generate');?> &copy; <?php echo date('Y'); ?></span> <?php do_action('generate_copyright_line');?>
	<?php
}

add_action('generate_copyright_line','generate_add_login_attribution');
function generate_add_login_attribution()
{
	?>
	&#x000B7; <a href="<?php echo esc_url('http://generatepress.com');?>" target="_blank" title="<?php _e('GeneratePress','generate');?>"><?php _e('GeneratePress','generate');?></a> &#x000B7; <a href="http://wordpress.org" target="_blank" title="<?php _e('Proudly powered by WordPress','generate');?>"><?php _e('WordPress','generate');?></a> &#x000B7; <a href="<?php echo wp_login_url(); ?>" title="<?php _e('Log in','generate');?>"><?php _e('Log in','generate');?></a>
	<?php
}

/**
 * Generate the navigation based on settings
 * @since 0.1
 */
add_action( 'generate_after_header', 'generate_add_navigation_after_header', 5 );
function generate_add_navigation_after_header()
{
	$generate_settings = get_option( 'generate_settings', generate_get_defaults() );
	
	if ( 'nav-below-header' == $generate_settings['nav_position_setting'] ) :
		generate_navigation_position();
	endif;
	
}
add_action( 'generate_before_header', 'generate_add_navigation_before_header', 5 );
function generate_add_navigation_before_header()
{
	$generate_settings = get_option( 'generate_settings', generate_get_defaults() );
	
	if ( 'nav-above-header' == $generate_settings['nav_position_setting'] ) :
		generate_navigation_position();
	endif;
	
}
add_action( 'generate_inside_header', 'generate_add_navigation_float_right', 5 );
function generate_add_navigation_float_right()
{
	$generate_settings = get_option( 'generate_settings', generate_get_defaults() );
	
	if ( 'nav-float-right' == $generate_settings['nav_position_setting'] ) :
		generate_navigation_position();
	endif;
	
}
add_action( 'generate_before_right_sidebar', 'generate_add_navigation_before_right_sidebar', 5 );
function generate_add_navigation_before_right_sidebar()
{
	$generate_settings = get_option( 'generate_settings', generate_get_defaults() );
	
	if ( 'nav-right-sidebar' == $generate_settings['nav_position_setting'] ) :
		echo '<div class="gen-sidebar-nav">';
			generate_navigation_position();
		echo '</div>';
	endif;
	
}
add_action( 'generate_before_left_sidebar', 'generate_add_navigation_before_left_sidebar', 5 );
function generate_add_navigation_before_left_sidebar()
{
	$generate_settings = get_option( 'generate_settings', generate_get_defaults() );
	
	if ( 'nav-left-sidebar' == $generate_settings['nav_position_setting'] ) :
		echo '<div class="gen-sidebar-nav">';
			generate_navigation_position();
		echo '</div>';
	endif;
	
}
function generate_navigation_position()
{
	?>
	<nav itemtype="http://schema.org/SiteNavigationElement" itemscope="itemscope" id="site-navigation" role="navigation" <?php generate_navigation_class(); ?>>
		<div class="inside-navigation grid-container grid-parent">
			<h3 class="menu-toggle"><?php _e( 'Menu', 'generate' ); ?></h3>
			<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'generate' ); ?>"><?php _e( 'Skip to content', 'generate' ); ?></a></div>
				<div class="main-nav">
					<ul <?php generate_menu_class(); ?>>
						<?php 
						if ( has_nav_menu( 'primary' ) ) :
							wp_nav_menu( array( 
								'theme_location' => 'primary',
								'container_class' => 'main-nav',
								'menu_class' => 'menu',
								'items_wrap' => '%3$s'
							) );
						else :
							wp_list_pages('sort_column=menu_order&title_li=');
						endif;
						?>
					</ul>
				</div><!-- .main-nav -->
		</div><!-- .inside-navigation -->
	</nav><!-- #site-navigation -->
	<?php
}

/**
 * Generate the CSS in the <head> section using the Theme Customizer
 * @since 0.1
 */
add_action('wp_head','generate_base_css');
function generate_base_css()
{
	$generate_settings = get_option( 'generate_settings', generate_get_defaults() );
	$space = ' ';
	
	// Start the magic
	$visual_css = array (
	
		// Body CSS
		'body'  => array(
			'background-color' => $generate_settings['background_color'],
			'color' => $generate_settings['text_color']
		),
		
		// Link CSS
		'a, a:visited' => array(
			'color'				=> $generate_settings['link_color'],
			'text-decoration' 	=> 'none'
		),
		
		// Visited link color if specified
		'a:visited' => array(
			'color' 			=> ( !empty( $generate_settings['link_color_visited'] ) ) ? $generate_settings['link_color_visited'] : null,
		),
		
		// Link hover
		'a:hover' => array(
			'color' 			=> $generate_settings['link_color_hover'],
			'text-decoration' 	=> null
		),
		
		// Grid container
		'body .grid-container' => array(
			'max-width' => $generate_settings['container_width'] . 'px'
		),
		
		// Header 
		'.site-header' => array(
			'text-align' => ( !empty( $generate_settings['center_header'] ) ) ? 'center' : null
		),
		
		// Navigation 
		'.nav-below-header .main-navigation,
		.nav-above-header .main-navigation' => array(
			'text-align' => ( !empty( $generate_settings['center_nav'] ) ) ? 'center' : null
		),
		
		// Navigation 
		'.nav-below-header .main-navigation .menu > li, 
		.nav-below-header .main-navigation .sf-menu > li,
		.nav-above-header .main-navigation .menu > li, 
		.nav-above-header .main-navigation .sf-menu > li' => array(
			'float' => ( !empty( $generate_settings['center_nav'] ) ) ? 'none' : null,
			'display' => ( !empty( $generate_settings['center_nav'] ) ) ? 'inline-block' : null,
			'margin-right' => ( !empty( $generate_settings['center_nav'] ) ) ? '-4px' : null,
			'*display' => ( !empty( $generate_settings['center_nav'] ) ) ? 'inline' : null,
			'*zoom' => ( !empty( $generate_settings['center_nav'] ) ) ? '1' : null,
		),
		
	);
	
	// Output the above CSS
	$output = '';
	foreach($visual_css as $k => $properties) {
		if(!count($properties))
			continue;

		$temporary_output = $k . ' {';
		$elements_added = 0;

		foreach($properties as $p => $v) {
			if(empty($v))
				continue;

			$elements_added++;
			$temporary_output .= $p . ': ' . $v . '; ';
		}

		$temporary_output .= "}";

		if($elements_added > 0)
			$output .= $temporary_output;
	}
	?>
<!-- Generate CSS -->
<style type="text/css">
<?php 
$output = str_replace(array("\r", "\n"), '', $output);
echo $output; ?>
<?php do_action('generate_head_css') . '\n'; ?> 
</style>
<?php
}

/**
 * Add page header using featured image if Page Header addon isn't installed
 * @since 1.0.2
 */
add_action('generate_after_header','generate_featured_page_header', 10);
function generate_featured_page_header()
{
	if ( function_exists('generate_page_header') )
		return;

	if ( ( is_single() || is_page() ) && !is_attachment() ) :
		
		global $post;
		$page_header_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID, 'full') );
		$page_header_image_width = 1200;
		
		if ( !empty($page_header_image) ) :
			echo '<div class="page-header-image grid-container grid-parent">';
				echo '<img src="' . $page_header_image . '" width="' . $page_header_image_width . '" alt="" />';
			echo '</div>';
		endif;
	
	endif;
}