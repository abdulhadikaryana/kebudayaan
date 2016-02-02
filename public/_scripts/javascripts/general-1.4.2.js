/**
 * general.js
 *
 * Javascript yang berisi fungsi2 umum yang digunakan secara bersama2
 * oleh halaman2 lain
 * 
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 */

/**
 * Fungsi On Ready JQuery
 */
$(function() {

    $('#slideshow').nivoSlider({
        directionNav: false,
        controlNav: false
    });

    // Star Rating
    $(".rating").children().not(":radio").hide();
    $('.rating').stars({
        disabled: true
    });
	
    $("#signIn").click(function(){
	_gaq.push(['_trackEvent', 'login', 'click', 'open login form']);		
	pageTracker._trackPageview("/login-form");	
    });

    $(".rating-enable").children().not(":radio").hide();
    $(".rating-enable").stars({
        cancelShow: false
    });

    initImageFancyBox();
    initYoutubeFancyBox();

    // Set external links
    externalLinks();

    // Load FB js asynchronous
    /*loadScript('http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php/en_US', function(){
        fbInit();
    });*/
    initFacebook();

});


/**
 * Fungsi inisialisasi Facebook
 */
function initFacebook()
{
    //FB.init(fbApiKey, rootUrl + '/../library/Facebook/xd_receiver.htm');

    window.fbAsyncInit = function() {
        FB.init({appId: fbAppId, status: true, cookie: true, xfbml: true});

        /* All the events registered */
        FB.Event.subscribe('auth.login', function(response) {
            // do something with response
            login();
        });
        FB.Event.subscribe('auth.logout', function(response) {
            // do something with response
            logout();
        });
    };
    (function() {
        var e = document.createElement('script');
        e.type = 'text/javascript';
        e.src = document.location.protocol +
            '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
    }());
}

function login(){
    document.location.href = baseUrl + '/login/facebook';
}
function logout(){
    document.location.href = baseUrl + '/login/logout';
}

/**
 * Fungsi yang dijalankan untuk login Facebook
 *
 * @param string address url
 * @return redirect | false;
 */
function loginfb() {
    FB.Connect.requireSession(function() {
        window.location = baseUrl + '/login/facebook';
    });
    return false;
}

/**
 * Fungsi yang dijalankan untuk logout Facebook
 *
 * @param string address url
 * @return redirect | false;
 */
function logoutfb(address) {
    FB.Connect.logout(function() {
        window.location = baseUrl + '/login/logout';
    });
    return false;
}

/**
 * Fungsi yang dipanggil ketika ingin merubah bahasa yang digunakan
 *
 * @param lang singkatan bahasa
 
 original function - change language -> current function : redirect to the vito website    
 function changeLanguage(lang)
 {
    window.location = rootUrl + '/' + lang + restUrl;
 }
*/

function changeLanguage(lang, link)
{
    var linkSplit = new Array();
    linkSplit = link.split("/")
    linkSplit[3] = lang;
    var linkBaru = linkSplit.join("/");

    /*if((lang == 'en') || (lang == 'id'))
    {
	setCookie('languageName',lang,5);
    }*/
    
	if ((lang == 'de')||(lang == 'jp')||(lang == 'cn')||(lang == 'ru')||(lang == 'id')||(lang == 'en'))
    {
        switch(lang)
        {
            case 'en' : window.location = linkBaru;
                      break;   
            case 'id' : window.location = linkBaru;
                      break;   
            case 'de' : window.open('http://www.toerisme-indonesie.nl/');
                      break;
            case 'jp' : window.open('http://www.visitindonesia.jp/');
                      break;
            case 'cn' : window.open('http://www.visit-indonesia.com.cn/');
                      break;
            case 'ru' : window.open('http://www.go-to-indonesia.ru/');
                      break;
        }
    }else{
        window.open(rootUrl + '/' + lang + restUrl);
		//setCookie('languageName',lang,5);
    }
}

/**
 * Fungsi untuk membuat tag <a> yang memiliki atribut
 * rel=external membuka link sebagai target _blank
 * 
 * Berhubung html sepert ini <a href="" target="_blank"....
 * tidak lolos uji xhtml makanya dibuat fungsi ini
 * 
 * source: http://articles.sitepoint.com/article/standards-compliant-world/3
 */
function externalLinks()
{   
    if (!document.getElementsByTagName) return;
    var anchors = document.getElementsByTagName("a");
    for (var i=0; i<anchors.length; i++) {
        var anchor = anchors[i];
        if (anchor.getAttribute("href") &&
            anchor.getAttribute("rel") == "external")
            anchor.target = "_blank";
    }
} 

/**
 * Fungsi untuk menjalankan javascript secara parallel
 *
 * Secara default di browser, javascript tidak dapat dijalankan secara bersamaan
 * dengan http request untuk image, css maupun html.
 *
 * @param string url javascript url
 * @param string callback fungsi untuk callback
 */
function loadScript(url, callback)
{
    var body = document.getElementsByTagName("body")[0],
    script = document.createElement("script"),
    done = false;

    script.src = url;
    
    script.onload = script.onreadystatechange = function(){
        if ( !done && (!this.readyState ||
            this.readyState == "loaded" || this.readyState == "complete") ) {
            done = true;
    
            callback();
        }
    };
    
    body.appendChild(script);
}

/**
 * Fungsi untuk inisialisasi fancy box untuk image
 */
function initImageFancyBox()
{
    $("a.zoom").fancybox({
        'titlePosition'	: 'over',
        'transitionIn'	: 'elastic',
        'transitionOut'	: 'elastic'        
    });
}

/**
 * Fungsi untuk inisialisasi fancy box untuk melihat video youtube
 */
function initYoutubeFancyBox()
{
    $("a.youtube").click(function() {
        $.fancybox({
                'padding'		: 0,
                'autoScale'		: false,
                'transitionIn'	: 'elastic',
                'transitionOut'	: 'elastic',
                'title'			: this.title,
                'width'		    : 680,
                'height'		: 495,
                'href'			: this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
                'type'			: 'swf',
                'swf'			: {
                    'wmode'		     : 'transparent',
                    'allowfullscreen': 'true'
                }
            });

        return false;
    });
}

function initTinyMce()
{
    
}

