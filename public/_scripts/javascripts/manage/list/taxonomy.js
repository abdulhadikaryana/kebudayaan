$(document).ready(function(){
    //alert(currentUrl);
})


var arrayEntity = [];

function initTaxonomy()
{
    var self = this;
    var tools = new initTools();
    

    //list taxonomy
    this.initListTaxonomy = function()
    {

        var tableContributor = $('#tableTaxonomy').dataTable({
                    "aoColumns":      [  null,
                                         null],
                    "bFilter"         : true,
                    "bJQueryUI"	        : true,
                    "bStateSave"      : true,
                    "sPaginationType" : "full_numbers",
                    "bProcessing"     : true,
                    "bServerSide"     : true,
                    "sAjaxSource"     : currentUrl,
                    "fnServerData"    : function(sSource, aoData, fnCallback)
                    {
        
                    //filter language 
                      if(jQuery('#filterLang').length)
                      {
                        filter_lang = jQuery('#filterLang').val()
                      }
                      else
                      {
                        filter_lang = '1';
                      }
                          
                        aoData.push({
                          "name": "filter_lang",
                          "value":  filter_lang
                        });
        
        
        
                        jQuery.getJSON(sSource, aoData, function(json) {
                            fnCallback(json)
                        });
                    }
                });

            //create parameter for filter language
            var filterHTML = '';
                    filterHTML += '<select id="filterLang">';
                    //filterHTML += '<option value="0" selected="selected">Select language</option>';
                    filterHTML += '<option value="1">English</option>';
                    filterHTML += '<option value="2">Indonesia</option>';
                    filterHTML += '</select>';
            jQuery("div.filterHTML").html(filterHTML);
    
    
            jQuery('#filterLang').live('change', function(){
                    tableContributor.fnDraw();
            });        

	//detete
	$('.delete-taxonomy').live('click',function(){
	    var taxonomySlug = $(this).attr('id');
	    var entity_id = $(this).attr('title');
            
	    if(confirm('Are you sure want to remove ? this action will be deleting '+ taxonomySlug +' data with all language ?'))
	    {
                //remove category 
                $.post(actionUrl+ '/manage/mice/actiontaxonomy',
                {
                        taxonomy_slug : taxonomySlug,
                        entity_id : entity_id,
                        language_id : $('#filterLang').val(),
                        action : 'delete'
                },
                function(data){
                        tableContributor.fnDraw();
                },'json');
        
                return true;
	    }
	    else
	    {
                return false;
	    }  
	});


    }
    
    // Save handler    
    this.initSave = function()
    {
        $('#form-new-taxonomy').submit(function(){
            
            var slug = $('#slug').val();
            var weight = $('#weight').val();
            var value = $('#value').val();
            var language = $('select[name="language"]').val();
            
            //cek slug
            if(!tools.cekValue(slug))
            {
                $('#error-slug').show();
            }
            else
            {
                $('#error-slug').hide();
            }

            //cek weight
            if(!tools.cekValue(weight))
            {
                $('#error-weight').show();
            }
            else
            {
                $('#error-weight').hide();
            }

            //cek value
            if(!tools.cekValue(value))
            {
                $('#error-value').show();
            }
            else
            {
                $('#error-value').hide();
            }

            //cek language
            if(language == 0)
            {
                $('#error-language').show();
            }
            else
            {
                $('#error-language').hide();
            }
            
            if(tools.cekValue(slug) && tools.cekValue(weight) && tools.cekValue(value) && language !=0)
            {
                $('.error').hide();
				return true;
                
                //send data to controller
/*                $.ajax({
                    type:'post',
                    cache:false,
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data:$(this).serialize(),
                    processData:    false,
                    dataType: "json",
                    success: function(data) {
                        if(data.result)
                        {
                            $('.success').show();
                            $('#slug').val('');
                            $('#weight').val('');
                            $('#value').val('');
                            $('select[name="language"] > option[value="0"]').attr('selected','selected');
                            
                            if(data.redirect)
                            {
                                window.location = actionUrl + '/manage/mice/listtaxonomy';
                            }
                        }
                        else
                        {
                            alert('Oops, error occurred while saving data!');
                        }
                
                    }
                });*/
                //alert('ok');
            }
            else
            {
                $('.success').hide();
            }
            
            
            return false;
        });
    }

}


function initTools()
{
    
    this.cekValue = function(str)
    {
        if(str == "")
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    this.removeSpaces = function (string)
    {
        return string.split(' ').join('');
    }    
    
}