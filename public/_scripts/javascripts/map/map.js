/**
 * map.js
 *
 * Javascript yang berisi fungsi2 yang digunakan untuk map
 * Menggunakan Google Map API v3
 *
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 */

/**
 * Object Google Map
 */
var map;

/**
 * Koordinat indonesia
 */
var indonesiaLatlng;

/**
 * Koordinat destinasi
 */
var latlng;

/**
 * Icon untuk marker map yang nantinya akan berisi iconOrdinary atau
 * iconSpecial untuk menandakan suatu destinasi di map
 */
var icon;

/**
 * Icon untuk destinasi biasa
 */
var iconOrdinary = imageUrl + '/map/poi_small.png';

/**
 * Icon untuk destinasi special (featured destination)
 */
var iconSpecial  = imageUrl + '/map/poi_small2.png';

/**
 * Array untuk menyimpan marker map
 */
var markersArray = [];

/**
 * Array untuk menyimpan marker map sesuai dengan category
 */
var markersCategoryArray = [];

/**
 * Polygon untuk membuat lingkaran range yg berwarna merah
 */
var circlePolygon;

/**
 * InfoWindow yang sedang aktif. InfoWindow digunakan untuk
 * menampilkan informasi destinasi ketika sebuah marker di-click
 */
var currentInfoWindow;

/**
 * Marker yang sedang aktif. Ketika marker di-click maka marker tersebut
 * akan disimpan di variabel ini. 
 */
var currentMarker;

/**
 * Radius yang digunakan untuk lingkaran polygon
 */
var radius;

/**
 * Untuk menentukan apakah suatu checkbox category itu adalah checkbox yang
 * pertama kali di-click
 */
var firstChecked = true;


/**
 * Fungsi OnReady JQuery
 */
$(function() {

    // Click event ketika tombol submit di form map area di-klik
    $('#submitArea').click(function(event) {
        event.preventDefault();
        getDestinationByArea();
    });

    // Click event ketika tombol submit di form map name di-klik
    $('#submitName').click(function(event) {
        event.preventDefault();
        getDestinationByName();
    });

    // Change event ketika dropdown island berubah
    $('#island').change(function(event) {
        onIslandChange();
    });

    // Untuk membuat slider
    $("#sliderRange").slider({
        range: "max",
        min: 0,
        max: 20,
        value: 10,
        step: 1,
        slide: function(event, ui) {
            radius = ui.value;
            $("#range").html(radius);

            // Jika ada current marker, buat lingkaran polygon
            if(currentMarker)
                createCircle(currentMarker);
        }
    });
    
    radius = $("#sliderRange").slider("value");
    $("#range").html(radius);


    // Buat map
    initializeMap();

    // Jika ada id yang biasanya ada jika map dipanggil dari destinasi
    if(poiId != '')
        getDestinationByPoiId();
});

/**
 * Fungsi untuk inisialisasi map
 */
function initializeMap()
{
    // Map Object
    indonesiaLatlng = new google.maps.LatLng(-2.0, 118.0);
    var myOptions = {
      zoom: 4,
      center: indonesiaLatlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById('mapContent'), myOptions);

    // Full Indonesia Map Control
    var controlDiv = document.createElement('DIV');
    var fullMapControl = new FullMapIndonesiaControl(controlDiv);

    controlDiv.index = 1;
    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(controlDiv);
    
}

/**
 * Fungsi untuk mendapatkan destinasi jika checkbox di kotak category
 * dipanggil
 * 
 * @param {Integer} categoryId 
 */
