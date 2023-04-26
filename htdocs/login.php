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
$stmt = $conn->prepare("SELECT * FROM patient WHERE email = ? AND password = ?");
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    // User is found in the users table
    $row = $result->fetch_assoc();
    $name= $row["name"];
	$bday=$row["bday"];
	$phone=$row["phone"];
	$gender=$row["gender"];

	session_name(patient_session);
	session_start();
	$_SESSION["email"]=$email;
	$_SESSION["name"]=$name;
	$_SESSION["bday"]=$bday;
	$_SESSION["phone"]=$phone;
	$_SESSION["gender"]=$gender;

	header('Location : index.php');
    $stmt->close();
    $conn->close();
    exit();

} else {

    // User is not found in the patient table

    $stmt = $conn->prepare("SELECT * FROM doctor WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User is found in the doctor table

    $row = $result->fetch_assoc();
    $name= $row["name"];
	$bday=$row["bday"];
	$phone=$row["phone"];
	$gender=$row["gender"];
	$speciality=$row["speciality"];
    $location=$row["location"];

	session_name(doctor_session);
	session_start();
	$_SESSION["email"]=$email;
	$_SESSION["name"]=$name;
	$_SESSION["bday"]=$bday;
	$_SESSION["phone"]=$phone;
	$_SESSION["gender"]=$gender;
	$_SESSION["speciality"]=$speciality;
	$_SESSION["location"]=$location;

	header('Location : index.php');
	$stmt->close();
    $conn->close();
	exit();

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
