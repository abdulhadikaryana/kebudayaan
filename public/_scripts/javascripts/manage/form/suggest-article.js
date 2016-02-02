/*
    Fungsi
    auto suggest untuk user ontributor
*/
function suggestUser(baseUrl){
    $("input#suggest-user").autocomplete(baseUrl+'/manage/suggest/usercontributor',
    {
        formatItem: function(data,i,max){
            var str = '<div class="search_content" style="float:left;">';
            str += data;
            str += '</div>';
            return str;
        }
    }).result(function(event, data, formatted) {
        
        var user_id = $(data[0]).attr('id');
        if(user_id > 0)
        {
            $('#usercontribId').val(user_id);
            $(this).val($(formatted).text());
            $(this).attr('disabled','disabled');
            $('#change-contributor').show();
            $('#error-usercontrib').hide();
            
            changeContributor();
            
        }
        else
        {
            $('#usercontribId').val('');
            $(this).val($(formatted).text());
            changeContributor();
        }
    });
}

function changeContributor(){
    $('#change-contributor').click(function(){
        $('#suggest-user').removeAttr('disabled');
        $('#suggest-user').val('');
        $('#suggest-user').focus();
        $(this).hide();
    })
}

function changeLang()
{
    $("input#suggest").setOptions({
    extraParams: {
      lang_id: $('#choose-language').val()
    }
    }).flushCache();
}