function getDestinationByCategory(categoryId)
{
    // Jika checkbox merupakan yang pertama di-klik
    if(firstChecked) {
        removeAllMarkers(false);
        clearAreaForm();
        clearNameForm();
        closeCurrentInfoWindow();
        showExtraControls(false);
        $("#listDestination").slideUp('slow');
        firstChecked = false;
    }

    // Cek jika ternyata marker untuk category sudah ada, maka ketika
    // checkbox yang sudah di-klik lalu di-klik lagi maka
    // marker-nya dihapus dari map
    if (markersCategoryArray[categoryId]) {
        removeMarkersCategory(categoryId);
        removeCirclePolygon();
        closeCurrentInfoWindow();
        showExtraControls(false);
        //console.log('masuk remove cateogry');
    } else {

        //showFullIndonesiaMap();

        $('#category' + categoryId).attr('disabled', true);
        $('#boxLoading').css('display', 'block');

        markersCategoryArray[categoryId] = [];
        $.ajax({
            type: 'POST',
            url: baseUrl + '/ajax/destination-by-category',
            data: {categoryId: categoryId},
            dataType: 'json',
            success: function(destination) {
                $.each (destination, function (i) {
                     // Buat marker
                     var marker = createMarkers(destination[i]);

                     // Masukin marker ke dalam array
                     markersArray[destination[i].poi_id] = [];
                     markersArray[destination[i].poi_id].push(marker);
                     markersCategoryArray[categoryId].push(marker);
                });

                $('#category' + categoryId).attr('disabled', false);
                $('#boxLoading').css('display', 'none');
            }
        });
    }
}

/**
 * Fungsi yang dipanggil untuk mendapatkan destinasi berdasarkan
 * area yang dipilih
 */
function getDestinationByArea()
{
    // Validasi ga boleh kosong 
    if (validateSearchArea()) {
        reset();
        clearNameForm();

        // Mendapatkan area yang dipilih
        var area = getSelectedArea();

        $('#boxLoading').css('display', 'block');

        $.ajax({
            type: 'POST',
            url: baseUrl + '/ajax/destination-by-area',
            data: {areaId: area[0]},
            dataType: 'json',
            success: function(destination) {
                // Buat list hasil pencarian dan marker-nya
                createListAndMarkers(destination, 'in ' + area[1]);
                $('#boxLoading').css('display', 'none');
                
                delete area;
            }
        });

        setAreaCoordinate(area[0]);
    }
    
}

/**
 * Fungsi yang dipanggil untuk mendapatkan destinasi berdasarkan
 * nama yang dimasukkan
 */
function getDestinationByName()
{
   // Validasi ga boleh kosong
   if (validateSearchName()) {
        reset();
        clearAreaForm();

        var name = $('#searchName').val();

        $('#boxLoading').css('display', 'block');

        $.ajax({
            type: 'POST',
            url: baseUrl + '/ajax/destination-by-name',
            data: {name: name},
            dataType: 'json',
            success: function(destination) {
                // Buat list hasil pencarian dan marker-nya
                createListAndMarkers(destination, 'for "' + name + '"');
                $('#boxLoading').css('display', 'none');
            }
         });
    }
}

/**
 * Fungsi untuk mendapatkan destinasi berdasarkan poi id
 */
function getDestinationByPoiId()
{
    if(poiId != '') {
        $.ajax({
            type: 'POST',
            url: baseUrl + '/ajax/destination-by-id',
            data: {poiId: poiId},
            dataType: 'json',
            success: function(destination) {
                var marker = createMarkers(destination[0]);
                
                markersArray[destination[0].poi_id] = [];
                markersArray[destination[0].poi_id].push(marker);

                // Trigger click event untuk marker destinasi
                // sehingga bisa langsung memunculkan infowindow
                // untuk destinasi tersebut
                google.maps.event.trigger(
                    markersArray[destination[0].poi_id][0], 'click');
                
            }
         });
    }
}

/**
 * Fungsi untuk mendapatkan koordinat area
 *
 * @param {Integer} areaId
 */
function setAreaCoordinate(areaId)
{
    $.ajax({
        type: 'POST',
        url: baseUrl + '/ajax/area-coordinate',
        data: {areaId: areaId},
        dataType: 'json',
        success: function(area) {
            // Jika area-nya adalah island
            if (area[0]['area_type'] == 0)
                zoomLevel = 5;
            else
                zoomLevel = 8;

            latlng = new google.maps.LatLng(area[0]['pointY'], area[0]['pointX']);

            map.setCenter(latlng);
            map.setZoom(zoomLevel);
        }
    });
}

/**
 * Fungsi untuk membuat daftar hasil pencarian dan marker
 *
 * @param {Json} destination destinasi
 * @param {String} resultTitle judul untuk ditambahkan
 */
