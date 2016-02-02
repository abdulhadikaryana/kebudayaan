/*
    custom.validate.js
    berisi fungsi customisasi error element untuk jqeury validate
    dibuat untuk menyesuaikan letakan error message dari jquery.validate.js

    @author : tajhul,mac.
    Copyright : sangkuriang internasional 2011
    
 */


$(function(){
//    alert('test');
})


function customValidate(data)
{
    $(data.selector+" input").blur(function(){
        $(data.selector).validate().element($(this));
    });

    $(data.selector).validate({
        rules: data.fields,
        messages: data.messages,

        errorPlacement: function(error,element) {

            //jika ingin memakai custom message
            if(data.enableMessages)
            {
                switch(data.errorTagetLocation)
                {
                    case "inner" : element.parent('p').find('ul').html(error).show();
                    break;
                    case "outer" : element.parent('p').next('ul').html(error).show();
                    break;
                }
            }
            else
            {
                switch(data.errorTagetLocation)
                {
                    case "inner" : element.parent('p').find('ul').show();
                    break;
                    case "outer" : element.parent('p').next('ul').show();
                    break;
                }
            }

            return false;

        },

        wrapper: "li",
        debug:true,

        submitHandler: function(form){

                var form = data.selector;

//                 alert(form);
        }
    });

}