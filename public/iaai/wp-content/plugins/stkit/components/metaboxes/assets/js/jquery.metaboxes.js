/*

	01. - Post Format Options

*/

/* jshint -W099 */
/* global jQuery:false */

var mt = jQuery.noConflict();

jQuery(document).ready(function() {

	'use strict';



/*= 01. =========================================

	F O R M A T   O P T I O N S
	Post Format Options
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

	function st_format_options( $type ) {

		mt('.fop_toggle').addClass('none');

		if ( $type === 'standard' || $type === '0' ) {
			mt('#fop_disable_title, #fop_subtitle, #fop_lightbox').removeClass('none'); }

		if ( $type === 'image' ) {
			mt('#fop_lightbox').removeClass('none'); }

		if ( $type === 'link' ) {
			mt('#fop_link').removeClass('none'); }

		if ( $type === 'quote' ) {
			mt('#fop_quote').removeClass('none'); }

		if ( $type === 'status' ) {
			mt('#fop_status').removeClass('none'); }

		if ( $type === 'video' ) {
			mt('#fop_video_selfhosted, #fop_video_embedded').removeClass('none'); }

		if ( $type === 'audio' ) {
			mt('#fop_audio_selfhosted, #fop_audio_embedded').removeClass('none'); }

		if ( $type === 'gallery' ) {
			mt('#fop_gallery').removeClass('none'); }

		mt('.meta-for-all-formats').each(function(){
			mt(this).removeClass('none'); });

}


	/*-------------------------------------------
		1.2 - by loading
	-------------------------------------------*/

	var
		postFormat = mt('#st_post_format').html();

		st_format_options( postFormat );


	/*-------------------------------------------
		1.3 - by click on label
	-------------------------------------------*/

	mt('label.post-format-icon').click(function(){

		var
			$id = mt(this).attr('for'),
			$type = $id.replace( 'post-format-', '' );

			st_format_options( $type );

	});


	/*-------------------------------------------
		1.4 - by click on radiobutton
	-------------------------------------------*/

	mt('input.post-format').click(function(){

		var
			$type = mt(this).val();

			st_format_options( $type );

	});



}); // end jQuery.noConflict()