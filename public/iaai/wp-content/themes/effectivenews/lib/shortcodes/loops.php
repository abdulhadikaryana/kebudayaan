<?php
function simple_nb($atts, $content) {
	extract(shortcode_atts(array(
		'display' => '',
		'cat' => '',
		'tag' => '',
		'title' => '',
		'posts' => '',
		'style' => '',
	), $atts));

	return eff_news_box_sc($display, $cat, $tag, $title, $posts, $style);
	
	}

add_shortcode('newsbox', 'simple_nb');

function simple_bottom_nb($atts, $content) {
	extract(shortcode_atts(array(
		'cat' => '',
	), $atts));

	return eff_bottom_box_sc($cat);
	
	}

add_shortcode('bottom_newsbox', 'simple_bottom_nb');

function simple_blog($atts, $content) {
	extract(shortcode_atts(array(
		'display' => '',
		'cat' => '',
		'posts' => '',
		'style' => '',
	), $atts));

	return eff_blog_sc($style, $display, $cat, $posts);
	
	}

add_shortcode('blog', 'simple_blog');

function simple_slider($atts, $content) {
	extract(shortcode_atts(array(
		'type' => '',
		'display' => '',
		'cat' => '',
		'tag' => '',
		'count' => '',
	), $atts));

	return eff_slider_sc($type, $display, $cat, $tag, $count);
	
	}

add_shortcode('slider', 'simple_slider');

function simple_nip($atts, $content) {
	extract(shortcode_atts(array(
		'style' => '',
		'display' => '',
		'cat' => '',
		'title' => '',
		'posts' => '',
	), $atts));

	return eff_nip_sc($style, $display, $cat, $title, $posts);
	
	}

add_shortcode('newspictuer', 'simple_nip');

function simple_scroller($atts, $content) {
	extract(shortcode_atts(array(
		'style' => '',
		'display' => '',
		'cat' => '',
		'tag' => '',
		'title' => '',
		'posts' => '',
	), $atts));

	return eff_scroller_sc($style, $display, $cat, $tag, $title, $posts);
	
	}

add_shortcode('scroller', 'simple_scroller');

function simple_lvideo($atts, $content) {
	extract(shortcode_atts(array(
		'order' => '',
		'title' => '',
		'count' => '',
	), $atts));

	return eff_latest_videos_sc($order, $title, $count);
	
	}

add_shortcode('latestvideo', 'simple_lvideo');

?>