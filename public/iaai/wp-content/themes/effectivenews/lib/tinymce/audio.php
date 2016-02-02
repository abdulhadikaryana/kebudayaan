<?php 

 add_action('init', 'add_button_audiosc');
 
 function add_button_audiosc() {
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
   {
     add_filter('mce_external_plugins', 'add_plugin_audiosc');
     add_filter('mce_buttons_3', 'register_button_audiosc');
   }
}

function register_button_audiosc($buttons) {
   array_push($buttons, "audiosc");
   return $buttons;
}

function add_plugin_audiosc($plugin_array) {
   $plugin_array['audiosc'] = get_template_directory_uri() .'/lib/tinymce/audio.js';
   return $plugin_array;
}
