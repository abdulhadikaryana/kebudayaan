/**
 * destination.js
 *
 * Javascript yang berisi fungsi2 yang digunakan di halaman destinasi
 *
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 */

$(function() {
    $('a.ajax').click(function (event) {
         event.preventDefault();
    });
    
    $("#all-gallery").fancybox({
        'width' : 940,
        'height' : 450,
        'transitionIn'  : 'none',
        'transitionOut' : 'none',
        'type'  : 'iframe',
        'onCleanup' : function() {
            $('div#fancybox-outer').removeAttr("style")
        }
    });

    $("#rating-dest-user").children().not(":radio").hide();
    $("#rating-dest-user").stars({
        cancelShow: false,
        callback: function(ui, type, value)
        {
            $('#rating-user').append('<img id="loader" src="' + imageUrl + '/loader/fb.gif" alt="" />');

            $("#rating-dest-user").hide();
 
            $.post(baseUrl + '/ajax/star', {rate: value, poiId: destId}, function(db)
            {
                $(".rating").stars("select", Math.round(db.rating));
                $(".user-rated").html(db['rating'] + '/5 (' + db.totalrater + ' votes)');
                $("#rating-all").effect("highlight", {}, 1000);

                $('#loader').remove();
                $("#rating-dest-user").show();

            }, "json");
        }
    });

});

/**
 * Fungsi untuk mendapatkan konten berdasarkan tipe informasi destinasi
 * yang berupa todo, tostay, getaround, dsb
 *
 * @param {Integer} type tipe informasi destinasi
 */
function getContent(type)
{
    hideCurrentContent();
    
    $('#dest-content').html("<div class='content-preloader'><span>"+loadingLabel+"</span><br/><img src='" + 
        imageUrl + "/ajax-loader-big.gif' alt='' /></div>");

    $.ajax({
       type: "POST",
       url: baseUrl + '/destination/' + destId + '/' + destTitle + '/' + type,
       data: {type: type, id: destId},
       success: function(data){
            showNewContent(data);
       }
    });
}

/**
 * Fungsi untuk menyembunyikan konten yg sekarang
 */
function hideCurrentContent()
{
    $('#dest-location').hide();
    $('#dest-title').hide();
    $('#dest-gallery').hide();
    $('#breadcrumb').remove();
}

/**
 * Fungsi untuk memunculkan konten hasil ajax dan konten lainnya yg tadi
 * disembunyikan
 *
 * @param {String} data
 */
function showNewContent(data)
{
    $('#dest-content').hide();
    $('#dest-content').html(data);
    $('#dest-content').fadeIn(1000);
    $('#dest-location').fadeIn(1000);
    $('#dest-title').fadeIn(1000);
    $('#dest-gallery').fadeIn(1000);

    $('#breadcrumb').insertBefore('#dest-title');
}

