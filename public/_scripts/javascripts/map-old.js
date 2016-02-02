var map,mgr;									// map adalah GMap2 utama, mgr adalah MarkerManager utama
var areas = new Array();						// areas: dipake ga sih?
var poi = [ [],[] ];							// poi: array 2 dimensi berisi semua marker2 yang ada di peta
var subArea = [ [],[] ];						// subArea: dipake ga sih?
var subAreaInfo = new Array();					// subAreaInfo: dipake ga sih?
var poiInfo = new Array();						// poiInfo: array berisi informasi mengenai semua POI yang ada (nama, x, y, desc)
var poiCategories= new Array();					// poiCategories: array berisi kategori apa saja yang dimiliki oleh sebuah POI
var areasNode = new Array();					// areasNode dipake ga sih?
var iconsArea = new Array();					// iconsArea: dipake ga sih?
var iconsCategory = new Array();				// iconsCategory: dipake ga sih?
var iconsPoi = new Array();						// iconsPoi: array berisi GIcon yg merepresentasikan 1 POI 
var iconsPoiPopular = new Array();				// iconsPoiPopular: array berisi GIcon yg merepresentasikan 1 poi popular
//var iconPoiBig = new GIcon();
var areaBatches = [ [],[],[] ];					// areaBatches: dipake ga sih?
var nAreaBatches = 3;			    				// nAreaBatches: dipake ga sih?
var nPoiBatches = 2;							// nPoiBatches: menyimpan ...
var categories = new Array();					// categories: array berisi id semua category yang ada di databse
var categoriesInfo = new Array();				// categoriesInfo: array berisi informasi yang dimiliki oleh semua category, category_id menjadi key array ini
var polygon;									// polygon: object GPolygon gambar lingkaran merah
var radius=10;									// radius: menyimpan radius lingkaran range, dalam mile
var poiInRange = [];							// poiInRange: array berisi poi2 yang berada di dalam lingkaran/range
var latlng = false;								// latlng: menyimpan google.maps.LatLng current marker
var cchngbr = new Array();						// cchngbr: cache_neighbour, menyimpan semua tetangga yg ada di radius maksimum, untuk mempercepat slider
var maxrad = 20;								// maxrad: max radius, radius maksimum (dalam mile)
var currentId;                                  // dipakai untuk menentukan id apa yang sedang dilihat oleh user sehingga id ini tidak dimunculkan di list nearest destination
var showSlider = false;  						// menentukan apakah slider muncul apa tidak
var isSliderShowed = false;                     // slider sedang muncul apa tidak
var isSearch = false;							// apakah sedang proses pencarian
var searchData;									// menyimpan hasil pencarian
var duration = 1000;							// durasi dari animasi
var radmetre;									// radius meter

// fungsi untuk inisialisasi map
function createMap(){
//    if (GBrowserIsCompatible()) {
        // inisialisasi map di dom mapContent
        map = new google.maps.Map(document.getElementById("mapContent"));
        // set map di peta Indonesia dengan koordinat dibawah
        map.setCenter(new google.maps.LatLng(-2.0, 118.0), 4);
        
        // inisialisasi control yang akan digunakan
        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
        map.addControl(new FullMapControl()); // full map indonesia control
        
        map.disableDoubleClickZoom();
        mgr = new MarkerManager(map, {
            maxZoom: 17
        });
        google.maps.event.addListener(map, "infowindowclose", infoWindowClose);
//    }
}

function createMapXY(x,y,z){
//    if (GBrowserIsCompatible()) {
        // inisialisasi map di dom mapContent
        map = new google.maps.Map(document.getElementById("mapContent"));
        // set map di peta Indonesia dengan koordinat dibawah
        map.setCenter(new google.maps.LatLng(y, x), z);
        
        // inisialisasi control yang akan digunakan
        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
        map.addControl(new FullMapControl()); // full map indonesia control
        
        map.disableDoubleClickZoom();
        mgr = new MarkerManager(map, {
            maxZoom: 17
        });
        google.maps.event.addListener(map, "infowindowclose", infoWindowClose);
//    }
}

