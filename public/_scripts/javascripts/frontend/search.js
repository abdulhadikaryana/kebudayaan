/*
    searh.js
    @author tajhul
*/



function hideNav()
{
    if(($('#allpage_news').val()) > 1){
        $('#nav_news').show();
        $('#linkpage_news').show();
    }
}

function funcyAction(){
    //objek kumabang
    //console.log($('#gallery_content li a'));
    $('#gallery_content li a').each(function(){
            $(this).fancybox();
    });
}


/*
    ajaxPagination(url,limit);
    parameter :
        url = url action
        limit = limit page
*/
function ajaxPagination(url,limit){

    $('#boxLoading').ajaxStart(function() {
        $(this).show();
    });
    
    $('#boxLoading').ajaxStop(function() {
        $(this).hide();
    });

    $('.next').removeAttr('disabled');
    $('.last').removeAttr('disabled');
    $('#curpage_news').val(1);
    $('#curpage_event').val(1);
    $('#curpage_dest').val(1);
    $('#curpage_article').val(1);
    $('#curpage_gallery').val(1);
    

    funcyAction();

    hideNav();
    

    
    //default active tab
    $('.content').hide();
    $('#content_all').show();

    $('.navigation').hide();
        
    $('.tabsearch').click(function(){
        var id = $(this).attr('id');

        var content_id = ($(this).attr('id')).substr(4);
        $('.content').hide();
        $('.navigation').hide();
        $('.linkpages').hide();


        $('#content_'+id).show();
        
        
        $('#tabs li a').removeClass('active');
        $(this).addClass('active');
                
        var allpage = $('#allpage_'+id).val();


        if(allpage > 1)
        {
                $('#nav_'+id).show();
                $('#linkpage_'+id).show();
        }        
        if(allpage > 5){
            $('#first_'+id).show();
            $('#last_'+id).show();
        }else{
            $('#firsts_'+id).hide();
            $('#last_'+id).hide();
        }

    
    });

        
    $('.next').click(function(){
      
      var methodAction = ($(this).attr('id')).substr(5);
      var id = methodAction;
  
      $.post(url+methodAction+'paging',
      {
  
        paramOffset: $('#offset_'+id).val(),
        paramKey: $('#param_'+id).val(),
        paramPage : $('#curpage_'+id).val(),
        paramLimit : limit,
        actionQuery: "next"
      },
      function(data){
        
        //alert(data.result);
        $('#'+id+'_content').html(data.result);
            funcyAction();
          
            var awal		= data.start;
            var akhir		= data.end;
            var per_page	= data.per_pages;
            var cur_page	= data.cur_pages;
            var link_page	= '';
            
            //alert(cur_page);
     
            //GENERATE LINK PAGES
            for (var loop = awal -1; loop <= akhir; loop++)
            {
                var link_offset = (loop * per_page) - per_page;
                var get_curpage = loop;
                //var get_curpage = loop - 1;
            
                if (link_offset >= 0)
                {
                    if (cur_page == loop)
                    {
                            link_page += '<div class="cur_page">'+loop+'</div>';
                    }
                    else
                    {
                            var n = (link_offset == 0) ? '' : link_offset;
                            
                            link_page += '<div class="pages '+id+'" title="'+get_curpage+'">'+loop+'</div>';

                    }
                }
            }
          
          $('#linkpage_'+id).html(link_page);
          
          $('#offset_'+id).attr('value',data.offset);
          $('#curpage_'+id).attr('value',data.curpages);
          
            $('#prev_'+id).removeAttr('disabled','disabled');
            $('#prev_'+id).removeClass('passive');
    
            $('#firsts_'+id).removeAttr('disabled','disabled');
            $('#firsts_'+id).removeClass('passive');
            
            if(($('#allpage_'+id).val()) == data.curpages)
            {
              $('#next_'+id).attr('disabled','disabled');
              $('#next_'+id).addClass('passive');
    
              $('#last_'+id).attr('disabled','disabled');
              $('#last_'+id).addClass('passive');
            }
              
            linkPage('',url,limit);
    
        }, "json");
      
      
      })  
    
      $('.prev').click(function(){
        
        var methodAction = ($(this).attr('id')).substr(5);
        var id = methodAction;
    
        $.post(url+methodAction+'paging',
        {
          paramOffset: ($('#offset_'+id).val())-(parseInt(limit))*2,
          paramKey: $('#param_'+id).val(),
          paramPage : $('#curpage_'+id).val(),
          paramLimit : limit,
          actionQuery: "prev"
        },
        function(data){
          
          $('#'+id+'_content').html(data.result);
              funcyAction();
    
                    var awal		= data.start;
                    var akhir		= data.end;
                    var per_page	= data.per_pages;
                    var cur_page	= data.cur_pages;
                    var link_page	= '';
            
                    //GENERATE LINK PAGES
                    for (var loop = awal -1; loop <= akhir; loop++)
                    {
                            var link_offset = (loop * per_page) - per_page;
                            var get_curpage = loop;
                            //var get_curpage = loop - 1;
                    
                            if (link_offset >= 0)
                            {
                                    if (cur_page == loop)
                                    {
                                            link_page += '<div class="cur_page">'+loop+'</div>';
                                    }
                                    else
                                    {
                                            var n = (link_offset == 0) ? '' : link_offset;
                                            
                                            link_page += '<div class="pages '+id+'" title="'+get_curpage+'">'+loop+'</div>';
    
                                    }
                            }
                    }
          
          //alert(link_page);
          $('#linkpage_'+id).html(link_page);
          
          $('#offset_'+id).attr('value',data.offset);
          $('#curpage_'+id).attr('value',data.curpages);
          
                    $('#next_'+id).removeAttr('disabled','disabled');
                    $('#next_'+id).removeClass('passive');
            
                    $('#last_'+id).removeAttr('disabled','disabled');
                    $('#last_'+id).removeClass('passive');
                    
                    if(data.curpages == 1)
                    {
                      $('#prev_'+id).attr('disabled','disabled');
                      $('#prev_'+id).addClass('passive');
            
                      $('#firsts_'+id).attr('disabled','disabled');
                      $('#firsts_'+id).addClass('passive');
            
                    }
            
            linkPage('',url,limit);
        }, "json");
      
      
      })


    $('.first').click(function(){
        var id = ($(this).attr('id')).substr(7);
        //alert();
    
        $.post(url+id+'paging',
        {
          paramOffset: 0,
          paramKey: $('#param_'+id).val(),
          paramPage : 0,
          paramLimit : limit,
          actionQuery: ""
        },
        function(data){
          
          $('#'+id+'_content').html(data.result);
            funcyAction();
    
            var awal		= data.start;
            var akhir		= data.end;
            var per_page	= data.per_pages;
            var cur_page	= data.cur_pages;
            var link_page	= '';
            
            //GENERATE LINK PAGES
            for (var loop = awal -1; loop <= akhir; loop++)
            {
                var link_offset = (loop * per_page) - per_page;
                var get_curpage = loop;
                //var get_curpage = loop - 1;
            
                if (link_offset >= 0)
                {
                    if (cur_page == loop)
                    {
                        link_page += '<div class="cur_page">'+loop+'</div>';
                    }
                    else
                    {
                        var n = (link_offset == 0) ? '' : link_offset;
                        
                        link_page += '<div class="pages '+id+'" title="'+get_curpage+'">'+loop+'</div>';
    
                    }
                }
            }
          
          //alert(link_page);
          $('#linkpage_'+id).html(link_page);
          
          $('#offset_'+id).attr('value',data.offset);
          $('#curpage_'+id).attr('value',data.curpages);
          
          $('#next_'+id).removeAttr('disabled','disabled');
          $('#next_'+id).removeClass('passive');

          $('#last_'+id).removeAttr('disabled','disabled');
          $('#last_'+id).removeClass('passive');
          
          if(data.curpages == 1)
          {
            $('#prev_'+id).attr('disabled','disabled');
            $('#prev_'+id).addClass('passive');

            $('#firsts_'+id).attr('disabled','disabled');
            $('#firsts_'+id).addClass('passive');

          }
    
        linkPage('',url,limit);
    
        }, "json");

    })


    $('.last').click(function(){
        var id = ($(this).attr('id')).substr(5);
        
        var tmp_offset = limit;
        var lastpage = $('#paramlast_'+id).val();
        var offset = (tmp_offset * lastpage)-tmp_offset;
        //alert(offset);


        $.post(url+id+'paging',
        {
        
          paramOffset: offset,
          paramKey: $('#param_'+id).val(),
          paramPage : ($('#paramlast_'+id).val())-1,
          paramLimit : limit,
          actionQuery: "next"
        },
        function(data){
          
          $('#'+id+'_content').html(data.result);
                  funcyAction();
        
            var awal		= data.start;
            var akhir		= data.end;
            var per_page	= data.per_pages;
            var cur_page	= data.cur_pages;
            var link_page	= '';
            
            //GENERATE LINK PAGES
            for (var loop = awal -1; loop <= akhir; loop++)
            {
                var link_offset = (loop * per_page) - per_page;
                var get_curpage = loop;
                //var get_curpage = loop - 1;
            
                if (link_offset >= 0)
                {
                    if (cur_page == loop)
                    {
                        link_page += '<div class="cur_page">'+loop+'</div>';
                    }
                    else
                    {
                        var n = (link_offset == 0) ? '' : link_offset;
                        
                        link_page += '<div class="pages '+id+'" title="'+get_curpage+'">'+loop+'</div>';
        
                    }
                }
            }
          
          $('#linkpage_'+id).html(link_page);
          
          $('#offset_'+id).attr('value',data.offset);
          $('#curpage_'+id).attr('value',data.curpages);
          
          $('#prev_'+id).removeAttr('disabled','disabled');
          $('#prev_'+id).removeClass('passive');

          $('#firsts_'+id).removeAttr('disabled','disabled');
          $('#firsts_'+id).removeClass('passive');
          
          if(($('#allpage_'+id).val()) == data.curpages)
          {
            $('#next_'+id).attr('disabled','disabled');
            $('#next_'+id).addClass('passive');

            $('#last_'+id).attr('disabled','disabled');
            $('#last_'+id).addClass('passive');
          }
        
        linkPage('',url,limit);
        
        }, "json");

    })

      
    linkPage('',url,limit);

}


