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

include("components/navbar.php");
if (!isset($_SESSION)) {
	session_start();
}

if (isset($_SESSION["usertype"]) && $_SESSION["usertype"] == 'doctor') { ?>

	<div class="std_containerI">
		<div class="ep_container">
			<h3>Mon Profil</h3>
			<form class="ep_form">
<?php
	$doctor_id = $_SESSION['id'];
	$doctor_pf_img = $_SESSION['pf_img'];
	$doctor_name = $_SESSION['name'];
	$speciality = $_SESSION['speciality'];
	$doctor_phone = $_SESSION['phone'];
	$doctor_email = $_SESSION['email'];
	$description = $_SESSION['description'];
	$doctor_location = $_SESSION['location'];
	$worktime= $_SESSION['worktime'];
	$pricing = $_SESSION['pricing'];
	$dq = $_SESSION['dq'];
	$language = $_SESSION['language'];
	if ((empty($description)) || ($description == '[]')) $description = "Non definis...";
	if ((empty($doctor_location)) || ($doctor_location == '[]')) $doctor_location = "Non definis...";
	if ((empty($worktime)) || ($worktime == '[]')) $worktime = '[["Non definis...","Non definis..."],["Non definis...","Non definis..."],["Non definis...","Non definis..."],["Non definis...","Non definis..."],["Non definis...","Non definis..."],["Non definis...","Non definis..."],["Non definis...","Non definis..."]]';
	if ((empty($pricing)) || ($pricing == '[]')) $pricing = '[["Non definis... ","Non definis..."]]';
	if ((empty($dq)) || ($dq == '[]')) $dq = '[["Non definis...","Non definis..."]]';
	if ((empty($language)) || ($language == '[]')) $language = '["Non definis..."]';
	if (is_string($worktime)){ $worktime= json_decode($worktime);}
	$pricing = json_decode($pricing);
	$dq = json_decode($dq);
	$language = json_decode(($language));
?>

<div class="pf" id="pf_<?php echo $doctor_id ?>">
	<div class="pf_header">
		<img src="<?php echo $doctor_pf_img ?>">
		<div class="pf_header_text">
			<div class="pf_header_text_name"><p><?php echo $doctor_name ?></p></div>
			<div class="pf_header_text_speciality"><p><?php echo $speciality ?></p></div>
		</div>
	</div>
	<div class="pf_body">
		<div class="pf_body_field"><h3>Description</h3><p><?php  echo $description ?></p></div>
		<div class="pf_body_field"><h3>Numero telephone</h3><p><?php echo $doctor_phone ?></p></div>
		<div class="pf_body_field"><h3>Adresse</h3><p><?php echo $doctor_location ?></p></div>
		<div class="pf_body_field"><h3>Horaires de travail</h3>
			<?php
			$DAYS = array("Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam");
			for ($i = 0; $i < 7; $i++) { ?>
			<p><?php echo $DAYS[$i] ?> : <?php echo $worktime[$i][0] ?> - <?php echo $worktime[$i][1] ?></p>
			<?php } ?>
		</div>
		<div class="pf_body_field"><h3>Tarifs</h3>
			<?php foreach ($pricing as $i) { ?>
			<p><?php echo $i[0] ?> :&emsp;&emsp;&emsp; <?php echo $i[1] ?></p>
			<?php } ?>
		</div>
		<div class="pf_body_field"><h3>Diplomes & Qualifications</h3>
			<?php foreach ($dq as $i) { ?>
			<p><?php echo $i[0] ?> :&emsp;&emsp;&emsp; <?php echo $i[1] ?></p>
			<?php } ?>
		</div>
		<div class="pf_body_field"><h3>Langues parlées</h3>
			<?php foreach ($language as $i) { ?>
			<p><?php echo $i ?></p>
			<?php } ?>
		</div>
		<div class="pf_body_field"><h3>Email</h3><p><?php echo $doctor_email ?></p></div>
	</div>
</div>
					<a href="doctor_editprofile.php"><button type="button">Modifier</button></a>
				</form>
			</div>
		</div>

		<script src="index.js"></script>
	</body>

	</html>

<?php } elseif (isset($_SESSION["usertype"]) && $_SESSION["usertype"] == 'patient') {
	header("Location: patient_index.php");
	exit();
} else {
	header("Location: index.php");
	exit();
} ?>