// fungsi untuk melihat peta indonesia lengkap, dipanggil oleh button
// fullIndonesiaMap
function showFullIndonesiaMap(){
    map.closeInfoWindow();
    map.setCenter(new google.maps.LatLng(-2.0, 118.0), 4);
    showSlider = false;
    infoWindowClose();
}

// getChild: ketika bapak di click, anak2nya juga
function getChild(master, tes){
    //new
    cleanSearchInformation();
    cleanPickPlaceInformation();
    cleanListDestination();
    isSearch = false;
    for (var i = 0; i < tes.length; i++) {
        layering(tes[i], document.getElementById(master).checked);
    }
    checkPOI();
}

// slider: mentrigger penggambaran lingkaran, dipanggil ketika slider berubah posisi
function slider(){
    radius = dojo.byId('horizontalSlider').value;
    radmetre = radius * 1609.344;
    if (polygon) {
        drawCircle(latlng);
        
        checkCachePOI();
    }
}

function showSliderDiv(){
	dojo.style('slider','display','block');
}

// layering: fungsi yg dipanggil untuk mengubah state variabel categoriesInfo[cid]['status] berdasarkan checkbox
function layering(cid, status){
    map.closeInfoWindow();
    categoriesInfo[cid]['status'] = status;
    return true;
}

// genAllNeighbour: mengembalikan semua POI in range maximum
function genAllNeighbour(alatlng, rad){
    var hasil = new Array();
    var radmetre = rad * 1609.344;
    for (i in poi[0]) {
        var found = false;
        n = 0;
        while (n < poiCategories[i].length && !found) {
            if (categoriesInfo[poiCategories[i][n]]['status']) 
                found = true;
            n++;
        }
        if (found) {
            for (var j = 0; j < nPoiBatches; j++) {
                if (poi[j][i].getLatLng().distanceFrom(alatlng) < radmetre) {
                    if (hasil.indexOf(i) < 0) 
                        hasil.push(i);
                }
            }
        }
    }
    return hasil;
}

// genAllNeighbour: mengembalikan semua POI in range maximum, dipanggil jika mode sekarang search
function genAllNeighbourIfSearch(alatlng, rad){
    var hasil = new Array();
    var radmetre = rad * 1609.344;
    for (item in searchData) {
        var i = searchData[item]['poi_id'];
        for (var j = 0; j < nPoiBatches; j++) {
            if (poi[j][i].getLatLng().distanceFrom(alatlng) < radmetre) {
                if (hasil.indexOf(i) < 0) 
                    hasil.push(i);
            }
        }
        
    }
    return hasil;
}

// checkPOI: simpelnya sih untuk refresh gambar2 POI di peta, jika dalam range tampilkan, else tidak
function checkPOI(){
    removePois();
    poiInRange = new Array();
    
    for (poiId in poi[0]) {
        var found = false;
        n = 0;
        while (n < poiCategories[poiId].length && !found) {
            if (categoriesInfo[poiCategories[poiId][n]]['status']) 
                found = true;
            n++;
        }
        if (found) {
            markData(poiId);
        }
    }
    mgr.refresh();
    updateListPoiInRange();
}

// checkCachePOI: melakukan hal persis seperti checkPOI() tetapi hanya untuk POI2 dalam cchngbr
// asumsi: dipanggil ketika slider digerakkan, otomatis polygon pasti tidak false
function checkCachePOI(){
    removePois();
    poiInRange = new Array();
    var radmetre = radius * 1609.344;
    for (var x = 0; x < cchngbr.length; x++) {
        var i = cchngbr[x];
        for (var j = 0; j < nPoiBatches; j++) {
            if (poi[j][i].getLatLng().distanceFrom(latlng) < radmetre) {
                if (poiInRange.indexOf(i) < 0) 
                    poiInRange.push(i);
                if (j == 0) 
                    mgr.addMarker(poi[j][i], 4, 7);
                else 
                    mgr.addMarker(poi[j][i], 8, 17);
            }
        }
    }
    mgr.refresh();
    updateListPoiInRange();
}

