<?php
function eff_mixcloud($atts, $content) {
	extract(shortcode_atts(array(
		'width' => '590',
		'height' => '375',
		'id' => '',
			), $atts));
			$type="//www.mixcloud.com/widget/iframe/?feed=";
		return '<div class="video_wrap">
              	<iframe width="'.$width.'" height="'.$height.'" src="'.$type.$id.'" frameborder="0"></iframe>
              </div>';
	
	}

add_shortcode('mixcloud', 'eff_mixcloud');

?>