function createListAndMarkers(destination, resultTitle)
{
    var list = '';
    var destinasiName = '';
        
    $.each(destination, function(i) {
        var marker = createMarkers(destination[i]);

        destinasiName = '<li><a class="pointer" onclick="onDestinationClickFromList(' +
                destination[i].poi_id + ')">' + destination[i].poi_name + '</a></li>';

        list += destinasiName;
 
        markersArray[destination[i].poi_id] = [];
        markersArray[destination[i].poi_id].push(marker);
    });

    // Tambahkan judul
    var listContent = '<h4>Destination Results ' + resultTitle + '</h4>';
    listContent += '<ul>' + list + '</ul>';

    $("#listDestination").html(listContent);
    $("#listDestination").slideDown('slow');
}

/**
 * Fungsi untuk menambahkan marker destinasi di map
 *
 * @param {Json} destination
 * @return marker yang baru dibuat
 * @type google.maps.Marker
 */
function createMarkers(destination)
{
    // Pilih icon yang digunakan berdasarkan field special di table
    if(destination.special == 1)
        icon = iconSpecial;
    else
        icon = iconOrdinary;

    latlng = new google.maps.LatLng(destination.pointY, destination.pointX);
    
    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        title: destination.poi_name,
        icon: icon
    });

    marker.poi_id = destination.poi_id; // Memberi atribut tambahan poi id

    // Click event untuk tiap marker
    google.maps.event.addListener(marker, 'click', function() {
        onMarkerClickEvent(marker, destination, latlng);
    });

    return marker;
}

/**
 * Fungsi untuk menghapus marker berdasarkan category
 *
 * @param {Integer} categoryId
 */
function removeMarkersCategory(categoryId)
{
    for (i in markersCategoryArray[categoryId]) {
      markersCategoryArray[categoryId][i].setMap(null);
    }

    delete markersCategoryArray[categoryId];
}

/**
 * Fungsi untuk menghapus marker
 *
 * @param {Array} arrayMarker array yang berisi marker
 */
function removeMarkers(arrayMarker)
{
    for (i in arrayMarker) {
        for (j in arrayMarker[i]) {
            arrayMarker[i][j].setMap(null);
        }

        delete arrayMarker[i];
    }

    delete arrayMarker;
}

/**
 * Fungsi untuk menghapus semua marker
 *
 * @param {Boolean} withCategory jika true, maka marker category juga dihapus
 */
function removeAllMarkers(withCategory)
{
    removeMarkers(markersArray);

    if(withCategory)
        removeMarkers(markersCategoryArray);
}

/**
 * Fungsi untuk menghapus lingkaran polygon
 */
function removeCirclePolygon()
{
    if(circlePolygon)
        circlePolygon.setMap(null);
}

/**
 * Fungsi untuk menutup infowindow yang sedang muncul
 */
function closeCurrentInfoWindow()
{
    if(currentInfoWindow)
        currentInfoWindow.close();
}

/**
 * Fungsi umum untuk melakukan reset map
 */
function reset()
{
    closeCurrentInfoWindow();
    uncheckAllCheckboxes();
    removeAllMarkers();
    removeCirclePolygon();
    showFullIndonesiaMap();
    showExtraControls(false);

    $("#listDestination").slideUp('slow');
}

/**
 * Fungsi untuk melakukan uncheck semua checkboxes
 */
function uncheckAllCheckboxes()
{
    firstChecked = true; // Set ke true
    $('input[type="checkbox"]').attr('checked', false)
}

/**
 * Fungsi untuk membuat content di infowindow
 *
 * @param {Json} destination
 * @return content html
 * @type String
 */
function createContent(destination)
{
    //console.log(destination.description);
    
    var content = '<div class="infoDialog">';
    
    content += '<h4>' + destination.poi_name + '</h4>' +
               '<img class="alignleft" src="' + imageUrl +
                    '/upload/poi/thumbnails/' + destination.image + '" alt="" />' +
               '<p>'  +
                destination.description +
                '<span class="read-more"><a class="pointer" onclick="window.open(\'' +
                    baseUrl + '/destination/' + destination.poi_id + '\')">'+read_more+' &gt;&gt;</a></span>' +
               '</p>';

    content += '<div class="clear-left"></div>';
    content += '<h5>'+dest_act+'</h5>';

    // Buat list untuk category/activity terkait dengan destinasi
    var category = destination.category;

    $.each(category, function(i) {
      content += '- ' + category[i].name + '<br />';
    });

    content += '</div>'; // end div infoDialog

    return content;
}

