/**
* popup-detail.js
* Berisi fungsi untuk menampilkan detail sebuah M.I.C.E dalan layer modal
**/
$(function(){

	$('.detail').click(function() {
        var id = $(this).attr('id');
        var title = $(this).text();
        var src = $('.image-'+id).attr('src');

        //remove category
        $.post(rootUrl+'/mice/en/search/entitydetail',
        {
            entity_id : id
        },
        function(data)
        {
            if(data != null)
            {
                $('#detail-description').html(data);
                $.blockUI({
                    message: $('#detail-description'),
                    fadeIn: 700,
                    fadeOut: 700,
                    showOverlay: true,
                    css: {
                        width: 'auto',
                        top: '100px',
                        left: '220px',
                        cursor: 'default',
                        border: 'none',
                        padding: '5px',
                        backgroundColor: '#00A9E7',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        'border-radius': '10px',
                        'box-shadow': '0 1px 5px #FF0000',
                        color: '#000',
                        textAlign : 'left'
                    }
                });

                $('.exit-button').click(function(){
                    $.unblockUI();
                });
            }
        },'html');
	});

    $('body').ajaxStart(function(){
       $.blockUI({
            message: 'Please wait ...',
            fadeIn: 700,
            showOverlay: true,
            centerY: false,
            css: {
                width: '350px',
                top: '240px',
                left: '380px',
                border: 'none',
                padding: '12px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                'border-radius': '10px',
                opacity: .8,
                color: '#fff'
            }
        });
    });
    
});