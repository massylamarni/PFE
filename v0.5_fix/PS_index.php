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

<?php include("components/navbar.php"); ?>
<div class="std_containerI">
	<div class="list">
		<div class="list_title"><h3>Rendez-vous en cours</h3></div>
		<?php include("components/PS_apptlist.php"); ?>
		<?php include("components/PS_apptlist_blank.php"); ?>
	</div>
</div>

<script src="index.js"></script>
</body>
</html>
