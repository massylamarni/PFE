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
//ini_set('display_errors', 1);

$conn = mysqli_connect('localhost', 'root', '', 'Client');

include("components/navbar.php");
?>

<div class="std_containerI">
	<div class="main">
		<div class="list">
			<div class="list_title"><h3>Resultats de recherche</h3></div>
			<div class="list_map"></div>

<?php
//resultsearch function
if ($_POST["location"] & $_POST["speciality"])
{
	$location=$_POST["location"];
	$speciality=$_POST["speciality"];
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
}
	//display searchresults
	$appt_searchresult = array(1, 2, 3, 4);
	if ($appt_searchresult == null) $null_appt_searchresult = true; else $null_appt_searchresult = false;
	if (!$null_appt_searchresult)
	{
		for ($i = 0; $i < count($appt_searchresult); $i++)
		{
			$doctor_id=$appt_searchresult[$i];
			include("components/resultlist.php");
		}
	}

	//save appt process
	$appt_patient_id = $_SESSION['patient_id'];
	$appt_doctor_id = $_POST['doctor_id'];
	$appt_date = $_POST['appt_date'];
	$appt_keep_date = (new DateTime())->format('r');
	$appt_motif = $_POST['appt_motif'];
	if (!$appt_motif) $appt_motif = "Motif inconnus.";

	if ($doctor_id && $appt_date)
	{
		//save appt
		$stmt = $conn->prepare("INSERT INTO appt (appt_patient_id, appt_doctor_id, appt_date,  appt_keep_date, appt_motif) VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param("issss", $appt_patient_id, $appt_doctor_id, $appt_date,  $appt_keep_date, $appt_motif);
		$stmt->execute();

		$appt_id = mysqli_insert_id($conn);

		//get patient_apptlist
		$stmt->reset();
		$query = "SELECT patient_apptlist FROM patient WHERE patient_id = $appt_patient_id";
		$result = mysqli_query($conn, $query);
		$data = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$data[] = $row;
		}
		$patient_apptlist = $data[0]['patient_apptlist'];

		//set new patient_apptlist
		if (empty($patient_apptlist))
		{
			$patient_apptlist = json_encode([$appt_id]);
		}
		else
		{
			$patient_apptlist = json_decode($patient_apptlist);
			array_push($patient_apptlist, $appt_id);
			$patient_apptlist = json_encode($patient_apptlist);
		}

		//save new patient_apptlist
		$stmt = $conn->prepare("update patient set patient_apptlist = ? where patient . patient_id = ?");
		$stmt->bind_param("ss", $patient_apptlist, $appt_patient_id);
		$stmt->execute();

		//close & exit
		$stmt->close();
	}
?>
		</div>
	</div>
	<div class="secondary">
		<?php include("components/PS_profile.php"); ?>
	</div>
</div>

<?php
$conn->close();
?>

<script src="index.js"></script>
</body>
</html>   