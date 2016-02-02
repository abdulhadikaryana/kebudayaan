<?php
/*
 WARNING: This is a core Generate file. DO NOT edit
 this file under any circumstances. Please do all modifications
 in the form of a child theme.
 */

/**
 * Manages addon functionality if they aren't installed
 *
 * This file is a core Generate file and should not be edited.
 *
 * @package  WordPress
 * @author   Thomas Usborne
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.generatepress.com
 */

/**
 * If Generate Typography isn't activated, set the defaults
 * @since 1.0.5
 */
if ( !function_exists('generate_get_default_fonts') && !function_exists('generate_font_css') && !function_exists('generate_display_google_fonts') ) :
	/**
	 * Set default options
	 */
	function generate_get_default_fonts()
	{
		$generate_font_defaults = array(
			'font_body' => 'Arial, Helvetica, sans-serif',
			'body_font_weight' => 'normal',
			'body_font_transform' => 'none',
			'body_font_size' => '15',
			'font_site_title' => 'Roboto:100,100italic,300,300italic,regular,italic,500,500italic,700,700italic,900,900italic',
			'site_title_font_weight' => 'bold',
			'site_title_font_transform' => 'none',
			'site_title_font_size' => '45',
			'font_site_tagline' => 'Roboto:100,100italic,300,300italic,regular,italic,500,500italic,700,700italic,900,900italic',
			'site_tagline_font_weight' => 'normal',
			'site_tagline_font_transform' => 'none',
			'site_tagline_font_size' => '15',
			'font_navigation' => 'Roboto:100,100italic,300,300italic,regular,italic,500,500italic,700,700italic,900,900italic',
			'navigation_font_weight' => 'normal',
			'navigation_font_transform' => 'none',
			'navigation_font_size' => '15',
			'font_widget_title' => 'Roboto:100,100italic,300,300italic,regular,italic,500,500italic,700,700italic,900,900italic',
			'widget_title_font_weight' => 'normal',
			'widget_title_font_transform' => 'none',
			'widget_title_font_size' => '20',
			'font_heading_1' => 'Roboto:100,100italic,300,300italic,regular,italic,500,500italic,700,700italic,900,900italic',
			'heading_1_weight' => '300',
			'heading_1_transform' => 'none',
			'heading_1_font_size' => '40',
			'font_heading_2' => 'Roboto:100,100italic,300,300italic,regular,italic,500,500italic,700,700italic,900,900italic',
			'heading_2_weight' => '300',
			'heading_2_transform' => 'none',
			'heading_2_font_size' => '30',
			'font_heading_3' => 'inherit',
			'heading_3_weight' => 'normal',
			'heading_3_transform' => 'none',
			'heading_3_font_size' => '20',
			'font_heading_4' => 'inherit',
			'heading_4_weight' => 'normal',
			'heading_4_transform' => 'none',
			'heading_4_font_size' => '15',
		);
		
		return apply_filters( 'generate_font_option_defaults', $generate_font_defaults );
	}
	/**
	 * Generate the CSS in the <head> section using the Theme Customizer
	 * @since 0.1
	 */
	add_action('generate_head_css','generate_font_css');
	function generate_font_css()
	{
		$generate_settings = get_option( 'generate_settings', generate_get_default_fonts() );
		$space = ' ';
		
		// Start the magic
		$visual_css = array (
		
			// Main title font
			'body' => array(
				'font-family' => current(explode(':', $generate_settings['font_body'])),
				'font-weight' => $generate_settings['body_font_weight'],
				'text-transform' => $generate_settings['body_font_transform'],
				'font-size' => $generate_settings['body_font_size'] . 'px'
			),
			
			// Main title font
			'.main-title' => array(
				'font-family' => current(explode(':', $generate_settings['font_site_title'])),
				'font-weight' => $generate_settings['site_title_font_weight'],
				'text-transform' => $generate_settings['site_title_font_transform'],
				'font-size' => $generate_settings['site_title_font_size'] . 'px'
			),
			
			// Main tagline font
			'.site-description' => array(
				'font-family' => current(explode(':', $generate_settings['font_site_tagline'])),
				'font-weight' => $generate_settings['site_tagline_font_weight'],
				'text-transform' => $generate_settings['site_tagline_font_transform'],
				'font-size' => $generate_settings['site_tagline_font_size'] . 'px'
			),
			
			// Navigation font
			'.main-navigation a' => array(
				'font-family' => current(explode(':', $generate_settings['font_navigation'])),
				'font-weight' => $generate_settings['navigation_font_weight'],
				'text-transform' => $generate_settings['navigation_font_transform'],
				'font-size' => $generate_settings['navigation_font_size'] . 'px'
			),
			
			// Widget title font
			'.widget-title' => array(
				'font-family' => current(explode(':', $generate_settings['font_widget_title'])),
				'font-weight' => $generate_settings['widget_title_font_weight'],
				'text-transform' => $generate_settings['widget_title_font_transform'],
				'font-size' => $generate_settings['widget_title_font_size'] . 'px'
			),
			
			// Heading 1 font
			'h1' => array(
				'font-family' => current(explode(':', $generate_settings['font_heading_1'])),
				'font-weight' => $generate_settings['heading_1_weight'],
				'text-transform' => $generate_settings['heading_1_transform'],
				'font-size' => $generate_settings['heading_1_font_size'] . 'px'
			),
			
			// Heading 2 font
			'h2' => array(
				'font-family' => current(explode(':', $generate_settings['font_heading_2'])),
				'font-weight' => $generate_settings['heading_2_weight'],
				'text-transform' => $generate_settings['heading_2_transform'],
				'font-size' => $generate_settings['heading_2_font_size'] . 'px'
			),
			
			// Heading 3 font
			'h3' => array(
				'font-family' => current(explode(':', $generate_settings['font_heading_3'])),
				'font-weight' => $generate_settings['heading_3_weight'],
				'text-transform' => $generate_settings['heading_3_transform'],
				'font-size' => $generate_settings['heading_3_font_size'] . 'px'
			),
			
			// Heading 1 font
			'h4' => array(
				'font-family' => current(explode(':', $generate_settings['font_heading_4'])),
				'font-weight' => $generate_settings['heading_4_weight'],
				'text-transform' => $generate_settings['heading_4_transform'],
				'font-size' => $generate_settings['heading_4_font_size'] . 'px'
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

		echo $output;
	}
	
	/** 
	 * Add Google Fonts to wp_head if needed
	 * @since 0.1
	 */
	add_action('wp_head','generate_display_google_fonts', 0);
	function generate_display_google_fonts() {
		
		if ( is_admin() )
			return;
			
		$not_google = array(
			"inherit",
			"Arial,+Helvetica,+sans-serif",
			"Verdana,+Geneva,+sans-serif",
			"Tahoma,+Geneva,+sans-serif",
			"Georgia,+Times New Roman,+Times,+serif"
		);

		$generate_settings = get_option( 'generate_settings', generate_get_default_fonts() );
		
		$google_fonts = array();
		if ( !empty($generate_settings) ) :
			foreach($generate_settings as $vkey => $vvalue) {
				if(preg_match('~^font_*~is', $vkey) !== 0 && !empty($vvalue)) {
					$vvalue = str_replace(" ", "+", $vvalue);
					if(!in_array($vvalue, $google_fonts)) {
						$google_fonts[] = $vvalue;
					}
				}
			}
		endif;

		$google_fonts = array_diff($google_fonts, $not_google);
		$google_fonts = implode('|', $google_fonts);
		
		if ($google_fonts) { 
			echo '<link rel="stylesheet" id="generate-fonts" type="text/css" href="//fonts.googleapis.com/css?family=' . $google_fonts . '" />' . "\n";
		}
	}
endif;

/**
 * If Generate Colors isn't activated, set the defaults
 * @since 1.0.5
 */
if ( !function_exists('generate_get_color_defaults') && !function_exists('generate_advanced_css') ) :
	/**
	 * Set default options
	 */
	function generate_get_color_defaults()
	{
		$generate_color_defaults = array(
			'header_background_color' => '#FFFFFF',
			'header_text_color' => '#3a3a3a',
			'header_link_color' => '#3a3a3a',
			'header_link_hover_color' => '',
			'site_title_color' => '#222222',
			'site_tagline_color' => '#999999',
			'navigation_background_color' => '#222222',
			'navigation_text_color' => '#FFFFFF',
			'navigation_background_hover_color' => '#1e72bd',
			'navigation_text_hover_color' => '#FFFFFF',
			'navigation_background_current_color' => '#1e72bd',
			'navigation_text_current_color' => '#FFFFFF',
			'subnavigation_background_color' => '#3f3f3f',
			'subnavigation_text_color' => '#FFFFFF',
			'subnavigation_background_hover_color' => '#4f4f4f',
			'subnavigation_text_hover_color' => '#FFFFFF',
			'subnavigation_background_current_color' => '#4f4f4f',
			'subnavigation_text_current_color' => '#FFFFFF',
			'content_background_color' => '#FFFFFF',
			'content_text_color' => '#3a3a3a',
			'content_link_color' => '',
			'content_link_hover_color' => '',
			'content_title_color' => '',
			'blog_post_title_color' => '',
			'blog_post_title_hover_color' => '',
			'entry_meta_text_color' => '#888888',
			'entry_meta_link_color' => '#666666',
			'entry_meta_link_color_hover' => '#1E73BE',
			'sidebar_widget_background_color' => '#FFFFFF',
			'sidebar_widget_text_color' => '#3a3a3a',
			'sidebar_widget_link_color' => '',
			'sidebar_widget_link_hover_color' => '',
			'sidebar_widget_title_color' => '#000000',
			'footer_widget_background_color' => '#FFFFFF',
			'footer_widget_text_color' => '#3a3a3a',
			'footer_widget_link_color' => '#1e73be',
			'footer_widget_link_hover_color' => '#000000',
			'footer_widget_title_color' => '#000000',
			'footer_background_color' => '#222222',
			'footer_text_color' => '#ffffff',
			'footer_link_color' => '#ffffff',
			'footer_link_hover_color' => '#4295DD',
		);
		
		return apply_filters( 'generate_color_option_defaults', $generate_color_defaults );
	}
	/**
	 * Generate the CSS in the <head> section using the Theme Customizer
	 * @since 0.1
	 */
	add_action('generate_head_css','generate_advanced_css');
	function generate_advanced_css()
	{
		$generate_settings = get_option( 'generate_settings', generate_get_color_defaults() );
		$space = ' ';

		// Start the magic
		$visual_css = array (
		
			// Header
			'.site-header' => array(
				'background' => $generate_settings['header_background_color'],
				'color' => $generate_settings['header_text_color']
			),
			
			// Header link
			'.site-header a,
			.site-header a:visited' => array(
				'color' => $generate_settings['header_link_color']
			),
			
			// Header link hover
			'.site-header a:hover' => array(
				'color' => $generate_settings['header_link_hover_color']
			),
			
			// Site title color
			'.main-title a,
			.main-title a:hover,
			.main-title a:visited' => array(
				'color' => $generate_settings['site_title_color']
			),
			
			// Site description
			'.site-description' => array(
				'color' => $generate_settings['site_tagline_color']
			),
			
			// Navigation background
			'.main-navigation,  
			.main-navigation ul ul' => array(
				'background' => $generate_settings['navigation_background_color']
			),
			
			// Sub-Navigation background
			'.main-navigation ul ul' => array(
				'background' => $generate_settings['subnavigation_background_color']
			),
			
			// Navigation text
			'.main-navigation .main-nav ul li a,
			.menu-toggle' => array(
				'color' => $generate_settings['navigation_text_color']
			),
			
			// Sub-Navigation text
			'.main-navigation .main-nav ul ul li a' => array(
				'color' => $generate_settings['subnavigation_text_color']
			),
			
			// Navigation background/text on hover
			'.main-navigation .main-nav ul li > a:hover, 
			.main-navigation .main-nav ul li.sfHover > a' => array(
				'color' => $generate_settings['navigation_text_hover_color'],
				'background' => $generate_settings['navigation_background_hover_color']
			),
			
			// Sub-Navigation background/text on hover
			'.main-navigation .main-nav ul ul li > a:hover, 
			.main-navigation .main-nav ul ul li.sfHover > a' => array(
				'color' => $generate_settings['subnavigation_text_hover_color'],
				'background' => $generate_settings['subnavigation_background_hover_color']
			),
			
			// Navigation background / text current
			'.main-navigation .main-nav ul .current-menu-item > a, 
			.main-navigation .main-nav ul .current-menu-parent > a, 
			.main-navigation .main-nav ul .current-menu-ancestor > a, 
			.main-navigation .main-nav ul .current_page_item > a, 
			.main-navigation .main-nav ul .current_page_parent > a, 
			.main-navigation .main-nav ul .current_page_ancestor > a' => array(
				'color' => $generate_settings['navigation_text_current_color'],
				'background' => $generate_settings['navigation_background_current_color']
			),
			
			// Navigation background text current text hover
			'.main-navigation .main-nav ul .current-menu-item > a:hover, 
			.main-navigation .main-nav ul .current-menu-parent > a:hover, 
			.main-navigation .main-nav ul .current-menu-ancestor > a:hover, 
			.main-navigation .main-nav ul .current_page_item > a:hover, 
			.main-navigation .main-nav ul .current_page_parent > a:hover, 
			.main-navigation .main-nav ul .current_page_ancestor > a:hover, 
			.main-navigation .main-nav ul .current-menu-item.sfHover > a, 
			.main-navigation .main-nav ul .current-menu-parent.sfHover > a, 
			.main-navigation .main-nav ul .current-menu-ancestor.sfHover > a, 
			.main-navigation .main-nav ul .current_page_item.sfHover > a, 
			.main-navigation .main-nav ul .current_page_parent.sfHover > a, 
			.main-navigation .main-nav ul .current_page_ancestor.sfHover > a' => array(
				'color' => $generate_settings['navigation_text_current_color'],
				'background' => $generate_settings['navigation_background_current_color']
			),
			
			// Sub-Navigation background / text current
			'.main-navigation .main-nav ul ul .current-menu-item > a, 
			.main-navigation .main-nav ul ul .current-menu-parent > a, 
			.main-navigation .main-nav ul ul .current-menu-ancestor > a, 
			.main-navigation .main-nav ul ul .current_page_item > a, 
			.main-navigation .main-nav ul ul .current_page_parent > a, 
			.main-navigation .main-nav ul ul .current_page_ancestor > a' => array(
				'color' => $generate_settings['subnavigation_text_current_color'],
				'background' => $generate_settings['subnavigation_background_current_color']
			),
			
			// Sub-Navigation current background / text current
			'.main-navigation .main-nav ul ul .current-menu-item > a:hover, 
			.main-navigation .main-nav ul ul .current-menu-parent > a:hover, 
			.main-navigation .main-nav ul ul .current-menu-ancestor > a:hover, 
			.main-navigation .main-nav ul ul .current_page_item > a:hover, 
			.main-navigation .main-nav ul ul .current_page_parent > a:hover, 
			.main-navigation .main-nav ul ul .current_page_ancestor > a:hover,
			.main-navigation .main-nav ul ul .current-menu-item.sfHover > a, 
			.main-navigation .main-nav ul ul .current-menu-parent.sfHover > a, 
			.main-navigation .main-nav ul ul .current-menu-ancestor.sfHover > a, 
			.main-navigation .main-nav ul ul .current_page_item.sfHover > a, 
			.main-navigation .main-nav ul ul .current_page_parent.sfHover > a, 
			.main-navigation .main-nav ul ul .current_page_ancestor.sfHover > a' => array(
				'color' => $generate_settings['subnavigation_text_current_color'],
				'background' => $generate_settings['subnavigation_background_current_color']
			),
			
			// Content
			'.inside-article, 
			.comments-area, 
			.page-header,
			.one-container .container,
			.paging-navigation,
			.inside-page-header' => array(
				'background' => $generate_settings['content_background_color'],
				'color' => $generate_settings['content_text_color']
			),
			
			// Content links
			'.inside-article a, 
			.inside-article a:visited,
			.paging-navigation a,
			.paging-navigation a:visited,
			.comments-area a,
			.comments-area a:visited,
			.page-header a,
			.page-header a:visited' => array(
				'color' => $generate_settings['content_link_color']
			),
			
			// Content link hover
			'.inside-article a:hover,
			.paging-navigation a:hover,
			.comments-area a:hover,
			.page-header a:hover' => array(
				'color' => $generate_settings['content_link_hover_color']
			),
			
			// Entry header
			'.entry-header h1,
			.page-header h1' => array(
				'color' => $generate_settings['content_title_color']
			),
			
			// Blog post title
			'.entry-title a,
			.entry-title a:visited' => array(
				'color' => $generate_settings['blog_post_title_color']
			),
			
			// Blog post title hover
			'.entry-title a:hover' => array(
				'color' => $generate_settings['blog_post_title_hover_color']
			),
			
			// Entry meta text
			'.entry-meta' => array(
				'color' => $generate_settings['entry_meta_text_color']
			),
			
			// Entry meta links
			'.entry-meta a, 
			.entry-meta a:visited' => array(
				'color' => $generate_settings['entry_meta_link_color']
			),
			
			// Entry meta links hover
			'.entry-meta a:hover' => array(
				'color' => $generate_settings['entry_meta_link_color_hover']
			),
			
			// Sidebar widget
			'.sidebar .widget' => array(
				'background' => $generate_settings['sidebar_widget_background_color'],
				'color' => $generate_settings['sidebar_widget_text_color']
			),
			
			// Sidebar widget links
			'.sidebar .widget a, 
			.sidebar .widget a:visited' => array(
				'color' => $generate_settings['sidebar_widget_link_color']
			),
			
			// Sidebar widget link hover
			'.sidebar .widget a:hover' => array(
				'color' => $generate_settings['sidebar_widget_link_hover_color']
			),
			
			// Sidebar widget title
			'.sidebar .widget .widget-title' => array(
				'color' => $generate_settings['sidebar_widget_title_color']
			),
			
			// Footer widget
			'.footer-widgets' => array(
				'background' => $generate_settings['footer_widget_background_color'],
				'color' => $generate_settings['footer_widget_text_color']
			),
			
			// Footer widget links
			'.footer-widgets a, 
			.footer-widgets a:visited' => array(
				'color' => $generate_settings['footer_widget_link_color']
			),
			
			// Footer widget link hover
			'.footer-widgets a:hover' => array(
				'color' => $generate_settings['footer_widget_link_hover_color']
			),
			
			// Sidebar widget title
			'.footer-widgets .widget-title' => array(
				'color' => $generate_settings['footer_widget_title_color']
			),
			
			// Footer
			'.site-info' => array(
				'background' => $generate_settings['footer_background_color'],
				'color' => $generate_settings['footer_text_color']
			),
			
			// Footer links
			'.site-info a, 
			.site-info a:visited' => array(
				'color' => $generate_settings['footer_link_color']
			),
			
			// Footer link hover
			'.site-info a:hover' => array(
				'color' => $generate_settings['footer_link_hover_color']
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
		
		if ( $generate_settings['sidebar_widget_background_color'] !== $generate_settings['content_background_color'] && 
			$generate_settings['content_layout_setting'] == 'one-container' ) :
			echo '.widget{padding:30px;}';
		endif;
		
		$output = str_replace(array("\r", "\n"), '', $output);
		echo $output;
	}
endif;