/*

	01. - CTP Format Options

*/

/* jshint -W099 */
/* global jQuery:false */

var ct = jQuery.noConflict();

jQuery(document).ready(function() {

	'use strict';



/*= 01. =========================================

	C T P   F O R M A T   O P T I O N S
	Project Format Options
	/ ..

===============================================*/

/*

	FORMAT OPTIONS

		1.1 - function
		1.2 - by loading
		1.3 - by click on label
		1.4 - by click on radiobutton
		

*/

	/*-------------------------------------------
		1.1 - function
	-------------------------------------------*/

	function st_ctp_format_options( $type ) {

		ct('.fot_toggle').addClass('none');

		if ( $type === 'gallery' || $type === '0' ) {
			ct('#fot_gallery').removeClass('none'); }

		if ( $type === 'video' ) {
			ct('#fot_video_selfhosted, #fot_video_embedded').removeClass('none'); }

		if ( $type === 'audio' ) {
			ct('#fot_audio_selfhosted, #fot_audio_embedded').removeClass('none'); }

	}


	/*-------------------------------------------
		1.2 - by loading
	-------------------------------------------*/

	var
		ctpFormat = ct('#st_ctp_format').html();

		st_ctp_format_options( ctpFormat );

		ct('#ctp-format-' + ctpFormat).attr('checked','checked');


	/*-------------------------------------------
		1.3 - by click on label
	-------------------------------------------*/

	ct('label.ctp-format-icon').click(function(){

		var
			$id = ct(this).attr('for'),
			$type = $id.replace( 'ctp-format-', '' );

			st_ctp_format_options( $type );

	});


	/*-------------------------------------------
		1.4 - by click on radiobutton
	-------------------------------------------*/

	ct('input.ctp-format').click(function(){

		var
			$type = ct(this).val();

			st_ctp_format_options( $type );

	});



}); // end jQuery.noConflict()