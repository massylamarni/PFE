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

$conn = mysqli_connect('localhost', 'root', '', 'Client');

include("components/navbar.php");
?>

<div class="std_containerI">
	<div class="main">
		<div class="list">
			<div class="list_title"><h3>Resultats de recherche</h3></div>

<?php
//resultsearch function

if (isset($_POST["location"]) && isset($_POST["speciality"])) {
$location=$_POST["location"];
$speciality=$_POST["speciality"];

$location= trim($location);
$speciality=trim($speciality);



if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$searchLocation = "%" . $location . "%";
$searchSpeciality = "%" . $speciality . "%";

if($location && $speciality){

	$stmt = $conn->prepare("SELECT * FROM doctor WHERE doctor_location LIKE ? AND speciality LIKE ? ");
	$stmt->bind_param("ss", $searchLocation , $searchSpeciality);
}elseif($location){   

	$stmt = $conn->prepare("SELECT * FROM doctor WHERE doctor_location LIKE ? ");
	$stmt->bind_param("s", $searchLocation );
}else{

	$stmt = $conn->prepare("SELECT * FROM doctor WHERE speciality LIKE ? ");
	$stmt->bind_param("s", $searchSpeciality );
}
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows >0 ) {
		$appt_searchresult = [];
		while($row = $result->fetch_assoc()){
			
			$appt_searchresult[] = $row["doctor_id"];
		}	

	}else {
		
		echo "0 results";
	}
	
	 //display searchresults
	
	if ($appt_searchresult == null) $null_appt_searchresult = true; else $null_appt_searchresult = false;
	if (!$null_appt_searchresult)
	{ ?>
		<div class="list_map"><?php include("components/gps.php") ?></div>
<?php
		for ($i = 0; $i < count($appt_searchresult); $i++)
		{
			$doctor_id=$appt_searchresult[$i];
			include("components/resultlist_el.php");
		}
	}
}
	//save appt process
	if(isset($_POST["bookform_submit"])) { 

		$appt_patient_id = $_SESSION['id'];
		$appt_doctor_id = $_POST['doctor_id'];
		$appt_date = $_POST['appt_date'];
		$appt_keep_date = (new DateTime())->format('r');
		$appt_motif = $_POST['appt_motif'];
		if (!$appt_motif) $appt_motif = "Motif inconnus.";

		 if ($appt_date) {  
		//save appt
		$stmt = $conn->prepare("INSERT INTO appt (appt_patient_id, appt_doctor_id, appt_date,  appt_keep_date, appt_motif) VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param("iisss", $appt_patient_id, $appt_doctor_id, $appt_date,  $appt_keep_date, $appt_motif);
		$stmt->execute();

		$appt_id = mysqli_insert_id($conn);

		//get patient_apptlist
		$stmt = $conn->prepare( "SELECT patient_apptlist FROM patient WHERE patient_id = ?");
		$stmt->bind_param("i", $appt_patient_id);
		$stmt->execute();

		$result = $stmt->get_result();
		$row = $result->fetch_assoc() ;	
		$patient_apptlist = $row['patient_apptlist'];

		//set new patient_apptlist
		if (empty($patient_apptlist))
		{
			$patient_apptlist = json_encode([$appt_id]);
		}
		else
		{
			$patient_apptlist = json_decode($patient_apptlist);
			$patient_apptlist[] = $appt_id;
			$patient_apptlist = json_encode($patient_apptlist);
		}

		//save new patient_apptlist
		$stmt = $conn->prepare("UPDATE patient SET patient_apptlist = ? WHERE patient_id = ?");
		$stmt->bind_param("si", $patient_apptlist, $appt_patient_id);
		$stmt->execute();

		//get doctor_apptlist
		$stmt = $conn->prepare( "SELECT doctor_apptlist FROM doctor WHERE doctor_id = ?");
		$stmt->bind_param("i",$appt_doctor_id);
		$stmt->execute();

		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$doctor_apptlist = $row['doctor_apptlist'];

		//set new doctor_apptlist
		if (empty($doctor_apptlist))
		{
			$doctor_apptlist = json_encode([$appt_id]);
		}
		else
		{
			$doctor_apptlist = json_decode($doctor_apptlist);
			$doctor_apptlist[] = $appt_id;
			$doctor_apptlist = json_encode($doctor_apptlist);
		}

		//save new doctor_apptlist
		$stmt = $conn->prepare("UPDATE doctor SET doctor_apptlist = ? WHERE doctor_id = ?");
		$stmt->bind_param("si", $doctor_apptlist, $appt_doctor_id);
		$stmt->execute();

		$stmt->close();
		$conn->close();
	}
	}
?>
			<div id="toggle_bookform"></div>
		</div>
	</div>
	<div class="secondary">
		<div id="doctor_profile"></div>
	</div>
</div>

<script src="index.js"></script>
<script type="text/javascript">
	setTimeout(() => {
		showprofile();
	}, 1000);
</script>
</body>
</html>   