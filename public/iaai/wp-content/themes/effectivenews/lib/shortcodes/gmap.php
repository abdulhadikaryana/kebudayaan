<?php
function eff_googlemap($atts, $content) {
   extract(shortcode_atts(array(
               "width" => '590',
               "height" => '375',
               "src" => ''
   ), $atts));
 
return '<div class="gmap">
         <iframe src="'.$src.'&output=embed" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" width="'.$width.'" height="'.$height.'"></iframe>
        </div>
       ';
}
 
add_shortcode("googlemap", "eff_googlemap");
?>