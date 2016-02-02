/*

	01. - AdSense

*/

/* jshint -W099 */
/* global jQuery:false */

var ds = jQuery.noConflict();

jQuery(document).ready(function() {

	'use strict'; // because AdSense

/*==01.==========================================

 	A D S E N S E
	Ad Units for Google AdSense

===============================================*/

/*

	1 - ADSENSE

		1.1 - Ad Unit

*/

	/*-------------------------------------------
		1.1 - Ad Unit
	-------------------------------------------*/

	function st_define_ad_holders() {

		ds('.st-adsense').each(function(){
	
			var
				width = ds(this).width(), // Available space for ad unit
				client = ds(this).attr('data-client'),
				slot = ds(this).attr('data-slot'),
				type = ds(this).attr('data-type'),
				types = type.split('|'), // Sizes selected on widget
				i,
				size,
				ins = ds(this).children(':first'),
				wBody = ds('body').width(),
				wIns = +ins.attr('data-window'); // + convert to int

				// Define ad unit size
				for ( i = 0; i < types.length; ++i ) {
	
					size = types[i].split('x'); // get the size of current unit
	
					// Stop the loop if it's enought space for the first appropriate unit
					// size[0] - width
					// size[1] - height
	
					if ( width >= size[0] )
						break;
	
				}

				if ( isNaN(wIns) === true || isNaN(wIns) === false && wBody !== wIns ) {

					// Save window width value
					ds(ins).attr( 'data-window', wBody );

					// Apply ad
					ds(ins)
	
						// Reset ad ins
						.removeAttr('data-adsbygoogle-status')
	
						// Drop Ad Unit
						.css({ 'width': size[0], 'height': size[1] })
						.attr( 'data-ad-client', client )
						.attr( 'data-ad-slot', slot );
	
						// Call AdSense
						setTimeout( function(){ ( ins = window.adsbygoogle || [] ).push({}); }, 50 );

				}

		});

	}

	st_define_ad_holders();

	ds(window).resize( st_define_ad_holders );

});