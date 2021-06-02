var markersArr;
var activeMap;
var activeInfoWindow;
var allMarkers = [];

    function initMap() {
        const map = new google.maps.Map(document.getElementById('map'), {
        center: new google.maps.LatLng(50, 30),
        zoom: 3
        });
    
        activeMap = map;
        
        getMarkers();
        // console.log('markers:');
        // console.log(markersArr);
        
        var point = { lat: 50, lng: 50 };
        markersArr.forEach(element => {
            point = { lat: parseFloat(element['lat']), lng: parseFloat(element['lng'])};
            // Add a marker at the center of the map.
            addMarker(point, map, element['name'], element['id']);
        });

          // This event listener calls addMarker() when the map is clicked.
        // google.maps.event.addListener(map, "click", (event) => {
        //     addMarker(event.latLng, map);
        // });
        


    }
    
    
// Adds a marker to the map.
function addMarker(location, map, name, id) {
    // Add the marker at the clicked location, and add the next-available label
    // from the array of alphabetical characters.
    var marker = new google.maps.Marker({
      position: location,
      label: 'A',
      map: map,
      name: name,
      id: id
    });

    marker.addListener("click", () => {
        map.setZoom(10);
        map.setCenter(marker.getPosition());

        //Close active window if exists
        if(activeInfoWindow) {
            activeInfoWindow.close();
        } else {        
            activeInfoWindow = new google.maps.InfoWindow();
        }

        // Update InfoWindow content
        activeInfoWindow.setContent(marker.get('name'));

        // Open InfoWindow
        activeInfoWindow.open(map, marker);
    });

    allMarkers.push(marker);
    
}

function getMarkerById(id) {
    allMarkers.forEach(marker => {
        var id_m = marker.get('id');
        if(id == id_m) {
            activeMap.setZoom(10);
            activeMap.setCenter(marker.getPosition());

            //Close active window if exists
            if(activeInfoWindow) {
                activeInfoWindow.close();
            } else {        
                activeInfoWindow = new google.maps.InfoWindow();
            }

            // Update InfoWindow content
            activeInfoWindow.setContent(marker.get('name'));

            // Open InfoWindow
            activeInfoWindow.open(map, marker);
        }
    });
}