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
<?php include("components/navbar.php"); ?>
<div class="std_containerI">
	<div class="main">
		<div class="list">
			<div class="list_title"><h3>Rendez-vous en cours</h3></div>
			<div class="apptlist_null">Pas de rendez-vous en cours !</div>
		</div>
		<div class="history">
			<div class="list_title"><h3>Historique des Rendez-vouss</h3></div>
			<div class="appthistory_null">Vous n'avez pris aucun rendez-vous</div>
		</div>
	</div>
	<div class="secondary">
		<?php include("components/PS_profile.php"); ?>
	</div>
</div>

<script src="index.js"></script>
<script type="text/javascript">
	updateapptlist(0);
	updateappthistory(0);
	setTimeout(() => {
		showprofile();
	}, 1000);
</script>
</body>
</html>