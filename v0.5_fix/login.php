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

<?php //include("components/navbar.php");

define('DB_NAME','Client');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$email=$_POST['email'];
	$password=$_POST['password'];

  if ($email && $password ){

	$conn = mysqli_connect('localhost','root','',DB_NAME);
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : " .$conn->connect_error);

	} else {

// Check if user exists in the patient table
$stmt = $conn->prepare("SELECT * FROM patient WHERE email = ? ");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {

	$row = $result->fetch_assoc();
	if(password_verify($password,$row["password"])) {

    // User is found 
	session_start();

	$_SESSION["id"]=$row["id"];
	$_SESSION["email"]=$email;
	$_SESSION["password"]=$row["password"];
	$_SESSION["name"]=$row["name"];
	$_SESSION["bday"]=$row["bday"];
	$_SESSION["phone"]=$row["phone"];
	$_SESSION["gender"]=$row["gender"];
	$_SESSION["usertype"]="patient";

	header('Location: index.php');
    $stmt->close();
    $conn->close();
    exit();
}
} else {

    // User is not found in the patient table

    $stmt = $conn->prepare("SELECT * FROM doctor WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

		$row = $result->fetch_assoc();
		if(password_verify($password,$row["password"])) {


        // User is found in the doctor table
	    session_start();

	$_SESSION["id"]=$row["id"];
	$_SESSION["email"]=$email;
	$_SESSION["password"]=$row["password"];
	$_SESSION["name"]=$row["name"];
	$_SESSION["bday"]=$row["bday"];
	$_SESSION["phone"]=$row["phone"];
	$_SESSION["gender"]=$row["gender"];
	$_SESSION["speciality"]=$row["speciality"];
	$_SESSION["location"]=$row["location"];
	$_SESSION["usertype"]="doctor";


	header('Location: PS_index.php');
	$stmt->close();
    $conn->close();
	exit();
}
} else {
        // User is not found in either table
        echo "Invalid email or password";
	
    }
}
$stmt->close();
$conn->close();
}
}
}

	 ?>


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
		<form id="auth_form" action="" method="POST">
			<div class="auth_form_field">
				<label>Email</label>
				<input type="text" name="email"/>
			</div>
			<div class="auth_form_field">
				<label>Mot passe</label>
				<input type="password" name="password"/>
			</div>
			<div class="auth_form_captcha"></div>
			<input class="auth_form_submit" type="submit" value="Log in">
		</form>
		<div class="auth_ask">Don't have an account? <a href="signup.php">Sign up</a></div>
	</div>
</div>

</body>
</html>
