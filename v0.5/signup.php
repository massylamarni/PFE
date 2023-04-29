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

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define("DB_NAME","Client");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$name=$_POST["name"];
	$email=$_POST['email'];
	$password=$_POST['password'];
	$phone=$_POST["phone"];
	$bday=date("d-m-y");
	$gender="M";
	$pf_img="assets/pfp2.png";
	$location="75017 Colorado, USA";

	if ($name && $password && $email && $phone){
        
		$conn = mysqli_connect('localhost', 'root', '', DB_NAME);

		if($conn->connect_error){
			echo "$conn->connect_error";
			die("Connection Failed : ". $conn->connect_error);
		} else {
			$stmt = $conn->prepare("insert into patient (name, email, password, phone, bday, gender, pf_img, location) values( ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("ssssssss", $name, $email, $password, $phone, $bday, $gender, $pf_img, $location);
			$stmt->execute();
		

			$stmt->close();
			$conn->close();
		}
		
	header("Location:login.php");
    exit();
	}
	}

?>

<div class="std_container">
	<div class="auth">
		<a href="#" class="auth_api">
			<img src="assets/gmail_logo.svg">
			Sign up with Gmail
		</a>
		<a href="#" class="auth_api">
			<img src="assets/outlook_logo.svg">
			Sign up with Outlook
		</a>
		<form id="auth_form" action="" method="POST">
			<div class="auth_form_field">
				<label>Nom complet</label>
				<input type="text" name="name"/>
			</div>
			<div class="auth_form_field">
				<label>Email</label>
				<input type="text"name="email">
			</div>
			<div class="auth_form_field">
				<label>Mot passe</label>
				<input type="password"name="password">
			</div>
			<div class="auth_form_field">
				<label>Numero telephone</label>
				<input type="text"name="phone">
			</div>
			<div class="auth_form_captcha"></div>
			<input class="auth_form_submit" type="submit" value="Sign up">
			<div class="auth_form_tos">By clicking “Sign up”, you agree to our <a href="#">terms of service</a>, <a href="#">privacy policy</a> and <a href="#">cookie policy</a></div>
		</form>
		<div class="auth_ask">Already have an account? <a href="login.php">Log in</a></div>
	</div>
</div>

<script src="index.js"></script>
</body>
</html>