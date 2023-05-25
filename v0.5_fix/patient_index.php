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
if(!isset($_SESSION))
{
session_start();
}
if(isset($_SESSION["usertype"]) && $_SESSION["usertype"]=='patient') {

$conn = mysqli_connect('localhost', 'root', '', 'Client');

include("components/navbar.php");
?>

<div class="std_container">
	<div class="main">
		<div class="list">
			<div class="list_title"><h3>Rendez-vous en cours</h3></div>

				<?php
				$patient_id = $_SESSION["id"];

				//set & save patient_appthistory then set & save patient_apptlist
				if (isset($_POST['appt_id']) && isset($_POST['appt_id_state'])) {
					$appt_id = $_POST['appt_id'];
					$appt_id_state = $_POST['appt_id_state'];

					//get patient_appthistory
					$stmt = $conn->prepare( "SELECT patient_appthistory FROM patient WHERE patient_id = ?");
		    	    $stmt->bind_param("i",$patient_id);
		    	    $stmt->execute();
					$result = $stmt->get_result();
		    	    $row = $result->fetch_assoc() ;
					$patient_appthistory = $row['patient_appthistory'];

					//set new patient_appthistory
					$patient_appthistory_el = array($appt_id, $appt_id_state);
					if (empty($patient_appthistory))
					{
						$patient_appthistory = json_encode([$patient_appthistory_el]);
					}
					else
					{
						$patient_appthistory = json_decode($patient_appthistory);
						$patient_appthistory[] = $patient_appthistory_el;
						$patient_appthistory = json_encode($patient_appthistory);
					}

					//save new patient_appthistory
					$stmt = $conn->prepare("UPDATE patient SET patient_appthistory = ? WHERE patient_id = ?");
					$stmt->bind_param("si", $patient_appthistory, $patient_id);
					$stmt->execute();
					
					//get patient_apptlist
					$stmt = $conn->prepare( "SELECT patient_apptlist FROM patient WHERE patient_id = ?");
			        $stmt->bind_param("i", $patient_id);
			        $stmt->execute();
					$result = $stmt->get_result();
			        $row = $result->fetch_assoc() ;
					$patient_apptlist = json_decode($row['patient_apptlist']);

					//set new patient_apptlist (remove appt_id from patient_apptlist)
					for ($i = 0; $i < count($patient_apptlist); $i++)
					{
						if ($patient_apptlist[$i] == $appt_id)
						{
							\array_splice($patient_apptlist, $i, 1);
						}
					}
					$patient_apptlist = json_encode($patient_apptlist);

					//save new patient_apptlist
					$stmt = $conn->prepare("UPDATE patient SET patient_apptlist = ? WHERE  patient_id = ?");
					$stmt->bind_param("si", $patient_apptlist, $patient_id);
					$stmt->execute();

					//get appt data for appt
					$stmt = $conn->prepare( "SELECT * FROM appt WHERE appt_id  = ?");
					$stmt->bind_param("i",$appt_id);
					$stmt->execute();
					$result = $stmt->get_result();
					$row = $result->fetch_assoc() ;
					$appt_doctor_id = $row['appt_doctor_id'];

					//get doctor_apptlist
					$stmt = $conn->prepare( "SELECT doctor_apptlist FROM doctor WHERE doctor_id = ?");
			        $stmt->bind_param("i", $appt_doctor_id);
			        $stmt->execute();
					$result = $stmt->get_result();
			        $row = $result->fetch_assoc() ;
					$doctor_apptlist = json_decode($row['doctor_apptlist']);

					//set new doctor_apptlist (remove appt_id from doctor_apptlist)
					for ($i = 0; $i < count($doctor_apptlist); $i++)
					{
						if ($doctor_apptlist[$i] == $appt_id)
						{
							\array_splice($doctor_apptlist, $i, 1);
						}
					}
					$doctor_apptlist = json_encode($doctor_apptlist);

					//save new doctor_apptlist
					$stmt = $conn->prepare("UPDATE doctor SET doctor_apptlist = ? WHERE  doctor_id = ?");
					$stmt->bind_param("si", $doctor_apptlist, $appt_doctor_id);
					$stmt->execute();
				}

				//get patient_apptlist
				$stmt = $conn->prepare( "SELECT patient_apptlist FROM patient WHERE patient_id = ?");
		        $stmt->bind_param("i",$patient_id);
		        $stmt->execute();
				$result = $stmt->get_result();
		        $row = $result->fetch_assoc() ;
				$patient_apptlist = json_decode($row['patient_apptlist']);

				//display patient_applist
				if ($patient_apptlist == null) $null_patient_apptlist = true; else $null_patient_apptlist = false;
				if (!$null_patient_apptlist)
				{
					for ($i = 0; $i < count($patient_apptlist); $i++)
					{
						$appt_id=$patient_apptlist[$i];
						include("components/patient_apptlist_el.php");
					}
				}
				?>

			<div class="apptlist_null"><?php if ($null_patient_apptlist) echo "Pas de rendez-vous en cours !"; ?></div>
		</div>
		<div class="list">
			<div class="list_title"><h3>Historique des Rendez-vous</h3></div>

				<?php
				//get patient_appthistory
				$stmt = $conn->prepare( "SELECT patient_appthistory FROM patient WHERE patient_id = ?");
		        $stmt->bind_param("i",$patient_id);
		        $stmt->execute();
				$result = $stmt->get_result();
		        $row = $result->fetch_assoc() ;
				$patient_appthistory = json_decode($row['patient_appthistory']);

				//display patient_appthisotry
				if ($patient_appthistory == null) $null_patient_appthistory = true; else $null_patient_appthistory = false;
				if (!$null_patient_appthistory)
				{
					for ($i = 0; $i < count($patient_appthistory); $i++)
					{
						$appt_id=$patient_appthistory[$i][0];
						$state=$patient_appthistory[$i][1];
						include("components/patient_appthistory_el.php");
					}
				}
				?>

			<div class="appthistory_null"><?php if ($null_patient_appthistory) echo "Pas de rendez-vous a afficher !"; ?></div>
		</div>
	</div>
	<div class="secondary">
		<div id="doctor_profile"></div>
	</div>
</div>

<?php
$conn->close();

?>

<script src="index.js"></script>
<script type="text/javascript">
	setTimeout(() => {
		showprofile();
	}, 1000);
</script>
</body>
</html>
<?php   }elseif(isset($_SESSION["usertype"]) && $_SESSION["usertype"]=='doctor'){

header("Location: doctor_index.php");
exit();

}else{

  header("Location: index.php");
  exit();
}  ?>