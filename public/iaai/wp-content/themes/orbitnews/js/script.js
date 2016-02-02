(function($){
	'use strict';
	$(document.body).outerWidth(false);
	$(document).ready(function($) {
		/* ---------------------------------------------------------------------- */
		/*	Sliders - [Flexslider]
		/* ---------------------------------------------------------------------- */
		try {
			$('.flexslider').flexslider({
				animation: "fade",
			});
		} catch(err) {
	
		}
		
		/*-------------------------------------------------*/
		/* =  Fix for foundation when <ul> has no class
		/*-------------------------------------------------*/
		$('ul:not([class])').addClass('disc');
		
		/*-------------------------------------------------*/
		/* =  Input & Textarea Placeholder
		/*-------------------------------------------------*/
		$('.comment-form input[type="text"], .comment-form textarea, form[role=search] input[type="text"]').focus(function(){
			$(this).removeClass('error');
			if ($(this).val().toLowerCase() == $(this).attr('data-value').toLowerCase())
				$(this).val('');
		}).blur( function(){ 
			if ($(this).val() == '')
				$(this).val($(this).attr('data-value'));
		});
	
		/*-------------------------------------------------*/
		/* =  Dropdown Menu - Superfish
		/*-------------------------------------------------*/
		try {
			$('ul.sf-menu').superfish({
				delay: 400,
				autoArrows: false,
				speed: 'fast',
				animation: {opacity:'show', height:'show'}
			});
		} catch (err){
	
		}
	
		/*-------------------------------------------------*/
		/* =  Mobile Menu
		/*-------------------------------------------------*/
		// Create the dropdown base
		$("<select />").appendTo(".navigation");
		
		// Create default option "Go to..."
		$("<option />", {
			"selected": "selected",
			"value"   : "",
			"text"    : "Go to..."
		}).appendTo(".navigation select");
		
		// Populate dropdown with menu items
		$(".sf-menu a").each(function() {
			var el = $(this);
			if(el.next().is('ul.sub-menu')){
				$("<optgroup />", {
					"label"    : el.text()
				}).appendTo(".navigation select");
			} else {
				$("<option />", {
					"value"   : el.attr("href"),
					"text"    : el.text()
				}).appendTo(".navigation select");
			}
		});
	
		$(".navigation select").change(function() {
		  window.location = $(this).find("option:selected").val();
		});
	
		/*-------------------------------------------------*/
		/* =  Fancybox Images
		/*-------------------------------------------------*/
		try {
			$('.gallery-icon a[href*=".jpg"][href*=".png"][href*=".gif"], .fancybox').colorbox({
				transition	: 'fade',
				scalePhotos	: true,
				maxWidth	: '90%',
				maxHeight	: '90%',
				rel			: 'popup-colorbox',
			}).attr('rel', 'popup-colorbox');
		} catch(err) {
	
		}
		/*-------------------------------------------------*/
		/* =  Fancybox Videos
		/*-------------------------------------------------*/
		try {
			$('.video .post-image a').colorbox({
				iframe 		: true,
				maxWidth	: 800,
				maxHeight	: 600,
				innerWidth	: '75%',
				innerHeight	: '75%',
				rel 		: 'nofollow',
				closeButton : false
			});
		} catch(err) {
	
		}
			
		/*-------------------------------------------------*/
		/* =  Scroll to TOP
		/*-------------------------------------------------*/
		$('a[href="#top"]').click(function(){
			$('html, body').animate({scrollTop: 0}, 'slow');
			return false;
		});
	
		/*-------------------------------------------------*/
		/* =  Tabs Widget - { Popular, Recent and Comments }
		/*-------------------------------------------------*/
	
		$('.tabs-widget').each(function() {
			$(this).find(".tab_content").hide(); 
			$(this).find("ul.tab-links li:first").addClass("active").show(); 
			$(this).find(".tab_content:first").show();
		});
		
	
		$("ul.tab-links li").click(function(e) {
			$(this).parents('.tabs-widget').find("ul.tab-links li").removeClass("active"); 
			$(this).addClass("active"); 
			$(this).parents('.tabs-widget').find(".tab_content").hide(); 
	
			var activeTab = $(this).find("a").attr("href"); 
			$(this).parents('.tabs-widget').find(activeTab).fadeIn();
			
			e.preventDefault();
		});
		
		$("ul.tab-links li a").click(function(e) {
			e.preventDefault();
		})
			
		/* ---------------------------------------------------------------------- */
		/*	Comment Tree
		/* ---------------------------------------------------------------------- */
		try {
			$('#content ul.children > li, ol#comments > li').each(function(){
				if($(this).find(' > ul.children').length == 0){
					$(this).addClass('last-child');
				}
			});
	
			$("#content ul.children").each(function() {
				if($(this).find(' > li').length > 1) {
					$(this).addClass('border');
				}
			});
	
			$('ul.children.border').each(function(){
				$(this).append('<span class="border-left"></span>');
	
				var _height = 0;
	
				for(var i = 0; i < $(this).find(' > li').length - 1; i++){
					_height = _height + parseInt($(this).find(' > li').eq(i).height()) + parseInt($(this).find(' > li').eq(i).css('margin-bottom'));
				}
	
				_height = _height + 29;
	
				$(this).find('span.border-left').css({'height': _height + 'px'});
			});
		} catch(err) {
	
		}
	
		$(window).bind('resize', function(){
			try {
				$('ul.children.border').each(function(){
					var _height = 0;
	
					for(var i = 0; i < $(this).find(' > li').length - 1; i++){
						_height = _height + parseInt($(this).find(' > li').eq(i).height()) + parseInt($(this).find(' > li').eq(i).css('margin-bottom'));
					}
	
					_height = _height + 29;
	
					$(this).find('span.border-left').css({'height': _height + 'px'});
				});
			} catch(err) {
	
			}
		});
	
	});

	/*-------------------------------------------------*/
	/* =  Masonry Effect
	/*-------------------------------------------------*/
	$(window).load(function(){
		try {
			$('#sidebar').masonry({
				singleMode: true,
				itemSelector: '.widget',
				columnWidth: 295,
				gutterWidth: 20
			});
		} catch(err) {
	
		}
	});
})(jQuery);