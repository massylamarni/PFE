<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="login.css">
	<title>Visuals</title>
</head>
<body>


<div class="std_container">

<div class="auth">
	<a href="#" class="auth_api">
		<img src="gmail_logo.svg">
		Log in with Gmail
	</a>
	<a href="#" class="auth_api">
		<img src="outlook_logo.svg">
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
	<div class="auth_ask">Don't have an account? <a href="#">Sign up</a></div>
</div>

</div>


</body>
</html>