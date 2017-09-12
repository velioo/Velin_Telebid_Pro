//This code is written into the "Scripts n Styles" wordpress plgin javascript box
var markers_count = 0;     
var markers = [];

function initMap() {
	
		var center = {lat: parseFloat(lat[0]), lng: parseFloat(lon[0])};

			var map = new google.maps.Map(document.getElementById('map'), {
			  zoom: 4,
		  center: center
			});

		$.each(lat, function(i, value) {
			var point = {lat: parseFloat(lat[i]), lng: parseFloat(lon[i])};

          	var infowindow = new google.maps.InfoWindow({
               content: city[i]
            });

          	
			var marker = new google.maps.Marker({
			  position: point,
			  map: map ,
              title: city[i],
              category: country[i],
              population: population[i]
			});
          
          	marker.addListener('click', function() {
                 infowindow.open(map, marker);
       	    });
           
          markers.push(marker);
          markers_count++;

		});


      }


filterMarkers = function (category) {
  
    var pop1 = parseInt(document.getElementById("population1").value);
    var pop2 = parseInt(document.getElementById("population2").value);
    var category = document.getElementById('cities').options[document.getElementById('cities').selectedIndex].value;
  
    for (i = 0; i < markers_count; i++) {
        marker = markers[i];
        if ((marker.category == category || category.length === 0) && (marker.population >= pop1 && marker.population <= pop2)) {
            marker.setVisible(true);
        }
        else {
            marker.setVisible(false);
        }
    }
}


