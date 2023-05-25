<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="index.css">
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<title>Visuals</title>
</head>
<body>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!isset($_SESSION)){session_start();}

if(isset($_SESSION["usertype"]) && $_SESSION["usertype"]=='doctor'){

	header("Location: doctor_index.php");
	exit();
	
	}elseif(isset($_SESSION["usertype"]) && $_SESSION["usertype"]=='patient'){
	
	  header("Location: patient_index.php");
	  exit();
	}  

$conn = mysqli_connect('localhost','root','','Client');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$email=$_POST['email'];
	$password=$_POST['password'];

	include("components/recaptcha.php");

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

	$_SESSION["id"]=$row["patient_id"];
	$_SESSION["email"]=$email;
	$_SESSION["password"]=$row["patient_password"];
	$_SESSION["name"]=$row["patient_name"];
	$_SESSION["bday"]=$row["patient_bday"];
	$_SESSION["phone"]=$row["patient_phone"];
	$_SESSION["gender"]=$row["patient_gender"];
	if (isset($row["patient_location"])) $_SESSION["location"] = $row["patient_location"];
	if (isset($row["patient_pf_img"])) $_SESSION["pf_img"] = $row["patient_pf_img"];
	$_SESSION["usertype"]="patient";

	header('Location: patient_index.php');
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

	$_SESSION["id"]=$row["doctor_id"];
	$_SESSION["email"]=$email;
	$_SESSION["password"]=$row["doctor_password"];
	$_SESSION["name"]=$row["doctor_name"];
	$_SESSION["bday"]=$row["doctor_bday"];
	$_SESSION["phone"]=$row["doctor_phone"];
	$_SESSION["gender"]=$row["doctor_gender"];
	$_SESSION["speciality"]=$row["speciality"];
	if (isset($row["doctor_location"])) $_SESSION["location"] = $row["doctor_location"];
	if (isset($row["doctor_pf_img"])) $_SESSION["pf_img"] = $row["doctor_pf_img"];
	if (isset($row["description"])) $_SESSION["description"] = $row["description"];
	if (isset($row["worktime"])) $_SESSION["worktime"] = $row["worktime"];
	if (isset($row["pricing"])) $_SESSION["pricing"] = $row["pricing"];
	if (isset($row["dq"])) $_SESSION["dq"] = $row["dq"];
	if (isset($row["language"])) $_SESSION["language"] = $row["language"];
	$_SESSION["usertype"]="doctor";

	header('Location: doctor_index.php');
	$stmt->close();
    $conn->close();
	exit();
}
} else {
        // User is not found in either table
        $error_message = "Invalid email or password";
	
    }
}
$stmt->close();
$conn->close();
}
}
}
?>


<div class="simple_container">
	<div class="auth">
		<form id="auth_form" onsubmit="return verifyRecaptcha();" action="" method="POST">
			<a href="patient_index.php" class="auth_logo"><img src="assets/logo.svg"></a>
			<?php if (!empty($error_message)): ?>
				<div class="auth_error_message"><?php echo $error_message; ?></div>
			<?php endif; ?>
			<div class="auth_form_field">
				<label>Email</label>
				<input type="email" name="email" required=""/>
			</div>
			<div class="auth_form_field">
				<label>Mot passe</label>
				<input type="password" name="password" required=""/>
			</div>
			<div class="auth_form_captcha">
				<div class="g-recaptcha" data-sitekey="6Leb4AwmAAAAAGtDIsFtXS_3acjas4bivZ2TSxky"></div>
				<div id="recaptcha_error_message"></div>

			</div>
			<input class="auth_form_submit" type="submit" value="Se connecter">
		</form>
		<div class="auth_ask">Vous n'avez pas de compte ? <a href="patient_signup.php">S'inscrire</a></div>
	</div>
</div>

</body>
<script src="index.js"></script>
</html>