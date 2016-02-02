<?php 

 add_action('init', 'add_button_mixsc');
 
 function add_button_mixsc() {
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
   {
     add_filter('mce_external_plugins', 'add_plugin_mixsc');
     add_filter('mce_buttons_3', 'register_button_mixsc');
   }
}

function register_button_mixsc($buttons) {
   array_push($buttons, "mixsc");
   return $buttons;
}

function add_plugin_mixsc($plugin_array) {
   $plugin_array['mixsc'] = get_template_directory_uri() .'/lib/tinymce/max.js';
   return $plugin_array;
}
