$(document).ready(function() {
	initialize();
});

function initialize() {
        // var mapOptions = {
          // center: new google.maps.LatLng(-2.0, 118.0),
          // zoom: 5,
          // mapTypeId: google.maps.MapTypeId.ROADMAP
        // };
        // var map = new google.maps.Map(document.getElementById("map_canvas"),
            // mapOptions);
			
		// var marker = new google.maps.Marker({
            // position: new google.maps.LatLng(104.037,0.9952),
            // map: map,
            // title: 'Hello World!'
        // });
		
		var myLatlng = new google.maps.LatLng(-2.0, 118.0);
        var mapOptions = {
          zoom: 4,
          center: myLatlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(-6.20793, 106.846),
            map: map,
            title: 'Rumah Gudang'
        });		
		var contentString = '<div class="infoDialog"><h4>Rumah Gudang</h4>' + 
			'<img class="alignleft" src="http://1.bp.blogspot.com/_c4cQKfvVnCw/TQw7yoeVYII/AAAAAAAAAIA/lFWLYTY1HV4/s1600/rumh+gudang.jpg" alt="">' + 
			'<p>Rumah Gudang berbentuk persegi panjang yang memanjang dari depan ke belakang. Atap rumahnya tampak seperti pelana kuda atau perisai, dan di bagian muka rumah terdapat atap kecil yang berfungsi sebagai penahan tempias hujan atau cahaya matahari.' + 
			' <span class="read-more"><a href="http://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">'+
            'Selengkapnya</a>' + 
			'</span></p><div class="clear-left"></div></div>';

        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });
		google.maps.event.addListener(marker, 'click', function() {
          infowindow.open(map,marker);
        });
		
		
		var marker2 = new google.maps.Marker({
            position: new google.maps.LatLng(-0.7399397, 100.8000051),
            map: map,
            title: 'Rumah Gadang'
        });		
		var contentString2 = '<div class="infoDialog"><h4>Rumah Gadang</h4>' + 
			'<img class="alignleft" width="300px" height="200px" src="http://2.bp.blogspot.com/_RTiDGbiwjDs/TDYXBiLzqDI/AAAAAAAAAa0/SnyGxEogXDw/s1600/minang+kabau.jpg" alt="">' + 
			'<p>Rumah Gadang memiliki tiang yang tidak tegak lurus atau horizontal tapi punya kemiringan. Kenapa?' + 
			' Karena dulu, masyarakat di sana banyak yang datang dari laut, sehingga mereka hanya tahu cara membuat kapal dan tak tahu cara membuat rumah.' + 
			' <span class="read-more"><a href="http://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">'+
            'Selengkapnya</a>' + 
			'</span></p><div class="clear-left"></div></div>';

        var infowindow2 = new google.maps.InfoWindow({
            content: contentString2
        });
		google.maps.event.addListener(marker2, 'click', function() {
          infowindow2.open(map,marker2);
        });
		
}

