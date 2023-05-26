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

if(!isset($_SESSION))
{
session_start();
}
if(isset($_SESSION["usertype"]) && $_SESSION["usertype"]=='doctor') {

$conn = mysqli_connect('localhost', 'root', '', 'Client');

include("components/navbar.php");
?>

<div class="std_container">
	<div class="main">
		<div class="list">
			<div class="list_title"><h3>Rendez-vous en cours</h3></div>
			<button type="button" onclick="addto_apptlist(0)">Ajouter un RDV</button>

				<?php
				$doctor_id = $_SESSION["id"];

				//set & save doctor_appthistory then set & save doctor_apptlist
				if (isset($_POST['appt_id']) && isset($_POST['appt_id_state'])) {
					$appt_id = $_POST['appt_id'];
					$appt_id_state = $_POST['appt_id_state'];

					//get doctor_appthistory
					$stmt = $conn->prepare( "SELECT doctor_appthistory FROM doctor WHERE doctor_id = ?");
					$stmt->bind_param("i",$doctor_id);
					$stmt->execute();
					$result = $stmt->get_result();
					$row = $result->fetch_assoc() ;
					$doctor_appthistory = $row['doctor_appthistory'];

					//set new doctor_appthistory
					$doctor_appthistory_el = array($appt_id, $appt_id_state);
					if (empty($doctor_appthistory))
					{
						$doctor_appthistory = json_encode([$doctor_appthistory_el]);
					}
					else
					{
						$doctor_appthistory = json_decode($doctor_appthistory);
						$doctor_appthistory[] = $doctor_appthistory_el;
						$doctor_appthistory = json_encode($doctor_appthistory);
					}

					//save new doctor_appthistory
					$stmt = $conn->prepare("UPDATE doctor SET doctor_appthistory = ? WHERE doctor_id = ?");
					$stmt->bind_param("si", $doctor_appthistory, $doctor_id);
					$stmt->execute();

					//get doctor_apptlist
					$stmt = $conn->prepare( "SELECT doctor_apptlist FROM doctor WHERE doctor_id = ?");
					$stmt->bind_param("i", $doctor_id);
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
					$stmt->bind_param("si", $doctor_apptlist, $doctor_id);
					$stmt->execute();

					//get appt data for appt
					$stmt = $conn->prepare( "SELECT * FROM appt WHERE appt_id  = ?");
					$stmt->bind_param("i", $appt_id);
					$stmt->execute();
					$result = $stmt->get_result();
					$row = $result->fetch_assoc();
					$appt_patient_id = $row['appt_patient_id'];

					//get patient_appthistory
					$stmt = $conn->prepare( "SELECT patient_appthistory FROM patient WHERE patient_id = ?");
					$stmt->bind_param("i",	$appt_patient_id);
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
					$stmt->bind_param("si", $patient_appthistory, $appt_patient_id);
					$stmt->execute();

					//get patient_apptlist
					$stmt = $conn->prepare( "SELECT patient_apptlist FROM patient WHERE patient_id = ?");
					$stmt->bind_param("i", $appt_patient_id);
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
					$stmt->bind_param("si", $patient_apptlist, $appt_patient_id);
					$stmt->execute();
				}
				
				//get doctor_apptlist
				$stmt = $conn->prepare("SELECT doctor_apptlist FROM doctor WHERE doctor_id = ?");
				$stmt->bind_param("i", $doctor_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$row = $result->fetch_assoc() ;
				$doctor_apptlist = json_decode($row['doctor_apptlist']);

				//display doctor_apptlist
				if ($doctor_apptlist == null) $null_doctor_apptlist = true; else $null_doctor_apptlist = false;
				if (!$null_doctor_apptlist)
				{
					for ($i = 0; $i < count($doctor_apptlist); $i++)
					{
						$appt_id=$doctor_apptlist[$i];
						include("components/doctor_apptlist_el.php");
					}
				}

				if(isset($_POST["PS_apptlist_blank_submit"]))
				{
					$tpatient_name = $_POST['tpatient_name'];
					$tpatient_pf_img = $_POST['tpatient_pf_img'];
					$tpatient_appt_date = $_POST['appt_date'];
					$tpatient_appt_motif = $_POST['appt_motif'];
					$tpatient_appt_keep_date = (new DateTime())->format('r');
					$tpatient_doctor_id = $_SESSION['id'];
					if (!$tpatient_pf_img) $tpatient_pf_img = "assets/pfp2.png";

					//save tpatient					
					$stmt = $conn->prepare("insert into tpatient (tpatient_name, tpatient_pf_img, tpatient_appt_date, tpatient_appt_keep_date, tpatient_doctor_id, tpatient_appt_motif) values (?, ?, ?, ?, ?, ?)");
					$stmt->bind_param("ssssis", $tpatient_name, $tpatient_pf_img, $tpatient_appt_date, $tpatient_appt_keep_date, $tpatient_doctor_id, $tpatient_appt_motif);
					$stmt->execute();

					$tpatient_id = mysqli_insert_id($conn);

					//get doctor_tapptlist
					$stmt = $conn->prepare( "SELECT doctor_tapptlist FROM doctor WHERE doctor_id = ?");
					$stmt->bind_param("i", $tpatient_doctor_id);
					$stmt->execute();

					$result = $stmt->get_result();
					$row = $result->fetch_assoc();
					$doctor_tapptlist = $row['doctor_tapptlist'];

					//set new doctor_tapptlist
					if (empty($doctor_tapptlist))
					{
						$doctor_tapptlist = json_encode([$tpatient_id]);
					}
					else
					{
						$doctor_tapptlist = json_decode($doctor_tapptlist);
						$doctor_tapptlist[] = $tpatient_id;
						$doctor_tapptlist = json_encode($doctor_tapptlist);
					}
				
					//save new doctor_tapptlist
					$stmt = $conn->prepare("UPDATE doctor SET doctor_tapptlist = ? WHERE doctor_id = ?");
					$stmt->bind_param("si", $doctor_tapptlist, $tpatient_doctor_id);
					$stmt->execute();
				}

				//set & save doctor_tappthistory then set & save doctor_tapptlist
				if (isset($_POST['tpatient_id']) && isset($_POST['tpatient_id_state']))
				{
					$tpatient_id = $_POST['tpatient_id'];
					$tpatient_id_state = $_POST['tpatient_id_state'];

					//get doctor_tappthistory
					$stmt = $conn->prepare( "SELECT doctor_tappthistory FROM doctor WHERE doctor_id = ?");
					$stmt->bind_param("i", $doctor_id);
					$stmt->execute();
					$result = $stmt->get_result();
					$row = $result->fetch_assoc() ;
					$doctor_tappthistory = $row['doctor_tappthistory'];

					//set new doctor_tappthistory
					$doctor_tappthistory_el = array($tpatient_id, $tpatient_id_state);
					if (empty($doctor_tappthistory))
					{
						$doctor_tappthistory = json_encode([$doctor_tappthistory_el]);
					}
					else
					{
						$doctor_tappthistory = json_decode($doctor_tappthistory);
						$doctor_tappthistory[] = $doctor_tappthistory_el;
						$doctor_tappthistory = json_encode($doctor_tappthistory);
					}

					//save new doctor_tappthistory
					$stmt = $conn->prepare("UPDATE doctor SET doctor_tappthistory = ? WHERE doctor_id = ?");
					$stmt->bind_param("si", $doctor_tappthistory, $doctor_id);
					$stmt->execute();

					//get doctor_tapptlist
					$stmt = $conn->prepare( "SELECT doctor_tapptlist FROM doctor WHERE doctor_id = ?");
					$stmt->bind_param("i", $doctor_id);
					$stmt->execute();
					$result = $stmt->get_result();
					$row = $result->fetch_assoc() ;
					$doctor_tapptlist = json_decode($row['doctor_tapptlist']);

					//set new doctor_tapptlist (remove appt_id from doctor_tapptlist)
					for ($i = 0; $i < count($doctor_tapptlist); $i++)
					{
						if ($doctor_tapptlist[$i] == $tpatient_id)
						{
							\array_splice($doctor_tapptlist, $i, 1);
						}
					}
					$doctor_tapptlist = json_encode($doctor_tapptlist);

					//save new doctor_tapptlist
					$stmt = $conn->prepare("UPDATE doctor SET doctor_tapptlist = ? WHERE  doctor_id = ?");
					$stmt->bind_param("si", $doctor_tapptlist, $doctor_id);
					$stmt->execute();	
				}

				//get doctor_tapptlist
				$stmt = $conn->prepare("SELECT doctor_tapptlist FROM doctor WHERE doctor_id = ?");
				$stmt->bind_param("i", $doctor_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$row = $result->fetch_assoc() ;
				$doctor_tapptlist = json_decode($row['doctor_tapptlist']);
				
				//display doctor_tapptlist
				if ($doctor_tapptlist == null) $null_doctor_tapptlist = true; else $null_doctor_tapptlist = false;
				if (!$null_doctor_tapptlist)
				{
					for ($i = 0; $i < count($doctor_tapptlist); $i++)
					{
						$tpatient_id=$doctor_tapptlist[$i];
						include("components/doctor_tapptlist_el.php");
					}
				}
				?>

			<div class="apptlist_null"><?php if ($null_doctor_apptlist && $null_doctor_tapptlist) echo "Pas de rendez-vous en cours !"; ?></div>
		</div>
		<div class="list">
			<div class="list_title"><h3>Historique des Rendez-vous</h3></div>

				<?php
				//get doctor_appthistory
				$stmt = $conn->prepare( "SELECT doctor_appthistory FROM doctor WHERE doctor_id = ?");
				$stmt->bind_param("i",$doctor_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$row = $result->fetch_assoc() ;
				$doctor_appthistory = json_decode($row['doctor_appthistory']);

				//display doctor_appthisotry
				if ($doctor_appthistory == null) $null_doctor_appthistory = true; else $null_doctor_appthistory = false;
				if (!$null_doctor_appthistory)
				{
					for ($i = 0; $i < count($doctor_appthistory); $i++)
					{
						$appt_id=$doctor_appthistory[$i][0];
						$state=$doctor_appthistory[$i][1];
						include("components/doctor_appthistory_el.php");
					}
				}

				//get doctor_tappthistory
				$stmt = $conn->prepare( "SELECT doctor_tappthistory FROM doctor WHERE doctor_id = ?");
				$stmt->bind_param("i",$doctor_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$row = $result->fetch_assoc() ;
				$doctor_tappthistory = json_decode($row['doctor_tappthistory']);

				//display doctor_appthisotry
				if ($doctor_tappthistory == null) $null_doctor_tappthistory = true; else $null_doctor_tappthistory = false;
				if (!$null_doctor_tappthistory)
				{
					for ($i = 0; $i < count($doctor_tappthistory); $i++)
					{
						$tpatient_id=$doctor_tappthistory[$i][0];
						$state=$doctor_tappthistory[$i][1];
						include("components/doctor_tappthistory_el.php");
					}
				}
				?>

			<div class="appthistory_null"><?php if ($null_doctor_appthistory && $null_doctor_tappthistory) echo "Pas de rendez-vous a afficher !"; ?></div>
		</div>
	</div>
	<div class="secondary">
		<?php include("components/patient_profile.php"); ?>
	</div>
</div>

<?php
$conn->close();
?>

<script src="index.js"></script>
<script type="text/javascript">
	setTimeout(() => {
		//showprofile();
	}, 1000);
</script>
</body>
</html>
<?php   }elseif(isset($_SESSION["usertype"]) && $_SESSION["usertype"]=='patient'){

header("Location: patient_index.php");
exit();

}else{

  header("Location: index.php");
  exit();
}  ?>