// fungsi untuk membuat content dari info Window
// @param id poiId
// @param latlng posisi/letak koordinat dari poi
function createInfoWindowContent(id, latlng){

    var content = "<div id='infoDialog'>";
    content += "<h4 id='dialogTitle'>" + poiInfo[id]['name'] + "</h4>";
    content += poiInfo[id]['des'] + "<hr />";
    
    // tipe/kategori destinasi
    // typeDestination di-declare di halaman view (webwords)
    content += "<p><b>" + typeDestination + "</b></p>";
    content += "<table class='listSubCategory'>";
    for (var i = 0; i < poiCategories[id].length; i++) {
        content += "<tr>";
        content += "<td>" + "<img alt='" + categoriesInfo[poiCategories[id][i]]['name'] + "' width='16px' src='" + mediaUrl + "/images/icon/" + categoriesInfo[poiCategories[id][i]]['parent_image'] + "' /></td>";
        content += "<td>" + categoriesInfo[poiCategories[id][i]]['name'] + "</td>";
        content += "</tr>";
    }
    content += "</table>";
    content += "</div>";

//    map.openInfoWindow(latlng, content);
    var infowindow = new google.maps.InfoWindow({
        content: content
    });
    
    
}


// poiClickResponse: fungsi yang dipanggil ketika sebuah marker di-click
function poiClickResponse(id){

    latlng = new google.maps.LatLng(poiInfo[id]['y'], poiInfo[id]['x']);

    
    currentId = id; // set current id destinasi agar destinasi ini tidak dimunculkan di list poi range
    setCenterBasedPoint(poiInfo[id]['y'], poiInfo[id]['x'], 11);
    
    createInfoWindowContent(id, latlng);
    
    drawCircle(latlng);
    checkNearestPoi(latlng);
    
    showSlider = false; // balikin nilai ke 0 lagi sehingga efek wipein tidak terjadi
    showListPoiInRange();
    
    return true;
}

// Fungsi untuk melihat lokasi poi tanpa menampilkan info window
// dipanggil jika map memiliki parameter id
function poiClickWithSmallInfoWindow(id)
{
	wipeSliderOut();
	
	var content = "<div id='infoDialog'>";
	content += "<h4 id='dialogTitle' style='padding: 10px 0 0; font-size: 16px'>" + poiInfo[id]['name'] + "</h4>";
	content += "</div>";

    latlng = new google.maps.LatLng(poiInfo[id]['y'], poiInfo[id]['x'], 9);
    //createInfoWindowContent(id, latlng);
    map.setCenter(latlng);
    map.openInfoWindow(map.getCenter(),content);
	
    currentId = id; // set current id destinasi agar destinasi ini tidak dimunculkan di list poi range
    setCenterBasedPoint(poiInfo[id]['y'], poiInfo[id]['x'], 9); // set center dengan zoom 9

}

// fungsi untuk mengecek apakah ada poi terdekat 
function checkNearestPoi(latlng){
    if (!isSearch) {
        cchngbr = genAllNeighbour(latlng, maxrad);
    }
    else 
        cchngbr = genAllNeighbourIfSearch(latlng, maxrad);
    
    checkCachePOI();
}


// fungsi yang dipanggil pertama kali untuk membuat poi2 dan assign poi tersebut
// ke variabel javascript
function createPoi(){
    
    // membuat marker icon
    generateMarkerIcon();
    
    // membuat daftar kategori
    generateCategories();
    
    // membuat poi2
    generatePoi();
    
    checkPOI();
    
}

// drawCircle: menggambar lingkaran di peta pada posisi (lat,lng) sebaga titik pusat, radius diambil dari global variable
function drawCircle(alatlng, iscache){
    var polytemp = GPolygon.Circle(alatlng, radius * 1609.344, "#990000", 1, 0.75, "#ff0000", 0.5);
    map.addOverlay(polytemp);
    if (polygon) 
        map.removeOverlay(polygon);//removePolygon();
    polygon = polytemp;
}

// method yang dipanggil jika poi diklik dari daftar list poi in range
function poiClickFromRange(id){
    showSlider = true; // set nilai ke 1 (true)
    poiClick(id);
}

// method yang dipanggil jika poi diklik dari daftar list poi in range
function poiClickFromList(id){
    showSlider = true; // set nilai ke 1 (true)
    window.scroll(0, 350);
    poiClick(id);
}

