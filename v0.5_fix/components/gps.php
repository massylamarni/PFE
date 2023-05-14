<!DOCTYPE html>
<html>
<head>
  <style>
    
    #map {
      height: 400px;
      width: 100%;
    }
  </style>
</head>
<body>
  <h1>Recherche des medecins...</h1>

  <div id="map"></div>

  <script>

    function initMap() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {

          var lat = position.coords.latitude;
          var lng = position.coords.longitude;

          
          var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: {lat: lat, lng: lng}
          });

          var marker = new google.maps.Marker({
            position: {lat: lat, lng: lng},
            map: map,
            title: 'Ma location actuelle'
          });

          var request = {
            location: {lat: lat, lng: lng},
            radius: '5000', 
            type: 'doctor' 
          };

          var service = new google.maps.places.PlacesService(map);

          
          service.nearbySearch(request, function(results, status) {
            if (status == google.maps.places.PlacesServiceStatus.OK) {
          
              for (var i = 0; i < results.length; i++) {
               
                var place = results[i];
                var placeMarker = new google.maps.Marker({
                  position: place.geometry.location,
                  map: map,
                  title: place.name
                });
              }
            }
          });
        }, function(error) {
         
          alert('Error: ' + error.message);
        });
      } else {
        alert('Geolocation is not supported by this browser.');
      }
    }
  </script>

  <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCASd53YmtUivYtBqjgB-Vhg9IJVMEwTUE&libraries=places&callback=initMap">
  </script>
</body>
</html>
