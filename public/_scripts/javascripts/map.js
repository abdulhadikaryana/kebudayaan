
$(window).load(function(){
   lamanbudaya.maps.createMap(); 
   
   $('#submittext').click(function(event){
       event.preventDefault();
       if(lamanbudaya.maps.validateTextForm()) {
            lamanbudaya.maps.reset();
            lamanbudaya.maps.clearAreaForm();
            lamanbudaya.maps.clearCategoryForm();

            var searchText = $('#searchname').val();       
            lamanbudaya.maps.getCultureByName(searchText);
       }
   });
   
   $('#submitarea').click(function(event) {
        event.preventDefault();
        if(lamanbudaya.maps.validateAreaForm()) {
            lamanbudaya.maps.reset();
            lamanbudaya.maps.clearTextForm();
            lamanbudaya.maps.clearCategoryForm();            

            var area = lamanbudaya.maps.getSelectedArea();
            lamanbudaya.maps.getCultureByArea(area);
        }
    });
    
    $('#submitcategory').click(function(event) {
        event.preventDefault();
        if(lamanbudaya.maps.validateCategoryForm()) {
            lamanbudaya.maps.reset();
            lamanbudaya.maps.clearAreaForm();
            lamanbudaya.maps.clearTextForm();
            
            var category = lamanbudaya.maps.getSelectedCategory();            
            lamanbudaya.maps.getCultureByCategory(category);
        }
    });
   
   $('#island').change(function() {
        lamanbudaya.maps.onIslandChange();
   });         
});

