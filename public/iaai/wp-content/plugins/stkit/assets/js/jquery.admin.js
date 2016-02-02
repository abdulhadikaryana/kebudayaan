/*

	01. - Message
	02. - Panel Tabs
	03. - Logo Tabs
	04. - Font Type
	05. - Textarea
	06. - Slider Control
	07. - Footer Templates
	08. - Post Templates
	09. - Toggle On Checkboxes
	10. - Tooltips
	11. - Create a gallery
	12. - Select an image

*/

/* jshint -W099 */
/* jshint -W010 */
/* jshint devel:true */
/* jshint unused: true */
/* global jQuery:false, wp:false, ajaxurl:false */



var a = jQuery.noConflict();

jQuery(document).ready(function() {

	'use strict';



/*= 01. =========================================

	M E S S A G E
	The message on panel header
	/ ..

===============================================*/

	// Hide #messageUpdated
	a('#messageUpdated').delay(3000).fadeOut(400);



/*= 02. =========================================

	P A N E L   T A B S
	Tabs on theme panel
	/ ..

===============================================*/

/*

	1 - PANEL TABS

		1.1 - by loading
		1.2 - by click

*/

	/*-------------------------------------------
		1.1 - by loading
	-------------------------------------------*/

	var
		tabID = a('#input-panelTabsNav').val();
		tabID = tabID ? tabID : 'general';

		// Display tab
		a('#' + tabID).show();

		// Display nav tab
		a('#panelTabsNav li a').each(function(){

			var
				href = a(this).attr('href');

				if ( href === '#' + tabID  ) {
					a(this).addClass('current'); }

		});


	/*-------------------------------------------
		1.1 - by click
	-------------------------------------------*/

	a('#panelTabsNav li a').each(function(){

		a(this).click(function(){

			var
				tabID = a(this).attr('href').replace('#','');

				// Change tab
				a('.panelTab').hide();
				a('#' + tabID).show();

				// Change nav tab
				a('#panelTabsNav li a').removeClass('current');
				a(this).addClass('current');
			
				// Send id to the hidden field
				a('#input-panelTabsNav').val(tabID);

			return false;

		});

	});



/*= 03. =========================================

	L O G O   T A B S
	Select a type of logo
	/ Theme Panel > General

===============================================*/

/*

	1 - FONT TYPE

		1.1 - by loading
		1.2 - by click

*/

	/*-------------------------------------------
		1.1 - by loading
	-------------------------------------------*/

	var
		ltCheck = a('#radio-logo-text').attr('checked');

		if ( ltCheck ) {
			a('#logo-text').show(); }

	var
		liCheck = a('#radio-logo-image').attr('checked');

		if ( liCheck ) {
			a('#logo-image, #logo-image-preview').show(); }


	/*-------------------------------------------
		1.2 - by click
	-------------------------------------------*/

	// Display text logo
	a('#radio-logo-text').click(function() {
		a('#logo-text').show();
		a('#logo-image, #logo-image-preview').hide();
	});

	// Display image logo
	a('#radio-logo-image').click(function() {
		a('#logo-text').hide();
		a('#logo-image, #logo-image-preview').show();
	});



/*= 04. =========================================

	F O N T   T Y P E
	Select a type of font
	/ Fonts

===============================================*/

/*

	1 - FONT TYPE

		1.1 - by loading
		1.2 - by click

*/

	/*-------------------------------------------
		1.1 - by loading
	-------------------------------------------*/

	var
		fsCheck = a('#radio-font-system input').attr('checked');

		if ( fsCheck ) {
			a('#font-system').show(); }

	var
		fcCheck = a('#radio-font-custom input').attr('checked');

		if ( fcCheck ) {
			a('#font-custom').show(); }


	/*-------------------------------------------
		1.2 - by click
	-------------------------------------------*/

	// Display text logo
	a('#radio-font-system').click(function() {
		a('#font-system').show();
		a('#font-custom').hide();
	});

	// Display image logo
	a('#radio-font-custom').click(function() {
		a('#font-system').hide();
		a('#font-custom').show();
	});



/*= 05. =========================================

	T E X T A R E A
	Animate textarea by focus
	/ ..

===============================================*/

/*

	1 - TEXTAREA

*/

	a('.panel-fieldset textarea').not('.no-resize')

		.focus(function(){
			a(this).stop( true, false ).animate({ height: '200px' }, 300); });



/*= 06. =========================================

	S L I D E R   C O N T R O L
	jQuery slider for controls
	/ Theme Panel > Blog
	/ Theme Panel > Sidebar
	/ Projets > Portfolio
	/ Fonts

===============================================*/

/*

	1 - SLIDER CONTROL

		1.1 - Qty of additional sidebars
		1.2 - Qty of portfolio projects
		1.3 - Font size general
		1.4 - Qty of featured (sticky) posts
		1.5 - Qty of WooCommerce products

*/

	/*-------------------------------------------
		1.1 - Qty of additional sidebars
	-------------------------------------------*/

		// by click
		a('#sidebar_qty-slider').slider({
			range: 'min',
			value: 0,
			min: 2,
			max: 20,
			slide: function( event, ui ) { a('#sidebar_qty').val( ui.value ); }
		});

		// by loading
		a('#sidebar_qty-slider').slider({ value: a('#sidebar_qty').val() });


	/*-------------------------------------------
		1.2 - Qty of portfolio projects
	-------------------------------------------*/

		// by click
		a('#projects_qty-slider').slider({
			range: 'min',
			value: 5,
			min: 1,
			max: 50,
			slide: function( event, ui ) { a('#projects_qty').val( ui.value ); }
		});

		// by loading
		a('#projects_qty-slider').slider({ value: a('#projects_qty').val() });


	/*-------------------------------------------
		1.3 - Font size general
	-------------------------------------------*/

		// by click
		a('#font_size-slider').slider({
			range: 'min',
			value: 14,
			min: 10,
			max: 18,
			slide: function( event, ui ) { a('#font_size').val( ui.value ); }
		});

		// by loading
		a('#font_size-slider').slider({ value: a('#font_size').val() });


	/*-------------------------------------------
		1.4 - Qty of featured (sticky) posts
	-------------------------------------------*/

		// by click
		a('#sticky_qty-slider').slider({
			range: 'min',
			value: 5,
			min: 5,
			max: 50,
			slide: function( event, ui ) { a('#sticky_qty').val( ui.value ); }
		});

		// by loading
		a('#sticky_qty-slider').slider({ value: a('#sticky_qty').val() });


	/*-------------------------------------------
		1.5 - Qty of WooCommerce products
	-------------------------------------------*/

		// by click
		a('#products_qty-slider').slider({
			range: 'min',
			value: 9,
			min: 3,
			max: 33,
			slide: function( event, ui ) { a('#products_qty').val( ui.value ); }
		});

		// by loading
		a('#products_qty-slider').slider({ value: a('#products_qty').val() });


/*= 07. =========================================

	F O O T E R   T E M P L A T E S
	Footer sidebar schemes
	/ Layout > Footer

===============================================*/

/*

	1 - FOOTER TEMPLATES

		1.1 - by loading
		1.2 - by click

*/

	/*-------------------------------------------
		1.1 - by loading
	-------------------------------------------*/

	var sidebars = [
		'#footer_sidebars_1',
		'#footer_sidebars_2',
		'#footer_sidebars_3',
		'#footer_sidebars_4',
		'#footer_sidebars_5',
		'#footer_sidebars_6',
		'#footer_sidebars_none',
	];

	for ( var s = 0; s < sidebars.length; s++ ) {

		var
			sbCheck = a( sidebars[s] ).attr('checked');

			if ( sbCheck ) {
				a( sidebars[s] ).parent().addClass( 'tmpl_selected' ); }

	}

	/*-------------------------------------------
		1.2 - by click
	-------------------------------------------*/

	// see Post Templates > by click



/*= 08. =========================================

	P O S T   T E M P L A T E S
	Select posts template
	/ Theme Panel > Blog

===============================================*/

/*

	1 - POST TEMPLATES

		1.1 - by loading
		1.2 - by click

*/

	/*-------------------------------------------
		1.1 - by loading
	-------------------------------------------*/

	var templates = [
		'#default_template',
		'#t1_template',
		'#t2_template',
		'#t3_template',
		'#t4_template',
		'#t5_template',
		'#t6_template',
		'#t7_template',
		'#t8_template',
		'#t9_template',
	];

	for ( var t = 0; t < templates.length; t++ ) {

		var
			tCheck = a( templates[t] ).attr('checked');

			if ( tCheck ) {
				a( templates[t] ).parent().addClass( 'tmpl_selected' ); }

	}


	/*-------------------------------------------
		1.2 - by click
	-------------------------------------------*/

	a('.tmpl_radio input').click(function() {

		a(this).parent().parent().find( '.tmpl_selected' ).removeClass( 'tmpl_selected' );
		a(this).parent().addClass( 'tmpl_selected' );

	});



/*= 09. =========================================

	T O G G L E S   O N   C H E C K B O X E S
	Toggled controls
	/ Theme Panel > Post

===============================================*/

/*

	1 - TOGGLES ON CHECKBOXES

		1.1 - by loading
		1.2 - by click

*/

	/*-------------------------------------------
		1.1 - by loading
	-------------------------------------------*/

	var toggles = [
		'#post_meta',
		'#before_post',
		'#after_title',
		'#after_post',
		'#post_comments'
	];

	for ( var tg = 0; tg < toggles.length; tg++ ) {

		var
			tgCheck = a( toggles[tg] ).attr('checked');
	
			if ( tgCheck ) {
				a( toggles[tg] + '_box' ).addClass( 'block' ); }

	}


	/*-------------------------------------------
		1.2 - by click
	-------------------------------------------*/

	a('.checkbox-toggle').click(function(){

	var
		tgID = '#' + a(this).attr( 'id' );
	
		if ( a( tgID + '_box').hasClass( 'block' ) ) {

			a( tgID + '_box').removeClass( 'block' );

		}
		
		else {

			a( tgID + '_box').addClass( 'block' );

		}
		
	});



/*= 10. =========================================

	T O O L T I P S
	Simple tooltips
	/ ..

===============================================*/

/*

	1 - TOOLTIPS

		1.1 - Function

*/

	/*-------------------------------------------
		1.1 - Function
	-------------------------------------------*/

	a('.tooltip').each(function(){

		a(this)

			.hover(
	
				function(){
	
					var
						tt_title = a(this).attr('title');
	
						if ( tt_title ) {
		
							a(this).attr('title','');
	
							a('body').append('<div id="tooltip-holder"></div>');
		
							a('#tooltip-holder').html('<div class="tooltip-holder">' + tt_title + '</div>');
				
							a('body').mousemove(function(ev) {

								a('#tooltip-holder')
									.css({
										'left': ev.pageX + 13 + 'px',
										'top': ev.pageY + 25 + 'px'
									});

							});
				
						}

				},
	
				function(){

					var
						tt_title = a('#tooltip-holder > div').html();

						a(this).attr( 'title', tt_title );
	
						a('#tooltip-holder').remove();
	
				}
	
			);

	});



/*= 11. =========================================

	G A L L E R Y
	Create a gallery for Gallery format
	/ ..

===============================================*/

/*

	1 - GALLERY

		1.1 - function
		1.1 - by loading
		1.2 - by click
		1.4 - misc

*/

	/*-------------------------------------------
		1.1 - function
	-------------------------------------------*/

	function st_ajax_thumbs( ids, target ){

		// Display thumbs
		a.ajax({
			type: 'POST',
			url: ajaxurl,
			dataType: 'html',
			data: {
				action: 'attachments_update',
				ids: ids

			},
			success:function(res) {
				a(target).html(res);
			}
		});

	}


	/*-------------------------------------------
		1.2 - by loading
	-------------------------------------------*/

	a('.st-ajax-thumbs').each(function(){

		var
			ids = a(this).is('[data-ids]') ? a(this).attr('data-ids').split(',') : 0,
			id = a(this).attr('id');

			// Drop thumbs
			if ( ids !== 0 ) {
				st_ajax_thumbs( ids, '#' + id ); }

	});


	/*-------------------------------------------
		1.3 - by click
	-------------------------------------------*/

	a('#st_gallery_button').click(function(){

		wp.media.gallery.shortcode = function( attachments ) {

			var
				images = attachments.pluck('id');

				// Drop IDs
				a('#st_gallery').val( images );

				// Drop thumbs
				st_ajax_thumbs( images, '#st_gallery_thumbs' );

				// Display 'Remove Gallery' link
				a('#st_gallery_delete').removeClass('none');

				// Replace button text
				a('#st_gallery_button').val( a('#st_gallery_button').attr('data-edit') );

		};

		wp.media.editor.open();

		return false;

	});


	/*-------------------------------------------
		1.4 - misc
	-------------------------------------------*/

	a('#st_gallery_delete').click(function(){

		a(this).addClass('none');
		a('#st_gallery').val('');
		a('#st_gallery_thumbs').html('');

		return false;

	});



/*= 12. =========================================

	I M A G E
	Select background image for project\post
	/ ..

===============================================*/

/*

	1 - IMAGE

		1.1 - function
		1.1 - by loading
		1.2 - by click
		1.4 - misc

*/

	/*-------------------------------------------
		1.1 - function
	-------------------------------------------*/

	/* Used a function of gallery */


	/*-------------------------------------------
		1.2 - by loading
	-------------------------------------------*/

	/* Used a function of gallery */


	/*-------------------------------------------
		1.3 - by click
	-------------------------------------------*/

	a('#st_background_button').click(function(){

        var
			send_attachment_bkp = wp.media.editor.send.attachment,
			button = a(this);

			wp.media.editor.send.attachment = function( props, attachment ) {
		
				// Drop IDs
				a('#st_background').val( attachment.id );

				// Drop thumbs
				st_ajax_thumbs( ( attachment.id + ',' ).split(','), '#st_background_thumb' );

				// Display 'Remove Gallery' link
				a('#st_background_delete').removeClass('none');

				wp.media.editor.send.attachment = send_attachment_bkp;

        };

        wp.media.editor.open(button);

		return false;

	});


	/*-------------------------------------------
		1.4 - misc
	-------------------------------------------*/

	a('#st_background_delete').click(function(){

		a(this).addClass('none');
		a('#st_background').val('');
		a('#st_background_thumb').html('');

		return false;

	});






}); // end jQuery.noConflict()