// poiClick: fungsi yang mentrigger poiClickResponse
function poiClick(id){
    map.closeInfoWindow();
    wipeSliderIn(); //wipein 
    poiClickResponse(id);
    return true;
}

// poiClickEvent: menambahkan event click ke suatu marker
function poiClickEvent(marker, id){
    google.maps.event.addListener(marker, "click", function(){
        showSlider = false;
        poiClick(id);
    });
    return true;
}

// removePolygon: menghapus gambar lingkaran dan slider
function removePolygon(){
    if (polygon) {
        map.removeOverlay(polygon);
        polygon = false;
        
    }
    return true;
}

// removePois: menghapus gambar2 POI di peta
function removePois(){
    mgr.clearMarkers();
    return true;
}

// showListPoiInRange: menampilkan list POI2 yang ada dalam range
function showListPoiInRange(){
    //global poiInRange
    var el = document.getElementById("listPoiInRange");
    el.style.display = "block";
}

// hideListPoiInRange: menyembunyikan list POI2 yg ada dalam range
function hideListPoiInRange(){
    //global poiInRange
    var el = document.getElementById("listPoiInRange");
    el.style.display = "none";
}

// resetListPoiInRange: menghapus item2 dalam list POI in range
function resetListPoiInRange(){
    //global poiInRange
    var el = document.getElementById("listPoiInRange");
    el.innerHTML = "";
}

// updateListPoiInRange: memperbarui list poi in range
function updateListPoiInRange(){
    //global poiInRange
    var el = document.getElementById("listPoiInRange");
    var inhtml = "";
    resetListPoiInRange();
    inhtml += "<p style='padding: 0 5px;'><b>" + nearestDestination + "</b></p>";
    var j = 0; // untuk bikin warna selang-seling
    for (var i = 0; i < poiInRange.length; i++) {
        if (currentId != poiInRange[i]) {
            inhtml += "<a class='" + (j % 2 == 0 ? "even" : "odd") + "' style='padding: 3px 5px' href='javascript:void(0)' onclick='poiClickFromRange(" + poiInRange[i] + ",1)'>" + poiInfo[poiInRange[i]].name + "</a> ";
            j++;
        }
    }
    
    el.innerHTML = inhtml;
}

// infoWindowClose: membersihkan embel2 slider, polygon dan list poi in range
function infoWindowClose(){

    removePolygon();
    hideListPoiInRange();
    
    // jika show slider false dan is slider showed
    if (showSlider == false && isSliderShowed == true) {
        wipeSliderOut();
    }
    
    if (isSearch) 
        markSearchDataInMap(false);
    else 
        checkPOI();
    
}

// fungsi untuk melakukan animasi slider wipe in
function wipeSliderIn(){
    dojo.fx.wipeIn({
        node: 'slider',
        duration: duration
    }).play();
    
    isSliderShowed = true;
}

// fungsi untuk melakukan animasi slider wipe out
function wipeSliderOut(){
    dojo.fx.wipeOut({
        node: 'slider',
        duration: duration
    }).play();
    
    isSliderShowed = false;
}

// fungsi untuk melakukan animasi sebelum proses searching 
function animateBeforeSearch(nodeLoading){
    dojo.byId(nodeLoading).setAttribute("style", "display:inline;");
    
    dojo.fadeOut({
        node: "message",
        duration: 1000
    }).play();
}

// fungsi untuk melakukan animasi setelah proses searching
function animateAfterSearch(nodeLoading){
    dojo.byId(nodeLoading).setAttribute("style", "display:none;");
    
    dojo.fadeIn({
        node: "message",
        duration: 1000
    }).play();
}

// fungsi search destination, untuk mencari destinasi/poi
// berdasarkan nama
function searchPoiBasedText(){
	
    if(validateSearchText())
    {
	    	
	    showSlider = true; // diset true untuk mencegah wipesliderout efek
	    showFullIndonesiaMap(); // kembali ke full map indonesia
	    
	    // bersihkan pilihan di checkbox, area select dan list destinasi
	    uncheckAllCategoryCheckbox();
	    cleanPickPlaceInformation();
	    cleanListDestination();
	    
	    // get poi dengan ajax
	    getPoi();
    }
}


