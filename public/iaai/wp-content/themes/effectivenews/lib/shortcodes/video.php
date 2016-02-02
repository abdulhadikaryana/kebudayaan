<?php
function video_miza($atts, $content) {
	extract(shortcode_atts(array(
		'width' => '590',
		'height' => '375',
		'id' => '',
		'type' => ''
			), $atts));
		if ($type=='youtube') {
			$type="http://www.youtube.com/embed/";
			} elseif($type == 'vimeo') {
				$type= "http://player.vimeo.com/video/";
			} elseif($type == 'daily') {
				$type= "http://www.dailymotion.com/swf/video/";
			} elseif($type == 'yahoo') {
				$type= "http://d.yimg.com/nl/vyc/site/player.html#vid=";
			} elseif($type == 'bliptv') {
				$type= "http://a.blip.tv/scripts/shoggplayer.html#file=http://blip.tv/rss/flash/";
			} elseif($type == 'veoh') {
				$type= "http://www.veoh.com/static/swf/veoh/SPL.swf?videoAutoPlay=0&permalinkId=";
			} elseif($type == 'viddler') {
				$type= "http://www.viddler.com/simple/";
			}							
		return '<div class="video_wrap">
              	<iframe width="'.$width.'" height="'.$height.'" src="'.$type.$id.'"></iframe>
              </div>';
	
	}

add_shortcode('video', 'video_miza');

?>