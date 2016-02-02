<?php

function lists($atts, $content) {
	extract(shortcode_atts(array(
		'type' => '',

		), $atts));


	return str_replace('<ul>', '<ul class="'.$type.'">', wpautop(do_shortcode($content)));
			
	}

add_shortcode('list', 'lists');
?>