// fungsi ajax untuk mendapatkan poi dari search destination
function getPoi(){
    // input text yang dimasukkan user
    searchText = dojo.byId("searchPoi").value;


    // animasi sebelum search
    animateBeforeSearch("loading");

    dojo.xhrGet({
        url: baseUrl + "/explore/search",
        handleAs: 'json',
        content: {
            "searchText": searchText
        },
        load: function(data, args){
        
            if (typeof data == "error") {
                console.warn("error!", args);
                alert("error");
            }
            else {
            
               dojo.byId("message").innerHTML = "<p>" + data.length + " destination(s) match your search criteria '" + searchText + "'</p>";

                animateAfterSearch("loading");
                
                isSearch = true;
                searchData = data;
                markSearchDataInMap(true);
                
            }
        }
    });

}

function validateSearchText()
{
	var searchText = dojo.byId("searchPoi").value;
	
	if(searchText == '')
		return false;
	else
		return true;
}

// fungsi untuk mendapatkan poi berdasarkan area
function searchPoiBasedArea(){
	
	if(validateSearchArea())
	{
	    showSlider = false;
	    infoWindowClose();
	    
	    uncheckAllCategoryCheckbox();
	    cleanSearchInformation();
	    cleanListDestination();
	    
	    // parameter area
	    area = dojo.byId('selectedArea').value;
	
	    // animate after search di dalam method getPoiBasedArea
	    animateBeforeSearch("loading-place"); 
	    
	    getAreaCoordinate(area);
	    getPoiBasedArea(area);
	}
    
}

// fungsi ajax untuk mendapatkan koordinat dari area
function getAreaCoordinate(area){
    dojo.xhrGet({
        url: baseUrl + "/explore/getareacoordinate",
        handleAs: 'json',
        content: {
            "area": area
        },
        load: function(data, args){
        
            if (typeof data == "error") {
                console.warn("error!", args);
                alert("error");
            }
            else {
                // menentukan zoom level
                // jika area adalah island/pulau
                if (data[0]['area_type'] == 0) 
                    zoomLevel = 6;
                // jika area adalah provinsi
                else 
                    zoomLevel = 8; 
                
                var pointX = data[0]['pointX'];
                var pointY = data[0]['pointY'];
                
                // set center map berdasarkan point
                setCenterBasedPoint(pointY, pointX, zoomLevel);
                
            }
        }
    });
}

// fungsi ajax untuk mendapatkan poi-poi/destinasi pada suatu area
function getPoiBasedArea(area){

	var areaChosen = getAreaChosen();
	
    dojo.xhrGet({
        url: baseUrl + "/explore/searchbasedarea",
        handleAs: 'json',
        content: {
            "area": area
        },
        load: function(data, args){
        
            if (typeof data == "error") {
                console.warn("error!", args);
                alert("error");
            }
            else {
                
                dojo.byId("message").innerHTML = "<p>" + data.length + ' ' + mapMessage + ' ' + areaChosen + "</p>";
                
                animateAfterSearch("loading-place");
                isSearch = true;
                searchData = data;
                markSearchDataInMap(true);
                
            }
        }
    });

}

function getAreaChosen()
{
	var areaChosen = '';
	
	var mainAreaDom = dojo.byId('areaname');
	var subAreaDom = dojo.byId('subareaname');
	
	var mainAreaValue = mainAreaDom.value;
	var subAreaValue = subAreaDom.value;
	
	var areaStr = mainAreaDom[mainAreaDom.selectedIndex].innerHTML;
	var subAreaStr = subAreaDom[subAreaDom.selectedIndex].innerHTML;
	
	//alert(subArea);

	if(subAreaValue != '')
		areaChosen = subAreaStr;
	else if(mainAreaValue != '')
		areaChosen = areaStr;
	
	return areaChosen;	
}

function validateSearchArea()
{
	var mainAreaValue = dojo.byId('areaname').value;
	
	if(mainAreaValue == '')
		return false;
	else
		return true;
}

