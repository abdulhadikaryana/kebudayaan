jQuery(document).ready(function(a){a(".rwmb-file-advanced-upload").each(function(){var e=a(this),c=e.siblings(".rwmb-uploaded"),b=c.data("field_id"),d=c.data("max_file_uploads"),h=c.data("mime_type"),g={className:"media-frame rwmb-file-frame",frame:"select",multiple:true,title:"Select files",button:{text:"Select"}},f;if(h){g.library={type:h}}f=wp.media(g);e.on("click",function(j){j.preventDefault();f.open()});f.on("select",function(){var k=f.state().get("selection").toJSON(),n="You may only upload "+d+" file",j=c.children().length;if(d>1){n+="s"}if(d>0&&(j+k.length)>d){if(j<d){k=k.slice(0,d-j)}alert(n)}for(i in k){var m=k[i];if(c.children("li#item_"+m.id).length>0){continue}var l={action:"rwmb_attach_file",post_id:a("#post_ID").val(),field_id:c.data("field_id"),attachment_id:m.id,_ajax_nonce:e.data("attach_file_nonce")};a.post(ajaxurl,l,function(p){var o=wpAjax.parseAjaxResponse(p,"ajax-response");if(o.errors){alert(o.responses[0].errors[0].message)}else{c.removeClass("hidden").prepend(o.responses[0].data)}if(c.children().length>=d){e.addClass("hidden")}},"xml")}})})});