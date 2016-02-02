/* save handler */
function editAction(){
    
    $('.change-photo').live('click',function(){
        $('#p-photo').show();
        $(this).hide();
        $('#change-foto').val(1);
    });
    
    
    
    $('#edit-contributor').submit(function(){
        var nama = $('input[name="name"]').val();
        var email = $('input[name="email"]').val();
        var moto = $('input[name="moto"]').val();
        
        if(nama == "" && email == "" || moto == "")
        {
            $('.must').fadeIn();
            return false;
        }
        else if(nama != "" && email != "" && moto != "")
        {
            $('.must').hide();
            return true;
            alert('ok');
        }
        
        
        if(nama == "")
        {
            $('#error-name').fadeIn();
            return false;
        }
        else
        {
            $('#error-name').hide();
            return false;
        }

        if(email == "")
        {
            $('#error-email').fadeIn();
            return false;
        }
        else
        {
            $('#error-email').hide();
            return false;
        }        

        if(moto == "")
        {
            $('#error-moto').fadeIn();
            return false;
        }
        else
        {
            $('#error-moto').hide();
            return false;
        }
        
    });
}

/* save handler */
function saveHandler(){
    $('#add-contributor').submit(function(){
        var nama = $('input[name="name"]').val();
        var email = $('input[name="email"]').val();
        var moto = $('#moto').val();
        
        if(nama == "" && email == "" || moto == "")
        {
            $('.must').fadeIn();
            return false;
        }
        else if(nama != "" && email != "" && moto != "")
        {
            $('.must').hide();
            return true;
            //alert('ok');
        }
        
        
        if(nama == "")
        {
            $('#error-name').fadeIn();
            return false;
        }
        else
        {
            $('#error-name').hide();
            return false;
        }

        if(email == "")
        {
            $('#error-email').fadeIn();
            return false;
        }
        else
        {
            $('#error-email').hide();
            return false;
        }        

        if(moto == "")
        {
            $('#error-moto').fadeIn();
            return false;
        }
        else
        {
            $('#error-moto').hide();
            return false;
        }
        

    });
}
