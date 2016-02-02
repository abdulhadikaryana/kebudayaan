<?php
function eff_register_js() {
	if (!is_admin()) {
		wp_register_script('custom', EFF_JS . '/custom.js', 'jquery', true);
                wp_register_script('post', EFF_JS . '/post.js', '', 'jquery', true);
		wp_register_script('Tweets', EFF_JS . '/twitter/jquery.tweet.js', '', 'jquery', true);		
		wp_register_script('filex', EFF_JS . '/jquery.flexslider-min.js', '', 'jquery', true);
		wp_register_script('resize', EFF_JS . '/resize.js', '', 'jquery', true);
		wp_register_script('notification', EFF_JS . '/notification.js', '', 'jquery', true);
		wp_register_script('prettyphoto', EFF_JS . '/jquery.prettyPhoto.js', '', 'jquery', true);
		wp_register_script('masonry', EFF_JS . '/jquery.masonry.min.js', '', 'jquery', true);
		wp_register_script('tabset', EFF_JS . '/jquery.tabset.1.0.min.js', '', 'jquery', true);
		wp_register_script('bgs', EFF_JS . '/jquery.backstretch.min.js', '', 'jquery', false);
		wp_register_script('scripts', EFF_JS . '/scripts.js', '', 'jquery', true);
		
		wp_enqueue_script('jquery');
                wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('scripts');
		wp_enqueue_script('custom');
		if(eff_option('sliders') == 'filex') {
			wp_enqueue_script('filex');
		}
		if(eff_option('notification') == true) {
			wp_enqueue_script('notification');
		}
		if(eff_option('slide_bg') == true) {
			wp_enqueue_script('bgs');
		}
	}
}
add_action('init', 'eff_register_js');

function eff_register_style() {
		wp_register_style('woocommerce', EFF_URI . '/woocommerce.css', 'all');
		wp_register_style('prettyphoto', EFF_CSS . '/prettyPhoto.css', 'all');
		wp_register_style('sccss', EFF_CSS . '/shortcodes.css', 'all');
		wp_register_style('responsive', EFF_CSS . '/responsive.css', 'all');
		wp_register_style('flexslider', EFF_CSS . '/flexslider.css', 'all');
		wp_register_style('dark', EFF_CSS . '/dark.css', 'all');
		wp_register_style('peru', EFF_CSS . '/skins/peru.css', 'all');
		wp_register_style('orang', EFF_CSS . '/skins/orang.css', 'all');
		wp_register_style('blue', EFF_CSS . '/skins/blue.css', 'all');
		wp_register_style('green', EFF_CSS . '/skins/green.css', 'all');
		wp_register_style('pink', EFF_CSS . '/skins/pink.css', 'all');
		wp_register_style('gray', EFF_CSS . '/skins/gray.css', 'all');
		
		if(eff_option('sliders') == 'filex') {
		wp_enqueue_style('flexslider');
		}
		
		if ( class_exists( 'Woocommerce' ) ) {
		wp_enqueue_style('woocommerce');
		}
}		
add_action('init', 'eff_register_style');
?>