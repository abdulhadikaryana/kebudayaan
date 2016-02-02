/* jshint -W099 */
/* global jQuery:false */

var color = jQuery.noConflict();

jQuery(document).ready(function() {

	'use strict';

/*= 01. =========================================

	C O L O R P I C K E R
	Allow to pick colors easily
	/ Style

===============================================*/

/*

	1 - COLORPICKER

		1.1 - Primary
		1.2 - Secondary

*/

	/*-------------------------------------------
		1.1 - Primary
	-------------------------------------------*/

	color( '#color-primary' ).ColorPicker({
		onBeforeShow: function() {
			color( this ).ColorPickerSetColor( this.value );
		},
		onChange: function( hsb, hex ) {
			color( '#color-primary' ).attr( 'value', hex );
			color( '#color-primary-preview' ).css( 'background-color', '#' + hex );
		}
	});


	/*-------------------------------------------
		1.2 - Secondary
	-------------------------------------------*/

	color( '#color-secondary' ).ColorPicker({
		onBeforeShow: function() {
			color( this ).ColorPickerSetColor( this.value );
		},
		onChange: function( hsb, hex ) {
			color( '#color-secondary' ).attr( 'value', hex );
			color( '#color-secondary-preview' ).css( 'background-color', '#' + hex );
		}
	});


}); // end jQuery.noConflict()