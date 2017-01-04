/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var marker;
function getLatLong(gps_lat, gps_long) {
    map_center = new GLatLng(gps_lat, gps_long);
}
// Retrieve the URL parameter specified
function getURLParam(strParamName) {
    var strReturn = "";
    var strHref = window.location.href;
    if (strHref.indexOf("?") > -1) {
        var strQueryString = strHref.substr(strHref.indexOf("?")).toLowerCase();
        var aQueryString = strQueryString.split("&");
        for (var iParam = 0; iParam < aQueryString.length; iParam++) {
            if (aQueryString[iParam].indexOf(strParamName + "=") > -1) {
                var aParam = aQueryString[iParam].split("=");
                strReturn = aParam[1];
                break;
            }
        }
    }
    return strReturn;
}

// A function to create the marker and set up the event window
function centerMarker() {
    marker.setPoint(new GLatLng(map.getCenter().lat(), map.getCenter().lng()))
    document.getElementById('lat').value = marker.getPoint().lat();
    document.getElementById('lng').value = marker.getPoint().lng();
}

// A function to create the marker and set up the event window
function createMarker(point, name, html) {
    var i = new GIcon(G_DEFAULT_ICON, "smallmarker.png");
    i.iconSize = new GSize(12, 20);
    i.iconAnchor = new GPoint(6, 20);
    i.shadowSize = new GSize(12, 20);
    var m = new GMarker(point, {icon: i});
    GEvent.addListener(m, "click", function() {
        m.openInfoWindowHtml("<b>" + name + "</b><br />" + html);
    });
    map.addOverlay(m);
}

function saveMarker() {
    var lat = document.getElementById('lat').value;
    var lng = document.getElementById('lng').value;
    var title = document.getElementById('title').value;
    var desc = document.getElementById('desc').value;
    var str;
    str = "<Placemark>\n";
    str += "  <name>" + title + "</name>\n";
    str += "  <description><![CDATA[" + desc + "]]></description>\n";
    str += "  <Point>\n";
    str += "    <coordinates>" + lng + "," + lat + ",0</coordinates>\n";
    str += "  </Point>\n";
    str += "</Placemark>\n";

    document.getElementById('xml').value = document.getElementById('xml').value + str;
    createMarker(new GPoint(lng, lat), title, desc);
}

if (GBrowserIsCompatible()) {

    var map = new GMap2(document.getElementById("map"));
    map.addControl(new GLargeMapControl());
    map.addControl(new GMapTypeControl());
    map.setMapType(G_NORMAL_MAP);
    var map_center = new GLatLng(35.673343, 139.710388);
    var map_canvas = document.getElementById('map');
    if (map_canvas) {
        var gps_lat = map_canvas.getAttribute("gps_lat");
        var gps_lng = map_canvas.getAttribute("gps_lng");
        if (gps_lat != '' && gps_lng != '') {
            map_center = new GLatLng(gps_lat, gps_lng);
        }
    }
    map.setCenter(map_center, 13);

    marker = new GMarker(map_center, {icon: new GIcon(G_DEFAULT_ICON, "img/marker.png"), draggable: true});

    GEvent.addListener(marker, "dragstart", function() {
        map.closeInfoWindow();
    });

    GEvent.addListener(marker, "dragend", function() {
        document.getElementById('lat').value = marker.getPoint().lat();
        document.getElementById('lng').value = marker.getPoint().lng();
    });

    map.addOverlay(marker);

}
else {
    alert("Sorry, the Google Maps API is not compatible with this browser");
}