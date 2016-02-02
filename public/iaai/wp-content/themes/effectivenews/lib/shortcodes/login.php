<?php
function top_login_form_shortcode() {
if ( is_user_logged_in() )
return '';
 
return wp_login_form( array( 'echo' => false ) );
}
 
function top_add_shortcodes() {
add_shortcode( 'top-login-form', 'top_login_form_shortcode' );
}

add_action( 'init', 'top_add_shortcodes' );
?>