lamanbudaya.maps = {
    map : null,
    currentInfoWindow : null,
    currentMarker : null,
    markersArray : [],
    indonesiaLatLng : new google.maps.LatLng(-2.0, 118.0),
    iconStandard : lamanbudaya.url.imageUrl + '/map/poi_small.png',
    iconSpecial : lamanbudaya.url.imageUrl + '/map/poi_small2.png',
    
    createMap : function() {
                
        var mapOptions = {
          zoom: 4,
          center: lamanbudaya.maps.indonesiaLatLng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        
        lamanbudaya.maps.map = new google.maps.Map(document.getElementById("map-content"), mapOptions);     
        lamanbudaya.maps.createFullMapControl();
    },
    getCultureByName : function(searchText) {
        
        lamanbudaya.maps.reset();
        $.ajax({
            type: 'POST',
            url: lamanbudaya.url.baseUrl + "/ajax/destination-by-name",
            data: {
                name: searchText
            },
            dataType: 'json',
            success: function (data) {
                lamanbudaya.maps.createMarkersAndList(data, 'for "' + searchText + '"');                
            }
        });                
    },
    getCultureByArea : function(area) {                                
            
        $.ajax({
            type: 'POST',
            url: lamanbudaya.url.baseUrl + '/ajax/destination-by-area',
            data: {
                areaId: area[0]
            },
            dataType: 'json',
            success: function (data) {
                lamanbudaya.maps.createMarkersAndList(data, 'in ' + area[1]);                
                delete area;
            }
        });        
    },
    getCultureByCategory : function(category) {            
        $.ajax({
            type: 'POST',
            url: lamanbudaya.url.baseUrl + '/ajax/destination-by-category',
            data: {
                categoryId: category[0]
            },
            dataType: 'json',
            success: function (data) {
                lamanbudaya.maps.createMarkersAndList(data, 'in ' + category[1]);                
                delete category;
            }
        });        
    },
    getSelectedArea : function() {
        var island = $("#island").val();
        var province = $("#province").val();
        if (province != '') {
            var provinceName = $("#province option:selected").text();
            return new Array(province, provinceName);
        } else {
            var islandName = $("#island option:selected").text();
            return new Array(island, islandName);
        }
    },
    getSelectedCategory : function() {
        var category = $('#category').val();
        if(category != '') {
            var categoryName = $('#category option:selected').text();
            return new Array(category, categoryName);
        }
    },
    validateCategoryForm : function() {
        var category = $('#category').val();
        if (category == '')
            return false;
        else
            return true;
    },
    validateAreaForm : function() {
        var island = $("#island").val();
        if (island == '') 
            return false;
        else 
            return true;
    }, 
    validateTextForm : function() {
        var text = $('#searchname').val();
        if(text == '')
            return false;
        else
            return true;
    },
    createMarkersAndList : function(data, resultTitle) {
        var list = '';
        var destinasiName = '';                
        
        $.each(data, function(i) {            
            var marker = lamanbudaya.maps.createMarkers(data[i]);
            destinasiName = '<li><a class="pointer" onclick="onDestinationClickFromList(' + data[i].id + ')">' + data[i].name + '</a></li>';
            list += destinasiName;
            lamanbudaya.maps.markersArray[data[i].id] = [];
            lamanbudaya.maps.markersArray[data[i].id].push(marker);
        });
        
        var listContent = '<h4>Destination Results ' + resultTitle + '</h4>';
        listContent += '<ul>' + list + '</ul>';
        $("#listDestination").html(listContent);
        $("#listDestination").slideDown('slow');
    },
    createMarkers : function(data) {
        var latlng = new google.maps.LatLng(data.pointY, data.pointX);
        var marker = new google.maps.Marker({
            position: latlng,
            map: lamanbudaya.maps.map,
            title: data.name,
            icon: lamanbudaya.maps.iconStandard
        });
        marker.id = data.id;
        google.maps.event.addListener(marker, 'click', function () {
            lamanbudaya.maps.onMarkerClickEvent(marker, data, latlng);
        });
        return marker;
    },
    onMarkerClickEvent : function(marker, data, latlng) {
        lamanbudaya.maps.closeCurrentInfoWindow();
        var content = lamanbudaya.maps.createContent(data);
        var infowindow = new google.maps.InfoWindow({
            content: content,
            maxWidth: 300
        });
        infowindow.open(lamanbudaya.maps.map, marker);
        google.maps.event.addListener(infowindow, 'closeclick', function () {
            // will be added soon            
        });
        lamanbudaya.maps.map.setCenter(latlng);
        lamanbudaya.maps.map.setZoom(10);
        
        lamanbudaya.maps.currentInfoWindow = infowindow;
        lamanbudaya.maps.currentMarker = marker;
    },
    createContent : function(data) {
        var content = '<div class="infoDialog">';
        content += '<h4>' + data.name + '</h4>' + '<img class="alignleft" src="' + lamanbudaya.url.imageUrl + '/upload/poi/thumbnails/' + data.image + '" alt="" />' + '<p>' + data.description + '<span class="read-more"><a class="pointer" onclick="window.open(\'' + lamanbudaya.url.baseUrl + '/destination/' + data.id + '\')">' + read_more + ' &gt;&gt;</a></span>' + '</p>';
        content += '<div class="clear-left"></div>';
        content += '<h5>' + dest_act + '</h5>';
        var category = data.category;
        $.each(category, function (i) {
            content += '- ' + category[i].name + '<br />';
        });
        content += '</div>';
        return content;
    },
    onIslandChange : function() {
        lamanbudaya.maps.disableIslandSelect(true);
        var areaId = $("#island").val();
        var $subArea = $('#subarea');
        
        if (areaId == "") 
            $subArea.html('');
        else {
            $subArea.html('<img src="' + lamanbudaya.url.imageUrl + '/loader/fb.gif" />');
            $.ajax({
                type: 'POST',
                url: lamanbudaya.url.baseUrl + '/ajax/island',
                data: {
                    areaId: areaId
                },
                success: function (data) {
                    $subArea.html(data);
                    lamanbudaya.maps.disableIslandSelect(false);
                }
            });
        }
    },
    disableIslandSelect : function(value) {
        $('#island').attr('disabled', value);
        $('#submitArea').attr('disabled', value);
    },
    reset : function() {
        lamanbudaya.maps.closeCurrentInfoWindow();
        lamanbudaya.maps.removeMarkers(lamanbudaya.maps.markersArray);
        lamanbudaya.maps.showFullMap();
    },
    removeMarkers : function(arrayMarker) {
        for (i in arrayMarker) {
            for (j in arrayMarker[i]) {
                arrayMarker[i][j].setMap(null);
            }
            delete arrayMarker[i];
        }
        delete arrayMarker;
    },
    closeCurrentInfoWindow : function() {
        if (lamanbudaya.maps.currentInfoWindow) 
            lamanbudaya.maps.currentInfoWindow.close();
    },    
    clearAreaForm : function() {
        $('#island').val('');
        $('#province').empty();                       
    },
    clearTextForm : function() {
        $('#searchname').val('');
    },
    clearCategoryForm : function() {
        $('#category').val('');
    },
    createFullMapControl : function () {
        var controlDiv = document.createElement('DIV');
        var fullMapControl = new FullMapControl(controlDiv);
        controlDiv.index = 1;
        lamanbudaya.maps.map.controls[google.maps.ControlPosition.TOP_RIGHT].push(controlDiv);
    },    
    showFullMap : function() {        
        lamanbudaya.maps.map.setZoom(4);        
        lamanbudaya.maps.map.setCenter(lamanbudaya.maps.indonesiaLatlng);
    }
};

/* Custom control full map */
function FullMapControl(controlDiv) {
    controlDiv.style.padding = '5px';
    var controlUI = document.createElement('DIV');
    controlUI.style.backgroundColor = 'white';
    controlUI.style.borderStyle = 'solid';
    controlUI.style.borderWidth = '2px';
    controlUI.style.cursor = 'pointer';
    controlUI.style.textAlign = 'center';
    controlUI.title = 'Click to see whole Indonesia Map';
    controlDiv.appendChild(controlUI);
    var controlText = document.createElement('DIV');
    controlText.style.fontFamily = 'Arial,sans-serif';
    controlText.style.fontSize = '12px';    
    controlText.style.paddingTop = '3px';
    controlText.style.paddingRight = '4px';
    controlText.style.paddingBottom = '3px';    
    controlText.style.paddingLeft = '4px';
    controlText.innerHTML = 'Full Indonesia Map';
    controlUI.appendChild(controlText);
    google.maps.event.addDomListener(controlUI, 'click', function () {
        lamanbudaya.maps.showFullMap();
    });
}    



