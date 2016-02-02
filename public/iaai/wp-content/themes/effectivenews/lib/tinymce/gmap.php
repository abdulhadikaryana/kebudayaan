<?php 

 add_action('init', 'add_button_gmapsc');
 
 function add_button_gmapsc() {
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
   {
     add_filter('mce_external_plugins', 'add_plugin_gmapsc');
     add_filter('mce_buttons_3', 'register_button_gmapsc');
   }
}

function register_button_gmapsc($buttons) {
   array_push($buttons, "gmapsc");
   return $buttons;
}

function add_plugin_gmapsc($plugin_array) {
   $plugin_array['gmapsc'] = get_template_directory_uri() .'/lib/tinymce/gmap.js';
   return $plugin_array;
}
