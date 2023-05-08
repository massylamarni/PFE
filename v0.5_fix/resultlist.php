<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="index.css">
	<title>Visuals</title>
</head>
<body>		
		
<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define("DB_NAME","Client");

include("components/navbar.php");

$location=$_POST["location"];
$speciality=$_POST["speciality"];

$location= trim($location);
$speciality=trim($speciality);

$conn = mysqli_connect('localhost', 'root', '', DB_NAME);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$searchLocation = "%" . $location . "%";
$searchSpeciality = "%" . $speciality . "%";

if($location && $speciality){

	$stmt = $conn->prepare("SELECT * FROM doctor WHERE location LIKE ? AND speciality LIKE ? ");
	$stmt->bind_param("ss", $searchLocation , $searchSpeciality);
}elseif($location){   

	$stmt = $conn->prepare("SELECT * FROM doctor WHERE location LIKE ? ");
	$stmt->bind_param("s", $searchLocation );
}else{

	$stmt = $conn->prepare("SELECT * FROM doctor WHERE speciality LIKE ? ");
	$stmt->bind_param("s", $searchSpeciality );
}

	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows >0 ) {
 
		while($row = $result->fetch_assoc()){
			echo "<br>";echo "<br>";echo "<br>";echo "<br>";echo "<br>";
			echo "ID: " . $row["id"]. " - Name: " . $row["name"]. " - tel: " . $row["phone"]. "<br>";
		}	

	}else {
		echo "<br>";echo "<br>";echo "<br>";echo "<br>";echo "<br>";
		echo "0 results";
	}
	$conn->close();
?>

<div class="std_containerI">
	<div class="fetchto"></div>
	<div class="main">
		<div class="list">
			<div class="list_title"><h3>Resultats de recherche</h3></div>
			<div class="list_map"></div>
			<div class="resultlist_null">Aucun resultat trouvé</div>
		</div>
		<?php include("components/bookform.php"); ?>
	</div>
	<div class="secondary">
		<?php include("components/PS_profile.php"); ?>
	</div>
</div>

<script src="index.js"></script>
<script type="text/javascript">
	updateresultlist(0);
</script>
</body>
</html>   