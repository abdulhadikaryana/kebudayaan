<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	- version
	- plugin_page
	- plugin_url

*/

/*===============================================

	K I T   O P T I O N S
	Common options of the kit plugin

===============================================*/

	global $st_Kit;

	$st_Kit = array(
		'version'		=>	'1.5.0',
		'plugin_page'	=>	'http://strictthemes.com/to/stkit',
		'plugin_url'	=>	'#',
		'fonts_system'	=>	array(
								"Arial, Helvetica, sans-serif;",
								"Helvetica, Arial, sans-serif;",
								"'Comic Sans MS', cursive;",
								"'Courier New', monospace;",
								"Georgia, serif;",
								"'Lucida Console', Monaco, monospace;",
								"'Lucida Sans Unicode', 'Lucida Grande', sans-serif;",
								"'Palatino Linotype', 'Book Antiqua', Palatino, serif;",
								"Tahoma, Geneva, sans-serif;",
								"'Times New Roman', Times, serif;",
								"'Trebuchet MS', sans-serif;",
								"Verdana, Geneva, sans-serif;",
								"'MS Sans Serif', Geneva, sans-serif;",
								),
		'tags_allowed'	=>	array(
								'a'			=>	array(
													'class'				=> array(),
													'id'				=> array(),
													'href'				=> array(),
													'title'				=> array(),
													),
								'b'			=>	array(),
								'br'		=>	array(),
								'blockquote'=>	array(
													'cite'				=> array(),
													),
								'code'		=>	array(),
								'div'		=>	array(
													'class'				=> array(),
													'id'				=> array(),
													),
								'em'		=>	array(),
								'i'			=>	array(),
								'img'		=>	array(
													'alt'				=> array(),
													'class'				=> array(),
													'id'				=> array(),
													'src'				=> array(),
													'title'				=> array(),
													),
								'iframe'	=>	array(
													'src'				=> array(),
													'width'				=> array(),
													'height'			=> array(),
													'scrolling'			=> array(),
													'frameborder'		=> array(),
													'allowfullscreen'	=> array(),
													),
								'link'		=>	array(
													'href'				=> array(),
													'rel'				=> array(),
													'type'				=> array(),
													),
								'p'			=>	array(),
								'pre'		=>	array(),
								'q'			=>	array(
													'cite'				=> array(),
													),
								'script'	=>	array(
													'type'				=> array(),
													'src'				=> array(),
													'id'				=> array(),
													),
								'span'		=>	array(
													'class'				=> array(),
													'id'				=> array(),
													),
								'strike'	=>	array(),
								'strong'	=>	array(),
								'table'		=>	array(
													'class'				=> array(),
													'id'				=> array(),
													),
								'td'		=>	array(),
								'tr'		=>	array(),
								),
	);


?>