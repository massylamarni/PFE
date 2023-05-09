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

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = mysqli_connect('localhost','root','','Client');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$email=$_POST['email'];
	$password=$_POST['password'];

  if ($email && $password ){

	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : " .$conn->connect_error);

	} else {

// Check if user exists in the patient table
$stmt = $conn->prepare("SELECT * FROM patient WHERE patient_email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {

	$row = $result->fetch_assoc();
	if(password_verify($password,$row["patient_password"])) {

    // User is found 
	session_start();

	$_SESSION["patient_id"]=$row["patient_id"];
	$_SESSION["patient_email"]=$email;
	$_SESSION["patient_password"]=$row["patient_password"];
	$_SESSION["patient_name"]=$row["patient_name"];
	$_SESSION["patient_bday"]=$row["patient_bday"];
	$_SESSION["patient_phone"]=$row["patient_phone"];
	$_SESSION["patient_gender"]=$row["patient_gender"];
	if (isset($row["patient_location"])) $_SESSION["patient_location"] = $row["patient_location"];
	if (isset($row["patient_pf_img"])) $_SESSION["patient_pf_img"] = $row["patient_pf_img"];
	$_SESSION["usertype"]="patient";

	header('Location: index.php');
    $stmt->close();
    $conn->close();
    exit();
}
} else {

    // User is not found in the patient table

    $stmt = $conn->prepare("SELECT * FROM doctor WHERE doctor_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

		$row = $result->fetch_assoc();
		if(password_verify($password,$row["doctor_password"])) {


        // User is found in the doctor table
	    session_start();

	$_SESSION["doctor_id"]=$row["doctor_id"];
	$_SESSION["doctor_email"]=$email;
	$_SESSION["doctor_password"]=$row["doctor_password"];
	$_SESSION["doctor_name"]=$row["doctor_name"];
	$_SESSION["doctor_bday"]=$row["doctor_bday"];
	$_SESSION["doctor_phone"]=$row["doctor_phone"];
	$_SESSION["doctor_gender"]=$row["doctor_gender"];
	$_SESSION["speciality"]=$row["doctor_speciality"];
	if (isset($row["doctor_location"])) $_SESSION["doctor_location"] = $row["doctor_location"];
	if (isset($row["doctor_pf_img"])) $_SESSION["doctor_pf_img"] = $row["doctor_pf_img"];
	if (isset($row["description"])) $_SESSION["description"] = $row["description"];
	if (isset($row["worktime"])) $_SESSION["worktime"] = $row["worktime"];
	if (isset($row["pricing"])) $_SESSION["pricing"] = $row["pricing"];
	if (isset($row["dq"])) $_SESSION["dq"] = $row["dq"];
	if (isset($row["language"])) $_SESSION["language"] = $row["language"];
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
