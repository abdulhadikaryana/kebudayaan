jQuery(document).ready(function($) {
// 2 Cols
    "use strict";
    var cols = 2;
    var i = 0;
    $(".news_box3").each(function(){
	    i++;
	    cols = 2;
	    if (i % cols === 0) { $(this).addClass("last").after('<div class="clear"></div>'); }
    });
//Menu
jQuery(".navigation ul.main_menu a, ul.top_menu a").removeAttr('title');
	jQuery(" .navigation ul.main_menu ul, ul.top_menu ul").css({display: "none"}); // Opera Fix
	jQuery(".navigation ul.main_menu li, ul.top_menu li").each(function()
		{	
	var jQuerysubmeun = jQuery(this).find('ul:first');
	jQuery(this).hover(function()
		{	
	jQuerysubmeun.stop().css({overflow:"hidden", height:"auto", display:"none", paddingTop:0}).slideDown(250, function()
		{
	jQuery(this).css({overflow:"visible", height:"auto"});
		});	
		},
	function()
		{	
	jQuerysubmeun.stop().slideUp(250, function()
		{	
	jQuery(this).css({overflow:"hidden", display:"none"});
			});
		});	
	});
	//Mega
	$('ul.main_menu .sub-menu > li').hover(function(){
        var menuid= this.id.split('-')[2];
        var mparent = $(this).closest('.sub-mega-wrap')
        mparent.find('.sub-menu > li').removeClass('active');
        $(this).addClass('active');
        mparent.find('.subcat > div').removeClass('active');
        mparent.find('#mn-latest-'+menuid).addClass('active');
	});
    
	$('.nav .sub-menu-collapse').on('click',function(event){
	    $(this).toggleClass('active');
	});
	
//Hover Images
$('.post_thumb , .news_pic img , .news_pic2 img, .blog_style2 img, .w_posts_images img, .blog_masonry img, .entry-content .flickr_badge_image img, .tabs_widget_content ul li img, .news_box5 img, .bottom_box img, .crousel_style2 img, .attachment-shop_catalog').hover( function() {
    $(this).stop().animate({opacity:0.8},{queue:false,duration:200});  
    },
    function()
    {
    $(this).stop().animate({opacity:1},{queue:false,duration:200});  
});
//tip
    $('.tip_s').tipsy({gravity: 's'});
    $('.tip_n').tipsy({gravity: 'n'});
    $('.tip_e').tipsy({gravity: 'e'});
    $('.tip_w').tipsy({gravity: 'w'});
//Scroll To top
    jQuery(window).scroll(function(){
	    if (jQuery(this).scrollTop() > 100) {
		    jQuery('.to_top').fadeIn();
	    } else {
		    jQuery('.to_top').fadeOut();
	    }
    });
    jQuery('.to_top').click(function(){
	    jQuery('html, body').animate({scrollTop: '0px'}, 800);
	    return false;
    });
// Tabs
    $( "#tabs_category" ).tabs();
    $( "#tabs_cat2" ).tabs();
// Tabs Widget
    $( "#tabs_widget" ).tabs();
//mobile menus
    jQuery( ".mobileMainMenu, .mobileTopMenu" ).change(function() {
        window.location = jQuery(this).find("option:selected").val();
    });
//shop
	$('.product > .button').wrap('<div class="product-bottom"></div>');
	$('.product-bottom').each(function(){
	  $(this).append('<a class="product-details" href="' + $(this).parents('.product').children('a').attr('href') +'">Details</a>');
	});
	$('.woocommerce-ordering').append('<span>Sort by</span><span class="icon-angle-down"</span>');
});