/**
 * jQuery datatables initialitation for MICE list
 */

var arrayTaxonomy = [];
var add = 0;

$(function(){
	var tableContent = $('#mice_list').dataTable({
        "aoColumns"		  : [ null, {"bSortable" : false}, {"bSortable" : false}],
        "bFilter"         : true,
        "bStateSave"      : true,
        "sPaginationType" : "full_numbers",
        "bJQueryUI"		  : true,
        "bProcessing"     : true,
        "bServerSide"     : true,
        "sAjaxSource"     : feedUrl
	});	

	//add entity
	$('.add-taxonomy').live('click',function(){
		var entity_id = $(this).attr('id');
		var entity_name = $('#name'+entity_id).text();
		

		$.blockUI({ 
		     message: $('#taxonomy-entity'), 
		     css: {
			top: '15%',
			left: '14%',
			background : 'transparent',
			border : 'none',
			cursor : 'default',
			width : '1000px',
			height : '950px',
			padding : '0px',
			textAlign : 'left'
			} 
		 });


		$('#entity-name').val(entity_name);
		$('#entity-id').val(entity_id);
	
		//cek taxomony entity
		$.post(actionUrl,
		{
			entity_id : entity_id,
			action : 'cek_entity'
		},
		function(data){
			
			arrayTaxonomy = data.array;
			
			var len = data.array.length;
			
			if(len > 0)
			{
				$('#listTaxonomy').show();
				
				for(i=0;i<len;i++)
				{
					var html = '<span id="ent-'+data.array[i]+'" class="entity" title="click to remove">'+ data.array[i] +'</span>';
					$('#listTaxonomy').append(html);
				}
				
			}
			
		},'json');
	});
	$('#cancel').live('click',function(){
		clearFormEntity();
		$.unblockUI();
	})

	suggestTaxonomy();
});


function suggestTaxonomy()
{
	
	//suggest taxonomy
	$("#suggest-taxonomy").autocomplete(url+'/manage/mice/suggestentity',
	{
		formatItem: function(data,i,max){
			var str = '<div class="search_content" style="float:left;">';
			str += data;
			str += '</div>';
			return str;
		}
	}).result(function(event, data, formatted) {
		var taxonomy_name = $(data[0]).attr('id');

			var flag = jQuery.inArray(taxonomy_name,arrayTaxonomy);
			if(flag < 0)
			{
				add = 1;
				//if value not found in the arrayTaxonomy
				arrayTaxonomy.push(taxonomy_name); 
				//push the value to the arrCategory
				$(this).val('');
				var htmlCat = '<span class="entity" id="ent-'+taxonomy_name+'" title="click to remove">'+ taxonomy_name +'</span>';
				$('#listTaxonomy').show();
				$('#listTaxonomy').append(htmlCat);
			
			}else{
				add = 0;
				$(this).val('');
				 alert('Entity already exists');
			}

	});
	
	//delete entity
	$('.entity').live('click',function(){
		var taxonomy_slug = $(this).text();
		var entity_id = $('#entity-id').val();

		//delete data
		$.post(url+'/manage/mice/deletetaxonomyentity',
		{
			entity_id : entity_id,
			taxonomy_slug :taxonomy_slug
		},
		function(data){
			
			if(data.result)
			{
				//remove from array
				arrayTaxonomy = jQuery.grep(arrayTaxonomy, function(value) {
					 return value != taxonomy_slug;
				});
				
				//remove from list
				$('#ent-'+taxonomy_slug).remove();
				add = 0;
	
				if(arrayTaxonomy.length == 0)
				{
					$('#listTaxonomy').hide();
				}
	
			}
			
				
		},'json');

	});


	//save data relation entity <-> taxonomy
	$('#add-taxonomy-entity').submit(function(){

		if(add > 0)
		{
			var entity_id = $('#entity-id').val();
	
			$.ajax({
				cache:false,
				type: $(this).attr('method'),
				url: $(this).attr('action'),
				data:"entity_id="+entity_id+"&array=" + JSON.stringify(arrayTaxonomy),
				processData:    false,
				dataType: "json",
				success: function(data) {
				
					if(data.result)
					{
						clearFormEntity();
						
						$.unblockUI();
					}
					else
					{
						$.unblockUI();
					}
	
				}
			});			
		}
		else
		{
			alert('Please choose taxonomy');
			$('#suggest-taxonomy').focus();
		}


	
		return false;
	});

}

function clearFormEntity()
{
	$('#entity-id').val('');
	$('#entity-name').val('');

	if(arrayTaxonomy.length > 0)
	{
	    $('#listTaxonomy').empty().hide();
	    arrayTaxonomy = [];
	}

}