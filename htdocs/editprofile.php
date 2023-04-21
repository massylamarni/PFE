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
<div class="std_container">
	<div class="ep_container">
		<h3>Edit profile</h3>
		<form class="ep_form">
			<div class="ep_form_field">
				<label>Profile image</label>
				<div class="ep_form_image"><img src="assets/pfp6.png"></div>
			</div>
			<div class="ep_form_field">
				<label>Full name</label>
				<input class="in_text" type="text">
			</div>
			<div class="ep_form_field">
				<label>Email</label>
				<input class="in_text" type="text">
			</div>
			<div class="ep_form_field">
				<label>Password</label>
				<input class="in_text" type="text">
			</div>
			<div class="ep_form_field">
				<label>Phone number</label>
				<input class="in_text" type="text">
			</div>
			<div class="ep_form_field">
				<label>Birthdate</label>
				<input class="in_text" type="date" >
			</div>
			<div class="ep_form_field">
				<label>Gender</label>
				<div class="in_radio">
					<div>
						<input type="radio" id="r_male" name="gender" value="male">
						<label for="r_male">Male</label>
					</div>
					<div>
						<input type="radio" id="r_female" name="gender" value="female">
						<label for="r_female">Female</label>
					</div>
					<div>
						<input type="radio" id="r_other" name="gender" value="other">
						<label for="r_other">Other</label>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

</body>
</html>