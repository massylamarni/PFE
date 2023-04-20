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
	<div class="auth">
		<a href="#" class="auth_api">
			<img src="assets/gmail_logo.svg">
			Log in with Gmail
		</a>
		<a href="#" class="auth_api">
			<img src="assets/outlook_logo.svg">
			Log in with Outlook
		</a>
		<form id="auth_form">
			<div class="auth_form_field">
				<label>Email</label>
				<input type="text">
			</div>
			<div class="auth_form_field">
				<label>Mot passe</label>
				<input type="text">
			</div>
			<div class="auth_form_captcha"></div>
			<input class="auth_form_submit" type="submit" value="Log in">
		</form>
		<div class="auth_ask">Don't have an account? <a href="signup.php">Sign up</a></div>
	</div>
</div>

</body>
</html>