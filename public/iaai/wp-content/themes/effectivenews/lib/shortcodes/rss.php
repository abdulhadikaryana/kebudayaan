<?php
include_once(ABSPATH.WPINC.'/rss.php');

function readRss($atts, $content) {
    extract(shortcode_atts(array(
	"feed" => 'http://',
        "num" => '1',
    ), $atts));

    return wp_rss($feed, $num);
}

add_shortcode('rss', 'readRss');
?>