/**
 * Fungsi untuk membuat lingkaran polygon
 *
 * @param {google.map.Marker} marker marker yang sedang aktif
 */
function createCircle(marker)
{
    removeCirclePolygon();
   
    circlePolygon = new google.maps.Circle({
        center: marker.getPosition(),
        radius: radius * 1000,
        fillColor: '#FF0000',
        fillOpacity: 0.2,
        strokeOpacity: 0.5,
        strokeWeight: 1,
        map: map
     });

    createNearDestinationList(marker, radius);

}

/**
 * Fungsi untuk membuat daftar destinasi terdekat berdasarkan
 * radius dari lingkaran polygon
 *
 * @param {google.map.Marker} marker marker yang sedang aktif
 * @param {Integer} radius radius lingkaran yang digunakan
 */
function createNearDestinationList(marker, radius)
{
    // Mendapatkan koordinate dari marker
    var currentPosition = marker.getPosition();

    //console.log('masuk kesini');
    var content = '<h4>'+nearest_dest+'</h4>';
    content += '<div id="near-dest-list">';

    var counter = 0;
    for (i in markersArray) {
       for (j in markersArray[i]) {
           //console.log(markersArray[i][j].getTitle() + ' => ' + distanceFrom(currentPosition, markersArray[i][j].getPosition()));
           if(currentPosition != markersArray[i][j].getPosition() &&
               distanceFrom(currentPosition, markersArray[i][j].getPosition()) < radius
           ) {
               content += "<a class='" + (counter % 2 == 0 ? "even" : "odd") +
                   "' onclick='onDestinationClickFromList(" +
                        markersArray[i][j].poi_id + ",1)'>" + markersArray[i][j].getTitle() + "</a> ";
               counter++;
           }
       }   
    }

    content += '</div>'; // end dari div near-dest-list

    $('#listPoiInRange').html(content);
}

/**
 * Fungsi untuk menampilkan kembali peta Indonesia 
 */
function showFullIndonesiaMap()
{
    map.setZoom(4);
    map.setCenter(indonesiaLatlng);
}

/**
 * Fungsi untuk menampilkan atau menyembunyikan controls2 lain di map
 * seperti slider dan kotak daftar destinasi terdekat
 *
 * @param {Boolean} show jika true maka dimunculkan
 */
function showExtraControls(show)
{
    if (show) {
        $("#listPoiInRange").fadeIn('slow');
        $("#sliderContainer").slideDown('slow');
    } else {
        $("#listPoiInRange").fadeOut('slow');
        $("#sliderContainer").slideUp('slow');
    }
}

/**
 * Fungsi yang dipanggil jika marker di-klik
 *
 * @param {google.map.Marker} marker
 * @param {Json} destination
 * @param {latlng} koordinat posisi dari marker
 */
function onMarkerClickEvent(marker, destination, latlng)
{
    // Tutup infowindow yg lain jika ada
    closeCurrentInfoWindow();

    // Buat content untuk infowindow
    var content = createContent(destination);

    // Buat infowindow untuk marker
    var infowindow = new google.maps.InfoWindow({
        content: content,
        maxWidth: 300
    });
    infowindow.open(map, marker);

    // Close event jika tombol x infowindow di-click
    google.maps.event.addListener(infowindow, 'closeclick', function() {
        removeCirclePolygon();
        showExtraControls(false);
    });

    map.setCenter(latlng);
    map.setZoom(10);

    currentInfoWindow = infowindow;
    currentMarker = marker;

    // Buat lingkaran polygon untuk marker
    createCircle(marker);

    // Munculkan control2 terkait untuk map
    showExtraControls(true);
}

/**
 * Fungsi yang dipanggil jika dropdown island berubah
 */
