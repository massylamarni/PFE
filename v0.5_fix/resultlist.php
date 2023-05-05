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
		
<?php include("components/navbar.php");
define("DB_NAME","Client");

$location=$_POST["location"];
$speciality=$_POST["speciality"];


$conn = mysqli_connect('localhost', 'root', '', DB_NAME);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if($location && $speciality){

	$stmt = $conn->prepare("SELECT * FROM doctor WHERE location = ? AND speciality = ? ");
	$stmt->bind_param("ss", $location , $speciality);
}elseif($location){   

	$stmt = $conn->prepare("SELECT * FROM doctor WHERE location = ? ");
	$stmt->bind_param("s", $location );
}else{

	$stmt = $conn->prepare("SELECT * FROM doctor WHERE speciality = ? ");
	$stmt->bind_param("s", $speciality );
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