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

if (!isset($_SESSION)) {
	session_start();
}
if (isset($_SESSION["usertype"]) && $_SESSION["usertype"] == 'patient') { 
if ((empty($_SESSION["location"])) || ($_SESSION["location"] == '[]')) $location = "Non definis...";
	
?>

	<div class="std_containerI">
		<div class="ep_container">
			<h3>Mon Profil</h3>
			<form class="ep_form" method="POST">
				<div class="pf" id="<?php echo $_SESSION["id"] ?>">
					<div class="pf_header">
						<img src="<?php echo $_SESSION["pf_img"] ?>" />
						<div class="pf_header_text">
							<div class="pf_body_field"><h3><?php echo $_SESSION["name"] ?></h3></div>
						</div>
					</div>
					<div class="pf_body">
						<div class="pf_body_field"><h3>Email</h3><p><?php echo $_SESSION["email"] ?></p></div>
						<div class="pf_body_field"><h3>Date Naissance</h3><p><?php echo $_SESSION["bday"] ?></p></div>
						<div class="pf_body_field"><h3>Numero telephone</h3><p><?php echo $_SESSION["phone"] ?></p></div>
						<div class="pf_body_field"><h3>Adresse</h3><p><?php echo $location ?></p></div>
					</div>
					<a href="patient_editprofile.php"><button type="button">Modifier</button></a>
			</form>
		</div>
	</div>
	<script src="index.js"></script>
</body>

</html>

<?php } elseif (isset($_SESSION["usertype"]) && $_SESSION["usertype"] == 'doctor') {
	header("Location: doctor_index.php");
	exit();
} else {
	header("Location: index.php");
	exit();
} ?>