//Google Map object
var map;
var position_marker = null;
//Category and Area Container
var cat_stack = [];
var area_stack = [];
var relPoi_stack = [];
//Main Category
var category_count = 0;
//Area Counter
var island_ctr = 0;
var province_ctr = 0;
var area_ctr = 0;
var stack_count = 0;
var island_arr = new Array();
var province_arr = new Array();
var area_arr = new Array();
var max_area = 0;
var max_cat = 0;
var relpoi_ctr = 0;

//Google Map Functionality
function BuildMap(edit,pointX,pointY) {
    document.getElementById("map").style.display = "block";
    if(GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById("map"));
		
        if(edit)
        {
            map.setCenter(new GLatLng(pointY, pointX), 4);
        }
        else
        {
            map.setCenter(new GLatLng(-2.0, 118.0), 4);
        }

        //map.addControl(new GSmallMapControl());
        //map.addControl(new GMapTypeControl());
        //map.addControl(new GScaleControl());
        //map.disableDoubleClickZoom();
        map.enableDoubleClickZoom();
        map.enableScrollWheelZoom();

    }
    UpdatePosition();
    GEvent.addListener(map, "click", ShowPosition);
}

function ShowPosition(marker, point) {
    if (typeof(point) == "undefined" || point == null) {
        // Catch if point is undefined when showPosition is called.
        // Even though we don't expect this to happen, it does.
        return;
    }
    if (position_marker != null) {
        map.removeOverlay(position_marker);
    }
    position_marker = new GMarker(point);
    map.addOverlay(position_marker);
    document.getElementById('pointx').value=point.lng().toFixed(5).toString();
    document.getElementById('pointy').value=point.lat().toFixed(5).toString();
    map.panTo(point);
}

function UpdatePosition() {
    if (map != null) {
        if ((document.getElementById("pointy").value != "") && ((document.getElementById("pointx").value != ""))) {
            point = new GLatLng(document.getElementById('pointy').value,document.getElementById('pointx').value);
            if (position_marker != null) {
                map.removeOverlay(position_marker);
            }
            position_marker = new GMarker(point);
            position_marker = new GMarker(point);
            map.addOverlay(position_marker);
            map.panTo(point);
        }
    }
}
