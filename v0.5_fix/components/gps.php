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


for ($i = 0; $i < count($appt_searchresult); $i++)
{
  $doctor_id=$appt_searchresult[$i];
  
    $stmt = $conn->prepare("SELECT doctor_coord, doctor_name, speciality, doctor_verified FROM doctor WHERE doctor_id = ?");
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $result = $stmt->get_result();
	  $row = $result->fetch_assoc(); 

    if (isset($row["doctor_coord"]) && $row["doctor_verified"]==1 ){ 

   if (!isset($_SESSION)){ session_start();  }
   if (isset($_SESSION["usertype"]) && $_SESSION["usertype"]=='patient'&& $_SESSION["status"]==0 )  { ?>

 var doctorinfo =  '<div class="pf_header_text_name"><?php echo $row["doctor_name"]; ?></div>' +
  '<div class="pf_header_text_speciality"><?php echo $row["speciality"]; ?></div>'+

  '<a href="#" onclick="bookform(0, <?php echo $doctor_id; ?>)">'+'<div class="brief_book">'+
  '<p>Prendre RDV</p>'+
'</div>'+
'</a>';

<?php }else{ ?>

  var doctorinfo =  '<div class="pf_header_text_name"><?php echo $row["doctor_name"]; ?></div>' +
  '<div class="pf_header_text_speciality"><?php echo $row["speciality"]; ?></div>';

<?php } ?>



    var infowindow<?php echo $i;?> = new google.maps.InfoWindow({
      content: doctorinfo
  });
    var doctorlocation = JSON.parse('<?php echo $row["doctor_coord"]; ?>') ;
          var marker<?php echo $i;?> = new google.maps.Marker({
            position: doctorlocation,
            map: map,
            title: "<?php echo $row["doctor_name"]; ?>"
          });  

          marker<?php echo $i;?>.addListener("click", () => {
          infowindow<?php echo $i;?>.open({
          anchor: marker<?php echo $i;?>,
          map,
    });
  });

<?php  } 
   }  
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
