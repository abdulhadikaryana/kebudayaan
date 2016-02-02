<?php

/*

	1 - INCLUDES

	2 - VARIABLES

	3 - FUNCTION

		- Add another one view
		- Get number of views

*/

/*===============================================

	I N C L U D E S
	Required includes

===============================================*/

	define('WP_USE_THEMES', false);

	require_once('../../../../../../wp-load.php');


/*===============================================

	V A R I A B L E S
	Regured variables

===============================================*/

	$st_['st_id'] = ( isset($_GET['id']) ) ? esc_html( $_GET['id'] ) : '';


/*===============================================

	F U N C T I O N
	Major functions

===============================================*/

	// Add another one view
	st_setPostViews( $st_['st_id'] );

	// Get number of views
	echo st_getPostViews( $st_['st_id'] );


?>