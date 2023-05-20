<!DOCTYPE html>
<html>
<head>
  <style>
    
    #map {
      height: 100%;
      width: 100%;
    }
  </style>
</head>
<body>

  <div id="map"></div>

  <script>
var previousClickedLocation;

    function initMap() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {

          var lat = 36.716667;
          var lng = 4.05;

          
          var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: {lat: lat, lng: lng},
            styles: [
              {
                featureType: 'poi',
                stylers: [{ visibility: 'off' }]
              },
              {
                featureType: 'transit',
                stylers: [{ visibility: 'off' }]
              },
              {
                featureType: 'landscape',
                elementType: 'labels',
                stylers: [{ visibility: 'off' }]
              },
              {
                featureType: 'administrative',
                elementType: 'labels',
                stylers: [{ visibility: 'off' }]
              },
              {
                featureType: 'poi',
                elementType: 'labels',
                stylers: [{ visibility: 'off' }]
              },
              {
                featureType: 'road',
                elementType: 'geometry',
                stylers: [{ visibility: 'on' }]
              },
              {
                featureType: 'road',
                elementType: 'labels',
                stylers: [{ visibility: 'on' }]
              }
            ]
          });
          
<?php $location = basename($_SERVER['PHP_SELF']);
 
  if( $location =="doctor_editprofile.php"){  


    $stmt = $conn->prepare("SELECT doctor_coord FROM doctor WHERE doctor_id = ?");
    $stmt->bind_param("s", $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();
	  $row = $result->fetch_assoc(); 

if (!isset($row["doctor_coord"])){ ?>
   previousClickedLocation = null;
  var marker = null ;

<?php  }else{  ?>
   
   previousClickedLocation = JSON.parse('<?php echo $row["doctor_coord"]; ?>') ;
  var marker = new google.maps.Marker({
            position: previousClickedLocation,
            map: map,
          });  
<?php }  ?>


     map.addListener('click', function(event) {
      var clickedLocation  = event.latLng;

      if (previousClickedLocation) {
            marker.setMap(null);
            marker = new google.maps.Marker({
            position: clickedLocation,
            map: map,
          });
        }else{
            marker = new google.maps.Marker({
            position: clickedLocation,
            map: map,
          });    
  }
  previousClickedLocation = clickedLocation;
  });

<?php } elseif( $location =="resultlist.php") {   


    $stmt = $conn->prepare("SELECT doctor_coord, doctor_name FROM doctor WHERE doctor_id = ?");
    $stmt->bind_param("i", $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();
	  $row = $result->fetch_assoc(); 
  

    if (isset($row["doctor_coord"])){ ?>

    var doctorlocation = JSON.parse('<?php echo $row["doctor_coord"]; ?>') ;
  
          var marker = new google.maps.Marker({
            position: doctorlocation,
            map: map,
            title: "<?php echo $row["doctor_name"]; ?>"
          });  
<?php  } 
    }
?>

        });
      } else {
        alert('Geolocation is not supported by this browser.');
      }
    }
  </script>

  <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD-qNfUHkLlb4H_hEqq_ptDBbKWhay_Yw8&libraries=places&callback=initMap">
  </script>
</body>
</html>
