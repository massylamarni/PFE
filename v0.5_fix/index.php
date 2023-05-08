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
<!--testing IV-->

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = mysqli_connect('localhost', 'root', '', 'Client');
?>
<?php include("components/navbar.php"); ?>
<div class="std_containerI">
	<div class="fetchto"></div>
	<div class="main">
		<div class="list">
			<div class="list_title"><h3>Rendez-vous en cours</h3></div>
				<?php
				$query = "SELECT patient_apptlist FROM patient";
				$result = mysqli_query($conn, $query);
				$data = array();
				while ($row = mysqli_fetch_assoc($result)) {
	    			$data[] = $row;
				}
				$patient_apptlist = json_decode($data[0]['patient_apptlist']);
				if ($patient_apptlist == null) $null_patient_apptlist = true; else $null_patient_apptlist = false;
				if (!$null_patient_apptlist)
				{
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
				$query = "SELECT patient_appthistory FROM patient";
				$result = mysqli_query($conn, $query);
				$data = array();
				while ($row = mysqli_fetch_assoc($result)) {
					$data[] = $row;
				}
				$patient_appthistory = json_decode($data[0]['patient_appthistory']);
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

<script src="index.js"></script>
<script type="text/javascript">
	updateapptlist(0);
	//updateappthistory(0);
	setTimeout(() => {
		showprofile();
	}, 1000);
</script>
</body>
</html>