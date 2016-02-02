<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - WIDGETS

		1.1 - ST Widgets

*/

/*===============================================

	W I D G E T S
	Another ST widgets

===============================================*/

	/*-------------------------------------------
		1.1 - ST Widgets
	-------------------------------------------*/

	$kit_['widgets'] = array (
		'sharrre',
		'contact-info',
		'flickr',
		'recent-posts',
		'subscribe',
		'social-icons',
	);

	foreach ( $kit_['widgets'] as $key )
		if ( !empty($st_Options['widgets'][$key]) )
			include ( plugin_dir_path( __FILE__ ) . '/functions/' . $key . '.php' );


?>