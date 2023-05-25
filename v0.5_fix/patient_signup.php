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
<!--save-->

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define("DB_NAME","Client");
if(!isset($_SESSION)){session_start();}

if(isset($_SESSION["usertype"]) && $_SESSION["usertype"]=='doctor'){

	header("Location: doctor_index.php");
	exit();
	
	}elseif(isset($_SESSION["usertype"]) && $_SESSION["usertype"]=='patient'){
	
	  header("Location: patient_index.php");
	  exit();
	}  

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$name=$_POST["name"];
	$email=$_POST['email'];
	$password=$_POST['password'];
	$phone=$_POST["phone"];
	$bday=$_POST["bday"];
	@$gender=$_POST["gender"];
	$pf_img = "assets/pfp2.png";

	include("components/recaptcha.php");

	if ($name && $password && $email && $bday && $phone && $gender && $pf_img){
        
		$conn = mysqli_connect('localhost', 'root', '', DB_NAME);

		if($conn->connect_error){
			echo "$conn->connect_error";
			die("Connection Failed : ". $conn->connect_error);
		} else {
			$stmt = $conn->prepare("SELECT patient_email FROM patient WHERE patient_email = ? UNION SELECT doctor_email FROM doctor WHERE doctor_email = ?");
			$stmt->bind_param("ss", $email , $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0 ) {
				$error_message = "Email already exists";
			}else{
			$password_hashed = password_hash($password, PASSWORD_DEFAULT);
			$stmt = $conn->prepare("insert into patient (patient_name, patient_email, patient_password, patient_phone,  patient_bday,  patient_gender, patient_pf_img) values(?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("sssssss", $name, $email, $password_hashed, $phone, $bday, $gender);
			$stmt->execute();
		
			$stmt->close();
			$conn->close();
			header("Location: login.php");
			exit();
		  }
		}
		$stmt->close();
		$conn->close();

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
				<label>Nom complet</label>
				<input type="text" name="name" required="">
			</div>
			<div class="auth_form_field">
				<label>Email</label>
				<input type="email" name="email" required="">
			</div>
			<div class="auth_form_field">
				<label>Mot passe</label>
				<input type="password" name="password" required="">
			</div>
			<div class="auth_form_field">
				<label>Numero telephone</label>
				<input type="tel" pattern="([0-9]{9})|([0-9]{10})" name="phone" required="">
			</div>
			<div class="auth_form_field">
				<label>Date de naissance</label>
				<input class="in_text" type="date" name="bday" required="">
			</div>
			<div class="in_radio">
					<div>
						<input type="radio" id="r_male" name="gender" value="M" required="">
						<label for="r_male">Male</label>
					</div>
					<div>
						<input type="radio" id="r_female" name="gender" value="F" required="">
						<label for="r_female">Female</label>
					</div>
				</div>
			<div class="auth_form_captcha">
				<div class="g-recaptcha" data-sitekey="6Leb4AwmAAAAAGtDIsFtXS_3acjas4bivZ2TSxky"></div>
			</div>
			<input class="auth_form_submit" type="submit" value="S'inscrire">
			<div class="auth_form_tos">By clicking “Sign up”, you agree to our <a href="#">terms of service</a>, <a href="#">privacy policy</a> and <a href="#">cookie policy</a></div>
		</form>
		<div class="auth_ask">Vous avez deja un compte ? <a href="login.php">Se connecter</a></div>
		<div class="auth_ask">Vous etes un medecin ? <a href="doctor_signup.php">S'inscrire</a></div>
	</div>
</div>

</body>
<script src="index.js"></script>
</html>
