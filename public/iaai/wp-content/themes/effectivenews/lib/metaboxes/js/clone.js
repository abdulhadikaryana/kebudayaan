jQuery(document).ready(function(c){b();function a(g){var e=g.find(".rwmb-clone:last"),f=e.clone(),g,d;f.insertAfter(e);g=f.find(":input");g.val("");d=g.attr("name").replace(/\[(\d+)\]/,function(h,i){return"["+(parseInt(i)+1)+"]"});g.attr("name",d);b(g);if("function"===typeof rwmb_update_color_picker){rwmb_update_color_picker()}if("function"===typeof rwmb_update_date_picker){rwmb_update_date_picker()}if("function"===typeof rwmb_update_time_picker){rwmb_update_time_picker()}if("function"===typeof rwmb_update_datetime_picker){rwmb_update_datetime_picker()}}c(".add-clone").click(function(){var g=c(this).parents(".rwmb-input"),e=c(this).parents(".rwmb-field").attr("clone-group");if(e){var f=c(this).parents(".inside");var d=f.find('div[clone-group="'+e+'"]');c.each(d.find(".rwmb-input"),function(h,i){a(c(i))})}else{a(g)}b(g);return false});c(".rwmb-input").delegate(".remove-clone","click",function(){var h=c(this),i=h.parents(".rwmb-input"),f=c(this).parents(".rwmb-field").attr("clone-group");if(i.find(".rwmb-clone").length<=1){return false}if(f){var g=c(this).parents(".inside");var e=g.find('div[clone-group="'+f+'"]');var d=h.parent().index();c.each(e.find(".rwmb-input"),function(j,k){c(k).children(".rwmb-clone").eq(d).remove();b(c(k))})}else{h.parent().remove();b(i)}return false});function b(d){var e;if(!d){d=c(".rwmb-field")}d.each(function(){e=c(this).find(".remove-clone");e.length<2?e.hide():e.show()})}});