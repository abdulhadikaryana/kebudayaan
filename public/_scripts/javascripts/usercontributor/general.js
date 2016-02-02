/**
 * General.js = file js yg berisi fungsi2 yg digunakan untuk viewer user contributor
 * 
 * note : kalau ada fungsi yang sudah tidak dipakai harap dihapus saja
 * karena akan mengakibatkan error di minify-nya, efeknya js nya kaya yang
 * engga ke load
*/

/**
 * Ready function
*/
$(function() {

//    alert('test');
    initFB();
    
    initRating(rateReadOnly);
    
    //Fungsi Login form pada login.js
    onSignInClick();
    
    initComment();

    initFuncyBox();
    
    initAnchor();
    
    //window.setInterval(initPopularPost,10000);
    //initPopularPost();
    //alert('abscde');
    
    $('#signIn').live('click',function(){
	//alert('asas');
	//$('#temp').html('<input type="text" name="url" value="'+ currentUrl +'" />');
	//$('#loginForm').attr('action',baseUrl+'/logincontributor/index');
    });
});

/*
* untuk mengupdate postingan popular post
*/
function initPopularPost(){
    window.setInterval(queries,60000);
    //var n = window.setInterval(ab(1),1000);
    //conloe
}
function ab(param){
   return param++;
}
function queries(){
    $('#wait-query').ajaxStart(function() {
        $('#headline-post').hide();
        $(this).show();
    });
    
    $('#wait-query').ajaxStop(function() {
        $(this).hide();
        $('#headline-post').show();
    });

    //alert(url);
    $.ajax({
        type: 'POST',
        url: baseUrl+'/usercontributor/popularpost',
        //data: str,
        dataType : 'json',
        success: function(data){
            //console.log(data.result);
            $('#headline-post').html(data.result);
        }
    });
}

/*
* untuk animate ketika klik anchor yang menuju kesuatu target
**/
function initAnchor(){
    $('.anchorLink').click(function(){
    });
}

/*
    init fancy zoom
*/
function initFuncyBox(){

    $('.post-info .foto .zoom-contributor').each(function(){
         $(this).fancybox({
            'transitionIn': 'none',
            'transitionOut': 'none',
            'titlePosition': 'over',
            'titleFormat': function(title, currentArray, currentIndex, currentOpts) {
                return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
            }
	    });
    });

    $('.post-preview .zoom-photoessay').each(function(){
         $(this).fancybox({
            'transitionIn': 'none',
            'transitionOut': 'none',
            'titlePosition': 'over',
            'titleFormat': function(title, currentArray, currentIndex, currentOpts) {
                return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
            }
	    });
    });
}

//comment form
function initComment(){
    $('.link-reply').fancybox({
        'transitionIn'		: 'elastic',
        'transitionOut'		: 'elastic',
        'autoScale'             : false,
        'type'                  : 'iframe'
    });
}

/**
 * Fungsi untuk handler rating content
 * @param : rateReadOnly ->true berarti rating hanya readonly
*/
function initRating(rateReadOnly){
    $('.rate').each(function(index) {
        var id = $(this).attr('id');
        var start = $(this).attr('title');
        
        //rate content    
        $('#rate'+id).raty({
            click: function(score, evt) {
                //alert('ID: ' + this.attr('id') + '\nscore: ' + score + '\nevent: ' + evt);
                $.post(baseUrl+'/usercontributor/rating',
                {
                    userstory_id : id,
                    score_rating : score
                },
                function(data){
                    //console.log(data.result);
                }, "json");
    
            },
            path : imageUrl+'/usercon/rating/',
            start : start,
            readOnly: rateReadOnly
        });

        //rate author
        $('#rate-author'+id).raty({
            click: function(score, evt) {
                //alert('ID: ' + this.attr('id') + '\nscore: ' + score + '\nevent: ' + evt);
                $.post(baseUrl+'/usercontributor/ratingauthor',
                {
                    author_id : id,
                    score_rating : score
                },
                function(data){
                    //console.log(data.result);
                }, "json");
    
            },
            path : imageUrl+'/usercon/rating/',
            start : start,
            readOnly: rateReadOnly
        });            

    });
}


/**
 * Fungsi untuk inisialisasi facebook
 *
*/
function initFB(){
  window.fbAsyncInit = function() {
    FB.init({appId: fbAppId, status: true, cookie: true,xfbml: true});

    FB.Event.subscribe('auth.login', function(response) {
        login();
      // do something with response.session
    });

    FB.Event.subscribe('auth.logout', function(response) {
        // do something with response
        logout();
    });

  };
  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +'//connect.facebook.net/en_US/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());    
}



function login(){
    document.location.href = baseUrl+'/login/facebook';
}
function logout(){
    document.location.href = baseUrl+'/login/logoutcontributor/'+currentUrl;
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
    linkSplit = link.split("/");
	linkSplit[3] = lang;
    
	var linkBaru = linkSplit.join("/");

    if((lang == 'en') || (lang == 'id'))
    {
        setCookie('languageName',lang,5);
    }
    
	if ((lang == 'de')||(lang == 'jp')||(lang == 'ar')||(lang == 'ru')||(lang == 'id')||(lang == 'en'))
    {
        switch(lang)
        {
            case 'en' : window.location = linkBaru;
                      break;   
            case 'id' : window.location = linkBaru;
                      break;   
            case 'de' : window.open('http://www.tourismus-indonesien.de');
                      break;
            case 'jp' : window.open('http://www.visitindonesia.jp/');
                      break;
            case 'ar' : window.open('http://visit-indonesia.ae/');
                      break;
            case 'ru' : window.open('http://www.go-to-indonesia.ru/');
                      break;
        }
    }else{
        window.open(rootUrl + '/' + lang + restUrl);
		//setCookie('languageName',lang,5);
    }
}




/*
* Fungsi untuk men-sort content author
* param = date, popular post
*/

$('#sort-by').change(function(){
    var param = $(this).val();
    var authorId = parseInt($('#author-id').text());

    var newUrl;
    var makeUrl;
    var link = [];
    var old_url = document.URL;
    var url = old_url;

    link = url.split("/");
    
    
    if(link.length == 14)
    {
        link.splice(13,1);
        var x = implode('/',link);

        newUrl = x+'/'+param;
        //console.log(newUrl);

    }else{
        
        /*
        * http://localhost/budpar2010/public/en/usercontributor/author/page/2/id/1/name/ardiansyah+Hendrakusuma/sort/default
        * remove ruas /page/2/
        **/
        link.splice(8,2);


        /*
        * http://localhost/budpar2010/public/en/usercontributor/author/id/1/name/ardiansyah+Hendrakusuma/sort/default
        * remove ruas /default
        **/
        link.splice(13,1);

        var x = implode('/',link);
        
        /*
        */
        
        newUrl = x+'/'+param;
        //console.log(newUrl);

    }
    
    window.location = newUrl;

});