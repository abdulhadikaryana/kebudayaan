<?php 

/*	Show the new style help section if user is running WP 3.3
 ******************************************************** */
if( version_compare( '3.3', get_bloginfo( 'version' ), '<=' ) ):

function sh_sb_help_page() {
	global $sh_sb_settings;
	$current_screen = get_current_screen();
	if ($current_screen->id != $sh_sb_settings)
		return;

	// Overview tab
	
	$sb_overview = '<h2>'.__('Help', 'theme').' - Social Bartender</h2>';
	
	$sb_overview .= '<h3>'.__('Including the list of links in your theme', 'theme').'</h3>';
	
	$sb_overview .= '<p>'.__('To include the list of links in your theme, you need to place the following PHP function in the location where you want the links to appear:', 'theme').'</p>';
	
	$sb_overview .= '<code>&lt;?php social_bartender(); ?&gt;</code>';
	
	$sb_overview .= '<h3>'.__('Theme Developers', 'theme').'</h3>';
	
	$sb_overview .= '<p>'.__('If you would like to make your own icon set available to users in the Icon Box, just place the images inside of an "images/sb-icons" folder of your theme.', 'theme').'</p>';
	
	$sb_overview .= '<h3>'.__('Credits', 'theme').'</h3>';
	
	$sb_overview .= '<p><strong>'.__( 'Contributors:', 'theme' ).'</strong> @sawyerh, @devinsays, @NickHamze, and @thelukemcdonald</p>';
			
	$current_screen->add_help_tab( array(
	    'id'      => 'overview',
		'title'   => __('Overview', 'framework'),
		'content' => $sb_overview,
	) );
	
	// Parameters tab
	
	$sb_parameters = '<h3>'.__( 'Parameters', 'theme' ).'</h3>';
	
	$sb_parameters .= '<p><strong>link_before</strong>: '.__('(string) Sets the text or html that precedes the &lt;a&gt; tag. Default = \' \'', 'theme' ).'</p>';
	
	$sb_parameters .= '<p><strong>link_after</strong>: '.__('(string) Sets the text or html that follows the &lt;a&gt; tag. Default = \' \'', 'theme' ).'</p>';
	
	$sb_parameters .= '<p><strong>echo</strong>: '.__('(boolean) Toggles the display of the generated list of links or return the list as an HTML text string to be used in PHP. Default = 1', 'theme').'</p>';
	
		
	
	$current_screen->add_help_tab( array(
	    'id'      => 'parameters',
		'title'   => __('Parameters', 'framework'),
		'content' => $sb_parameters,
	) );
	
	// Output tab
	
	//$sb_output .= '<h3>'.__( 'Example Output', 'theme' ).'</h3>';
	
	
	$current_screen->add_help_tab( array(
	    'id'      => 'output',
		'title'   => __('Example Output', 'framework'),
		'content' => ''
	) );
	
	
	$sb_info = '<p><strong>' . __( 'For more information:', 'framework' ) . '</strong></p>' .
		'<p>' . __( '<a href="https://github.com/sawyerh/social-bartender" target="_blank">Contribute on Github</a>' ) . '</p>' .
		'<p>' . __( '<a href="http://themeandstirredweb.com">Shaken and Stirred Web</a>' ) . '</p>' .
		'<p>' . __( '<a href="http://onlythefunctions.com" target="_blank">Only the Functions</a>' ) . '</p>';
		
	$current_screen->add_help_tab( array(
	    'id'      => 'more_info',
		'title'   => __('Plugin Info', 'framework'),
		'content' => $sb_info
	) ); 
	
}

else:

/*	Show the old style contextual help if user isn't running WP 3.3+
 ******************************************************** */
 
add_action( 'admin_menu', 'sh_sb_help_page_old' );

function sh_sb_help_page_old() {

	/* Add documentation */
	$contextual_help = '<h2>'.__('Help', 'theme').' - Social Bartender</h2>';
	
	$contextual_help .= '<h3>'.__('Including the list of links in your theme', 'theme').'</h3>';
	
	$contextual_help .= '<p>'.__('To include the list of links in your theme, you need to place the following PHP function in the location where you want the links to appear:', 'theme').'</p>';
	
	$contextual_help .= '<code>&lt;?php social_bartender(); ?&gt;</code>';
	
	$contextual_help .= '<hr />';
	
	$contextual_help .= '<h3>'.__( 'Parameters', 'theme' ).'</h3>';
	
	$contextual_help .= '<p><strong>link_before</strong>: '.__('(string) Sets the text or html that precedes the &lt;a&gt; tag. Default = \' \'', 'theme' ).'</p>';
	
	$contextual_help .= '<p><strong>link_after</strong>: '.__('(string) Sets the text or html that follows the &lt;a&gt; tag. Default = \' \'', 'theme' ).'</p>';
	
	$contextual_help .= '<p><strong>echo</strong>: '.__('(boolean) Toggles the display of the generated list of links or return the list as an HTML text string to be used in PHP. Default = 1', 'theme').'</p>';
	
	$contextual_help .= '<hr />';
	
	$contextual_help .= '<h3>'.__( 'Example Output', 'theme' ).'</h3>';
	
	$contextual_help .= '<p>'.__('Using the default settings, the <code>social_bartender()</code> function would output the following:', 'theme').'</p>';
	
	$contextual_help .= '<pre><code>&lt;a href="http://example.com" class="sh-sb-link"&gt;
	&lt;img src="http://mysite.com/images/icon.png" alt="Link Title" class="sh-sb-icon"&gt;
	&lt;/a&gt;
	
	&lt;a href="http://example.com" class="sh-sb-link"&gt;
	&lt;img src="http://mysite.com/images/icon-2.png" alt="Link #2 Title" class="sh-sb-icon"&gt;
	&lt;/a&gt;</code></pre>';
	
	$contextual_help .= '<hr />';
	
	$contextual_help .= '<h3>'.__('Theme Developers', 'theme').'</h3>';
	
	$contextual_help .= '<p>'.__('If you would like to make your own icon set available to users in the Icon Box, just place the images inside of an "images/sb-icons" folder of your theme.', 'theme').'</p>';
	
	$contextual_help .= '<h3>'.__('Credits / Support', 'theme').'</h3>';
	
	$contextual_help .= '<p>'.__( 'The Social Bartender plugin was created by', 'theme' ).' <a href="http://themeandstirredweb.com">Shaken and Stirred Web</a>. '.__( 'If you find any bugs, have feature requests, or would like to contribute, please visit the plugin\'s <a href="https://github.com/sawyerh/social-bartender">GitHub page</a>.', 'theme').'</p>';
	
	$contextual_help .= '<p><strong>'.__( 'Contributors:', 'theme' ).'</strong> @sawyerh, @devinsays, @NickHamze, and @thelukemcdonald</p>';
	
	add_help_tab( 'settings_page_sh_sb_settings_page', $contextual_help ); 
}

endif;
?>