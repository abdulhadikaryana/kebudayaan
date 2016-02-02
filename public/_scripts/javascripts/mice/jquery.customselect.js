/* custom select version 0.3
 * http://www.acewebdesign.com.au
 *  */

$.fn.customSelect = function() {
    // define defaults and override with options, if available
    // by extending the default settings, we don't modify the argument
  
 
    return this.each(function() {  
        obj = $(this); 
        thisTitle = this.title;
        thisIconhtml = "";
        thisValue = "";
        thisIconHtml ="";
        thisSelectedId="";
        thisContainerId = "container" + this.id;        
       
        obj.find('option:selected').each(function(){
						  
            thisselection = $(this).html();
            thisValue = this.value;
            thisName = this.name;
            thisTitle = $(this).html();
            thisIcon = this.title;
            thisIconHtml = "";
            thisSelectedId = this.id;
        });
        obj.wrap('<div id=\"' + thisContainerId + '\" class=\"cscontainer\"/>');
        obj.after("<div class=\"selectoptions\"> </div>");
        obj.find('option').each(function(){ 				
            $("#" + thisContainerId + " " + ".selectoptions").append("<div id=\"" + $(this).attr("value") + "\" class=\"selectitems\"><span>" + $(this).html() + "</span></div>");
        });
        obj.before("<input type=\"hidden\" value =\"" + thisValue + "\" name=\"" + this.name + "\" class=\"customselect\"/><div class=\"iconselect\">" + thisIconHtml + thisTitle +"</div><div class=\"iconselectholder\"> </div>")
        .remove();	
        if (thisSelectedId) $("#" + thisContainerId + "#" + thisSelectedId).addClass("selectedclass");
        /*
        var lala = "#" + thisContainerId + "#" + thisSelectedId;
        console.log(lala);
       var haha = $(lala);
       console.log("haha inited");
       haha.addClass("selectedclass");
        console.log("container selected idid");
        */
        $("#" + thisContainerId + " " + ".iconselect").click(function(){
            parentContainer = ($(this).parents('.cscontainer').attr('id'));
           $("#" + parentContainer + " " + ".iconselectholder").toggle("fast");
        });
        $("#" + thisContainerId + " " + ".iconselectholder").append( $("#" + thisContainerId + " " + ".selectoptions")[0] );
        $("#" + thisContainerId + " " + ".selectitems").mouseover(function(){
            $(this).addClass("hoverclass");
        });
        $("#" + thisContainerId + " " +".selectitems").mouseout(function(){
            $(this).removeClass("hoverclass");
        });
        

        $(".selectitems").click(function(){
            iconid = ($(this).attr('id'));
            parentContainerid = $("#" + iconid).parents('.cscontainer').attr('id');
              //alert(parentContainerid);
            $("#" + parentContainerid + " " +".selectedclass").removeClass("selectedclass");
            $(this).addClass("selectedclass");
            var thisselection = $(this).html();
            $("#" + parentContainerid + " " + ".customselect").val(this.id);
            $("#" + parentContainerid + " " + ".iconselect").html(thisselection);
            $("#" + parentContainerid + " " + ".iconselectholder").hide("slow")
        });
    });  
// do the rest of the plugin, using url and settings
}