// fungsi untuk membuat list destinasi dan mark poi di map
// @param generateList jika set true maka list digenerate ulang
function markSearchDataInMap(generateList){
    
    // HTML list destinasi
    var listDestination = "";
    
    // HTML list destinasi yang popular
    var listPopular = "";
    
    // HTML untuk more div
    var buttonMore = "";
    
    poiInRange = new Array();
    
    i = 0;
    
    // looping searchData yang sudah diset sebelumnya
    // searchData merupakan variabel global
    for (item in searchData) {
        var poiId = searchData[item]['poi_id'];
        
        if (generateList) {

            var popular = searchData[item]['popular'];
            
            if (popular == 1) 
                listPopular += "<a class='link' onclick='return poiClickFromList(" + poiId + ")'>" + poiInfo[poiId]['name'] + "</a>" + " | ";
            else 
                listDestination += "<a class='link' onclick='return poiClickFromList(" + poiId + ")'>" + poiInfo[poiId]['name'] + "</a>" + " | ";
            
            // jika sudah 10 destinasi, dibikin more aja
            if (i == 10) {
                listDestination += "<div id='moreList'>";
                buttonMore += '</div>';
                buttonMore += '<div class="type_content" style="clear:both;margin-top: 3px;">';
                buttonMore += '<img id="showList" onclick="wipeDiv(\'moreList\',\'showList\',\'hideList\',1)" src="' + mediaUrl + '/images/icon/more.png" />';
                buttonMore += '<img id="hideList" onclick="wipeDiv(\'moreList\',\'showList\',\'hideList\',0)" src="' + mediaUrl + '/images/icon/less.png" />';
                buttonMore += '</div>';
            }
        }
        
        markData(poiId);
        i++;
    }
    
    /*alert('berakhir');
            //alert(listDestination);
            alert(listPopular);*/

    if (generateList) {
        
        list = "<div style='text-align:justify'>";
        list += "<h4>" + destinations + "</h4>";
        list += listPopular + listDestination + buttonMore;
        list += "</div>";
        
        dojo.byId('list').innerHTML = list;
        
        if (i >= 10) 
            wipeDiv('moreList', 'showList', 'hideList', 0);
    }
    
    mgr.refresh();
    updateListPoiInRange();
}

// fungsi untuk memberi tanda mark di peta berdasarkan level zoom
// @id poiID
function markData(id){

    for (var j = 0; j < nPoiBatches; j++) {
    
        if (polygon) {
        
            if (poi[j][id].getLatLng().distanceFrom(latlng) < radmetre) {
            
                if (poiInRange.indexOf(id) < 0) 
                    poiInRange.push(id);
                
                if (j == 0) 
                    mgr.addMarker(poi[j][id], 4, 7);
                else 
                    mgr.addMarker(poi[j][id], 8, 17);
            }
        }
        else {
            if (j == 0) 
                mgr.addMarker(poi[j][id], 4, 7);
            else 
                mgr.addMarker(poi[j][id], 8, 17);
        }
    }
}

// fungsi untuk bersih-bersih form search destination
function cleanSearchInformation(){
    dojo.byId("searchPoi").value = "";
    dojo.fadeOut({
        node: "message",
        duration: 1000
    }).play();
}

// fungsi untuk bersih-bersih form search area / pick a location
function cleanPickPlaceInformation(){
    dojo.byId("areaname").value = "";
    subarea = dojo.byId("subareaname");
    
    if (subarea != null) 
        dojo.byId("subareaname").value = "";
}

// fungsi untuk menghapus list destinasi
function cleanListDestination(){
    dojo.byId("list").innerHTML = "";
}

// fungsi yang dipanggil untuk meng-Uncheck-box
// dipanggil jika fitur search destination dan pick a location
// dijalankan
function uncheckAllCategoryCheckbox(){
    
    removePois(); // remove semua poi di peta
    dojo.query('[type="checkbox"]').attr('checked', false);
}

// fungsi untuk melakukan set center map berdasarkan point yang diberikan
// @param pointY koordinat Y
// @param pointX koordinat X
// @param zoomLevel tingkat zoom sampai berapa jauh
function setCenterBasedPoint(pointY, pointX, zoomLevel){

    if (pointX != 0 && pointY != 0) 
        map.setCenter(new google.maps.LatLng(pointY, pointX), zoomLevel);
    else 
        map.setCenter(new google.maps.LatLng(-2.0, 118.0), 4);
    
}

