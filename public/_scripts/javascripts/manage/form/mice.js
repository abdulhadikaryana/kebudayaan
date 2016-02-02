

function autoComplateArea()
{

    $("#suggest-area").autocomplete(baseUrl+'/manage/mice/areafeed',
    {
        formatItem: function(data,i,max){
            var str = '<div class="search_content" style="float:left;">';
            str += data;
            str += '</div>';
            return str;
        }
    }).result(function(event, data, formatted) {
        
        //console.log(data[1]);
        
        if(data)
        {
            
            $('#area-id').val(data[1]);
            $('#error-area').hide();
            
        }
    });    
    
}





function initDelete()
{
    $('.delete').live('click',function(){
        
        var id = $(this).val();
        var filename = $('#filename-'+id).val();

        if(confirm("Are you sure want to delete "+filename+" ?"))
        {

            $.post(baseUrl+"/manage/mice/image",
            {
                opration : 'delete',
                img_type : type,
                image_id: id,
                file_name: filename
            },
            function(data){
               if(data.result)
               {
                    $('#image-'+id).remove();
               }
            }, "json");

            return true;
        }
        else
        {
            //alert('no');
            return false;
        }




    });
}

function initpublish()
{
    $('.publish').live('click',function(){
        var $checked = $(this).attr('checked');
        var is_publish;
        var id = $(this).val();
        
        if($checked)
        {
            is_publish = 1;
            //alert(baseUrl);
        }
        else
        {
            is_publish = 0;
            //alert('un publish');
        }


        $.post(baseUrl+"/manage/mice/image",
        {
            opration : 'update',
            publish: is_publish,
            image_id: id
        },
        function(data){
            if(!data.result)
            {
                alert('Error');
            }
        }, "json");

    });
}



/* save handler */
function saveHandler(){
    $('#add-mice-image').submit(function(){
        var file = $('#image').val();

        
        if(imageType == "background")
        {

            if(file.length == 0)
            {
                $('#error-image').fadeIn();
                return false;
            }
            else
            {
                $('#error-image').hide();
                return true;
            }
            
        }
        else
        {

            var suggestArea = $('#suggest-area').val();
    
            if(file != "" && suggestArea != "")
            {
                //alert('asas');
                $('.error').hide();
                return true;
            }
            else if(file == "" && suggestArea == "")
            {
                $('.error').fadeIn();
                return false;
            }
    
            if(suggestArea == "")
            {
                $('#error-area').fadeIn();
                return false;
            }
            else
            {
            
                $('#error-area').hide();
                return false;
            }
            
            if(file.length == 0)
            {
                $('#error-image').fadeIn();
                return false;
            }
            else
            {
                $('#error-image').hide();
                return false;
            }
            
        }

    });
}
