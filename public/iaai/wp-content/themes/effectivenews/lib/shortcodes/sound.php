<?php
function sound_eff($atts, $content) {
	extract(shortcode_atts(array(
		'width' => '590',
		'height' => '375',
		'id' => '',
			), $atts));
			$type="https://w.soundcloud.com/player/?url=";
		return '<div class="video_wrap">
              	<iframe width="'.$width.'" height="'.$height.'" src="'.$type.$id.'"></iframe>
              </div>';
	
	}

add_shortcode('sound', 'sound_eff');

?>