// fungsi ajax yang dipanggil apabila select island dipilih
function onIslandChange(area){
    area = dojo.byId('areaname').value;
    
    disableIslandSelect(true);
    
    dojo.byId("selectedArea").value = area;
    if (area == "") 
        dojo.byId("subArea").innerHTML = "";
    else {
        dojo.byId("subArea").innerHTML = "<img src=\"" + mediaUrl + "/images/loading/loading5.gif\" />";
        dojo.xhrPost({
            url: baseUrl + '/explore/subarea/area/' + area,
            load: function(data){
                dojo.byId("subArea").innerHTML = data;
                disableIslandSelect(false);
            }
        });
    }
}

function onProvinceChange(area){
    province = dojo.byId('subareaname').value;
    dojo.byId("selectedArea").value = province;
}

function disableIslandSelect(value)
{
    dojo.byId('areaname').disabled = value;
}

function generateMarkerIcon(){
    generateMarkerIconOrdinary();
    generateMarkerIconPopular();
}

// fungsi untuk generate icon marker destinasi
function generateMarkerIconOrdinary(){
    for (var i = 0; i < nPoiBatches; i++) {
        iconsPoi[i] = new GIcon();
        iconsPoi[i].image = iconDestinasi;
        iconsPoi[i].iconSize = new GSize(8 * Math.pow(2, (i + 1)), 8 * Math.pow(2, (i + 1)));
        iconsPoi[i].iconAnchor = new GPoint(4 * Math.pow(2, (i + 1)), 8 * Math.pow(2, (i + 1)));
        iconsPoi[i].infoWindowAnchor = new GPoint(8 * Math.pow(2, (i + 1)), 8 * Math.pow(2, (i + 1)));
    };
}

// fungsi untuk generate icon marker destinasi yang popular
function generateMarkerIconPopular(){
    // dibuat ada 2 biji icon dengan size beda, 1 klo utk dilihat dari jauh, 1 lg utk dilihat dari deket
    for (var i = 0; i < nPoiBatches; i++) {
        iconsPoiPopular[i] = new GIcon();
        iconsPoiPopular[i].image = iconDestinasiPopular;
        iconsPoiPopular[i].iconSize = new GSize(8 * Math.pow(2, (i + 1)), 8 * Math.pow(2, (i + 1)));
        iconsPoiPopular[i].iconAnchor = new GPoint(4 * Math.pow(2, (i + 1)), 8 * Math.pow(2, (i + 1)));
        iconsPoiPopular[i].infoWindowAnchor = new GPoint(8 * Math.pow(4, (i + 1)), 8 * Math.pow(2, (i + 1)));
    };
}



//************ CUSTOM CONTROL FULL MAP INDONESIA ************

function FullMapControl(){
}

//FullMapControl.prototype = new GControl();

// inisialisasi
FullMapControl.prototype.initialize = function(map){
    var container = document.createElement("div");
    
    var fullMapDiv = document.createElement("div");
    this.setButtonStyle_(fullMapDiv);
    container.appendChild(fullMapDiv);
    fullMapDiv.appendChild(document.createTextNode("Full Map of Indonesia"));
    
    // event yang dipanggil jika tombol full map diklik
    GEvent.addDomListener(fullMapDiv, "click", function(){
        showFullIndonesiaMap();
    });
    
    map.getContainer().appendChild(container);
    return container;
}

// Posisi dari tombol di peta
FullMapControl.prototype.getDefaultPosition = function(){
    return new GControlPosition(G_ANCHOR_TOP_LEFT, new GSize(50, 7));
}

// CSS dari button
FullMapControl.prototype.setButtonStyle_ = function(button){
    button.style.color = "#000";
    button.style.backgroundColor = "white";
    button.style.font = "12px Arial";
    button.style.border = "1px solid black";
    button.style.padding = "2px";
    button.style.textAlign = "center";
    button.style.width = "130px";
    button.style.height = "15px";
    button.style.cursor = "pointer";
}


