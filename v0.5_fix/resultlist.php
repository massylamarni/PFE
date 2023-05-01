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
	<div class="main">
		<div class="list">
			<div class="list_title"><h3>Resultats de recherche</h3></div>
			<div class="list_map"></div>
			<div class="resultlist_null">Aucun resultat trouvé</div>
		</div>
		<?php include("components/bookform.php"); ?>
	</div>
	<div class="secondary">
		<?php include("components/PS_profile.php"); ?>
	</div>
</div>

<script src="index.js"></script>
</body>
</html>