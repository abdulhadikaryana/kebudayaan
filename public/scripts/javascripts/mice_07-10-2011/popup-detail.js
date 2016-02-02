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
			$.post(rootUrl+'/mice/en/search/detail-description',
			{
				entity_id : id,
			},
			function(data){
				if(data.result)
				{
					$('.thumbnails').attr('src',src);
					$('#h-title').html(title);
					$('#desc-content').html(data.result);

					$.blockUI({ 
			            message: $('#detail-description'), 
			            fadeIn: 700, 
			            fadeOut: 700, 
			            //timeout: 2000, 
			            showOverlay: true, 
			            //centerY: false, 
			            css: { 
			                width: 'auto', 
			                top: '100px', 
			                left: '220px', 
			                //right: '10px', 
			                cursor: 'default', 
							border: 'none', 
			                padding: '5px', 
			                backgroundColor: '#000', 
			                '-webkit-border-radius': '10px', 
			                '-moz-border-radius': '10px',
							'border-radius': '10px',
							 
			                //opacity: .6, 
			                color: '#000',
							textAlign : 'left'
			            } 
			        });
					
					$('.exit-button').click(function(){
						$.unblockUI();
					});

				}
			},'json');
			//console.log(src);
	        

	}); 

//	$('.detail').ajaxStart(function(){
//       $.blockUI({
//            message: 'Please wait ...',
//            fadeIn: 700,
//            showOverlay: true,
//            centerY: false,
//            css: {
//                width: '350px',
//                top: '240px',
//                left: '380px',
//                //right: '10px',
//                border: 'none',
//                padding: '12px',
//                backgroundColor: '#000',
//                '-webkit-border-radius': '10px',
//                '-moz-border-radius': '10px',
//				'border-radius': '10px',
//                opacity: .8,
//                color: '#fff'
//            }
//        });
//
//	});

});