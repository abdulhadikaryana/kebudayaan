$(function(){

    //event ketika tombol cancel diklik maka akan diredirect ke halaman list micedestination
    $('#cancel').click(function(){
        window.location = listurl;
    });
    $('#back_to_list').click(function(){
        window.location = listurl;
    });

    // SIMPLE VALIDATION
    var data = []; //deklarasikan array untuk menampung flag validasi

    $('#formMiceArticle').submit(function(){

        data.length = 0; //reset array setiap kali event submit form


        $(this).find('textarea,input[type="text"],select,input[type="hidden"]').each( function(){
            var val = '';
            var id = $(this).attr('id'); // untuk mendapatkan id element
            var tagName = jQuery(this).get(0).tagName; // untuk tag name html

            //tag name diperlukan untuk filtering ketika mengambil value element
            // jika tag name textarea
            if(tagName == "textarea" || tagName == "TEXTAREA")
            {
                val = tinyMCE.get(id).getContent({format : 'text'});
            }
            else
            {
                val = $(this).val();
            }

            //jika value-nya kosong, maka tampilakan element error message, dan push flag 0 ke dalam array data
            if(val == "" || val == 0)
            {
                $('#image').show();
                $('#error-'+id).show();
                data.push(0);
            }
            else
            {
                //jika value-nya tidak kosong, maka sembunyikna element error message, dan push flag 1 ke dalam array data
                $('#error-'+id).hide();
                data.push(1);
            }
        });

        //lakukan pengecekan element array
        //jika dalam array data terdapat element 0, itu berari masih ada field yg belum diisi dan me- return false
        if(in_array(0,data))
        {
            return false;
        }
        else
        {
            //jika tidak dalam state edit
            if(!edit)
            {
                storeContent(true);

                $(this).ajaxSubmit(formOption);
                return false;
            }
            else
            {
                return true;
            }
        }
    });

    var formOption = {
        beforeSubmit : prepareData,
        error: function(response, status, err){

        },
        success : formResponse,
        dataType: 'json',
        data : {
            content : ''
        }
    };
});

function formResponse(data)
{
    if(data.hasil){
        $('#content-mice-destination').hide();
        $('#notif-mice-destination').show();
    }
    else{
        alert('Error!');
        return false;
    }
}
function prepareData(arr, formObj, options)
{
   options.data.content = JSON.stringify(content);
}

/**
* fungsi in_array
* untuk mencari sebuah element di dalam suatu array
* @param : (element yg akan dicari, array).
**/
function in_array( what, where ){
    var status=false;
    for(var i=0;i<where.length;i++){
      if(what == where[i]){
        status=true;
        break;
      }
    }
    return status;
}
