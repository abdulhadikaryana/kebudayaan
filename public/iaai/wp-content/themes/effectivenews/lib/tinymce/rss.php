<?php 

 add_action('init', 'add_button_rsssc');
 
 function add_button_rsssc() {
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
   {
     add_filter('mce_external_plugins', 'add_plugin_rsssc');
     add_filter('mce_buttons_3', 'register_button_rsssc');
   }
}

function register_button_rsssc($buttons) {
   array_push($buttons, "rsssc");
   return $buttons;
}

function add_plugin_rsssc($plugin_array) {
   $plugin_array['rsssc'] = get_template_directory_uri() .'/lib/tinymce/rss.js';
   return $plugin_array;
}
