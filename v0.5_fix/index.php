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
	<div class="fetchto"></div>
	<div class="main">
		<div class="list">
			<div class="list_title"><h3>Rendez-vous en cours</h3></div>

				<?php
				//get patient_apptlist
				$query = "SELECT patient_apptlist FROM patient";
				$result = mysqli_query($conn, $query);
				$data = array();
				while ($row = mysqli_fetch_assoc($result)) {
	    			$data[] = $row;
				}
				$patient_apptlist = json_decode($data[0]['patient_apptlist']);

				//set & save patient_appthistory then set & save patient_apptlist
				if ($_POST['appt_id'] && $_POST['appt_id_state'])
				{
					$appt_id = $_POST['appt_id'];
					$appt_id_state = $_POST['appt_id_state'];

					//get patient_appthistory
					$patient_id = $_SESSION["patient_id"];
					$query = "SELECT patient_appthistory FROM patient where patient_id = $patient_id";
					$result = mysqli_query($conn, $query);
					$data = array();
					while ($row = mysqli_fetch_assoc($result)) {
					    $data[] = $row;
					}
					$patient_appthistory = $data[0]['patient_appthistory'];

					//set new patient_appthistory
					$patient_appthistory_el = array($appt_id, $appt_id_state);
					if (empty($patient_appthistory))
					{
						$patient_appthistory = json_encode([$patient_appthistory_el]);
					}
					else
					{
						$patient_appthistory = json_decode($patient_appthistory);
						array_push($patient_appthistory, $patient_appthistory_el);
						$patient_appthistory = json_encode($patient_appthistory);
					}

					//save new patient_appthistory
					$stmt = $conn->prepare("update patient set patient_appthistory = ? where patient . patient_id = ?");
					$stmt->bind_param("si", $patient_appthistory, $patient_id);
					$stmt->execute();
					$stmt->reset();
	
					$patient_id = $_SESSION["patient_id"];

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
					$stmt = $conn->prepare("update patient set patient_apptlist = ? where patient . patient_id = ?");
					$stmt->bind_param("si", $patient_apptlist, $patient_id);
					$stmt->execute();

					$stmt->close();
				}
				
				//get patient_apptlist
				$query = "SELECT patient_apptlist FROM patient";
				$result = mysqli_query($conn, $query);
				$data = array();
				while ($row = mysqli_fetch_assoc($result)) {
	    			$data[] = $row;
				}
				$patient_apptlist = json_decode($data[0]['patient_apptlist']);

				//display patient_applist
				if ($patient_apptlist == null) $null_patient_apptlist = true; else $null_patient_apptlist = false;
				if (!$null_patient_apptlist)
				{
					echo $patient_apptlist;
					for ($i = 0; $i < count($patient_apptlist); $i++)
					{
						$appt_id=$patient_apptlist[$i];
						include("components/apptlist.php");
					}
				}
				?>

			<div class="apptlist_null"><?php if ($null_patient_apptlist) echo "Pas de rendez-vous en cours !"; ?></div>
		</div>
		<div class="history">
			<div class="list_title"><h3>Historique des Rendez-vous</h3></div>

				<?php
				//get patient_appthistory
				$query = "SELECT patient_appthistory FROM patient";
				$result = mysqli_query($conn, $query);
				$data = array();
				while ($row = mysqli_fetch_assoc($result)) {
					$data[] = $row;
				}
				$patient_appthistory = json_decode($data[0]['patient_appthistory']);

				//display patient_appthisotry
				if ($patient_appthistory == null) $null_patient_appthistory = true; else $null_patient_appthistory = false;
				if (!$null_patient_appthistory)
				{
					for ($i = 0; $i < count($patient_appthistory); $i++)
					{
						$appt_id=$patient_appthistory[$i][0];
						$state=$patient_appthistory[$i][1];
						include("components/appthistory.php");
					}
				}
				?>

			<div class="appthistory_null"><?php if ($null_patient_appthistory) echo "Pas de rendez-vous a afficher !"; ?></div>
		</div>
	</div>
	<div class="secondary">
		<?php include("components/PS_profile.php"); ?>
	</div>
</div>

<?php
$conn->close();
exit();
?>

<script src="index.js"></script>
<script type="text/javascript">
	setTimeout(() => {
		showprofile();
	}, 1000);
</script>
</body>
</html>