function linkPage(param_id,url,limit){
$('.pages').click(function(){
    
    $.blockUI({ message: $('#ajax-message') });
    
    if(param_id)
    {
        var id = param_id;
    }else{
        var id = ($(this).attr('class')).substr(6);
    }
    
    
    var page = $(this).attr('title');

    var key = $('#param_'+id).val();
    //var limit = "<?php echo $this->limit;?>";
    var offset = (page-1)*limit;
    //var offset = $('#offset_'+id).val();

    //alert(offset);

    $.post(url+id+'paging',
    {
      paramOffset: offset,
      paramKey: key,
      paramPage : page-1,
      paramLimit : limit,
      actionQuery: ""
    },
    function(data){
      
      $('#'+id+'_content').html(data.result);
	  funcyAction();

		var awal		= data.start;
		var akhir		= data.end;
		var per_page	= data.per_pages;
		var cur_page	= data.cur_pages;
		var link_page	= '';
        
 		//GENERATE LINK PAGES
		for (var loop = awal -1; loop <= akhir; loop++)
		{
			var link_offset = (loop * per_page) - per_page;
			var get_curpage = loop;
			//var get_curpage = loop - 1;
		
			if (link_offset >= 0)
			{
				if (cur_page == loop)
				{
					link_page += '<div class="cur_page">'+loop+'</div>';
				}
				else
				{
					var n = (link_offset == 0) ? '' : link_offset;
					
					link_page += '<div class="pages '+id+'" title="'+get_curpage+'">'+loop+'</div>';

				}
			}
		}
      
      //alert(link_page);
      $('#linkpage_'+id).html(link_page);
      
      $('#offset_'+id).attr('value',data.offset);
      $('#curpage_'+id).attr('value',data.curpages);
      

        linkPage('',url,limit); //memanggil fungsi dirinya sendiri
    
    //alert(data.curpages);

    //jika current page lebih besar dari 1    
    if(data.cur_pages == 1)
    {
      $('#prev_'+id).attr('disabled','disabled');
      $('#prev_'+id).addClass('passive');
    
      $('#firsts_'+id).attr('disabled','disabled');
      $('#firsts_'+id).addClass('passive');
    
    }else{
        $('#prev_'+id).removeAttr('disabled','disabled');
        $('#prev_'+id).removeClass('passive');
        
        $('#firsts_'+id).removeAttr('disabled','disabled');
        $('#firsts_'+id).removeClass('passive');
    }

    //jika current page sama dgn total page    
    if(data.cur_pages == ($('#allpage_'+id).val()))
    {
        $('#next_'+id).attr('disabled','disabled');
        $('#next_'+id).addClass('passive');
    
        $('#last_'+id).attr('disabled','disabled');
        $('#last_'+id).addClass('passive');
    
    }else{
        $('#next_'+id).removeAttr('disabled','disabled');
        $('#next_'+id).removeClass('passive');
    
        $('#last_'+id).removeAttr('disabled','disabled');
        $('#last_'+id).removeClass('passive');
    }

    }, "json");

})

}