function onIslandChange()
{
    disableIslandSelect(true);

    var areaId = $("#island").val();

    if (areaId == "")
        $('#subArea').html('');
    else {
        $('#subArea').html('<img src="' + imageUrl + '/loader/fb.gif" />');
        $.ajax({
            type: 'POST',
            url: baseUrl + '/ajax/island',
            data: {areaId: areaId},
            success: function(data) {
                $('#subArea').html(data);
                disableIslandSelect(false);
            }
        });
    }
}

/**
 * Fungsi yang dipanggil jika sebuah destinasi di daftar hasil
 * pencarian destinasi di-klik
 *
 * @param {Integer} poiId
 */
function onDestinationClickFromList(poiId)
{
    window.location.href = '#anchorMap';
    google.maps.event.trigger(markersArray[poiId][0], 'click');
}

/**
 * Fungsi untuk mendapatkan area yang dipilih di form pencarian area
 *
 * @return informasi area berupa area id dan nama area
 * @type Array
 */
function getSelectedArea()
{
    var island = $("#island").val();
    var province = $("#province").val();

    // Jika province tidak kosong, pencarian berdasarkan province
    if(province != '') {
        var provinceName = $("#province option:selected").text();
        return new Array(province, provinceName);
    } else {
        var islandName = $("#island option:selected").text();
        return new Array(island, islandName);
    }

}

/**
 * Fungsi untuk men-disable dropdown island dan tombol submit area
 *
 * @param {Boolean} value jika true, maka di-disabled
 */
function disableIslandSelect(value)
{
    $('#island').attr('disabled', value);
    $('#submitArea').attr('disabled', value);
}

/**
 * Fungsi untuk validasi form area
 *
 * @return false|true
 */
function validateSearchArea()
{
	var island = $("#island").val();

	if(island == '')
		return false;
	else
		return true;
}

/**
 * Fungsi untuk validasi form name
 *
 * @return false|true
 */
function validateSearchName()
{
	var name = $("#searchName").val();

	if(name == '')
		return false;
	else
		return true;
}

/**
 * Fungsi untuk membersihkan form area
 */
function clearAreaForm()
{
    //console.log('clear area');
    $("#island").val('');
    $('#province').empty();
}

/**
 * Fungsi untuk membersihkan form name
 */
function clearNameForm()
{
    $('#searchName').val('');
}

/**
 * Fungsi untuk menghitung radius
 *
 * @param {Integer} x
 * @return hasil
 * @type Integer
 */
function rad(x)
{
    return x * Math.PI/180;
}

/**
 * Fungsi untuk menghitung jarak antara dua titik
 *
 * @param {Integer} p1 titik kesatu
 * @param {Integer} p2 titik kedua
 * @return jarak kedua titik
 * @type {Integer}
 */
function distanceFrom(p1, p2)
{
  var R = 6371; // Pake kilometers
  var dLat  = rad(p2.lat() - p1.lat());
  var dLong = rad(p2.lng() - p1.lng());

  var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
          Math.cos(rad(p1.lat())) * Math.cos(rad(p2.lat())) *
          Math.sin(dLong/2) * Math.sin(dLong/2);
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
  var d = R * c;

  return d.toFixed(3);
}

/**
 * Fungsi untuk membuat custom control full map indonesia
 *
 * @param {Dom} controlDiv dari custom control
 */
function FullMapIndonesiaControl(controlDiv)
{
  controlDiv.style.padding = '5px';

  // CSS custom control
  var controlUI = document.createElement('DIV');
  controlUI.style.backgroundColor = 'white';
  controlUI.style.borderStyle = 'solid';
  controlUI.style.borderWidth = '2px';
  controlUI.style.cursor = 'pointer';
  controlUI.style.textAlign = 'center';
  controlUI.title = 'Click to see whole Indonesia Map';
  controlDiv.appendChild(controlUI); // Tambahkan ke dom

  // CSS untuk tulisan
  var controlText = document.createElement('DIV');
  controlText.style.fontFamily = 'Arial,sans-serif';
  controlText.style.fontSize = '12px';
  controlText.style.paddingLeft = '4px';
  controlText.style.paddingRight = '4px';
  controlText.innerHTML = 'Full Indonesia Map';
  controlUI.appendChild(controlText);

  // Click event jika custom control di-klik
  google.maps.event.addDomListener(controlUI, 'click', function() {
        showFullIndonesiaMap();
  });
}
