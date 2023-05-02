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
<!--save-->

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define("DB_NAME","Client");


if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$name=$_POST["name"];
	$email=$_POST['email'];
	$password=$_POST['password'];
	$phone=$_POST["phone"];
	$bday=$_POST["bday"];
	@$gender=$_POST["gender"];

	if ($name && $password && $email && $bday && $phone && $gender ){
        
		$conn = mysqli_connect('localhost', 'root', '', DB_NAME);

		if($conn->connect_error){
			echo "$conn->connect_error";
			die("Connection Failed : ". $conn->connect_error);
		} else {
			$stmt = $conn->prepare("SELECT email FROM patient WHERE email = ? UNION SELECT email FROM doctor WHERE email = ?");
			$stmt->bind_param("ss", $email , $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0 ) {
				echo "email already exists";
			}else{
			$password_hashed = password_hash($password, PASSWORD_DEFAULT);
			$stmt = $conn->prepare("insert into patient (name, email, password, phone,  bday,  gender) values(?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("ssssss", $name, $email, $password_hashed, $phone, $bday, $gender);
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

/* etapes a faire : 

  ajout des APIs 
*/

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
				<input type="text" name="name">
			</div>
			<div class="auth_form_field">
				<label>Email</label>
				<input type="text" name="email">
			</div>
			<div class="auth_form_field">
				<label>Mot passe</label>
				<input type="password" name="password">
			</div>
			<div class="auth_form_field">
				<label>Numero telephone</label>
				<input type="text" name="phone">
			</div>
			<div class="auth_form_field">
				<label>Birthdate</label>
				<input class="in_text" type="date" name="bday" >
			</div>
			<div class="in_radio">
					<div>
						<input type="radio" id="r_male" name="gender" value="M">
						<label for="r_male">Male</label>
					</div>
					<div>
						<input type="radio" id="r_female" name="gender" value="F">
						<label for="r_female">Female</label>
					</div>
				</div>
			<div class="auth_form_captcha"></div>
			<input class="auth_form_submit" type="submit" value="Sign up">
			<div class="auth_form_tos">By clicking “Sign up”, you agree to our <a href="#">terms of service</a>, <a href="#">privacy policy</a> and <a href="#">cookie policy</a></div>
		</form>
		<div class="auth_ask">Already have an account? <a href="login.php">Log in</a></div>
	</div>
</div>




<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$name=$_POST['name'];
	$email=$_POST['email'];
	$password=$_POST['password'];
	$phone=$_POST['phone'];
	$bday=date("d-m-y");
	$gender="M";
	$gender = "M";
	$pf_img = "assets/pfp2.png";
	$location = "75017 Colorado, USA";
	$v_speciality = array("Cardiologue", "Dermatologue");
	$speciality = json_encode($v_speciality);
	$description = "Spécialisé dans le traitement des maladies de la peau, des ongles et des cheveux,\nnotamment les éruptions cutanées, les infections de la peau, l'acné, les taches de\nvieillesse, les cancers de la peau, les allergies cutanées et les affections auto-immunes.";
	$v_worktime = array(array("09h30", "19h30"), array("09h30", "19h30"), array("09h30", "19h30"), array("09h30", "19h30"), array("09h30", "19h30"), array("", ""), array("09h30", "19h30"));
	$worktime = json_encode($v_worktime);
	$v_pricing = array(array("Consultation simple", "100 £"), array("Consultation avec acte", "200 £"));
	$pricing = json_encode($v_pricing);
	$v_dq = array(array("1977", "Diplôme d'État de docteur en médecine - Université Paris 11 - Paris-Saclay"), array("1977", "D.E.S. Dermatologie et vénéréologie - UFR de médecine Lariboisière-Saint-Louis"));
	$dq = json_encode($v_dq);
	$v_language = array("Anglais", "Francais", "Espagnol");
	$language = json_encode($v_language);

	if ($name && $password && $email && $phone){
        
		$conn = mysqli_connect('localhost', 'root', '', DB_NAME);

		if($conn->connect_error){
			echo "$conn->connect_error";
			die("Connection Failed : ". $conn->connect_error);
		} else {
			$stmt = $conn->prepare("insert into doctor (name, email, password, phone, bday, gender, pf_img, location, speciality, description, worktime, pricing, dq, language) values( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("ssssssssssssss", $name, $email, $password, $phone, $bday, $gender, $pf_img, $location, $speciality, $description, $worktime, $pricing, $dq, $language);
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
			<div class="auth_form_field">
				<label>Specialite</label>
				<input type="text"name="speciality">
			</div>

			<div class="auth_form_captcha"></div>
			<input class="auth_form_submit" type="submit" value="Sign up">
			<div class="auth_form_tos">By clicking “Sign up”, you agree to our <a href="#">terms of service</a>, <a href="#">privacy policy</a> and <a href="#">cookie policy</a></div>
		</form>
		<div class="auth_ask">Already have an account? <a href="login.php">Log in</a></div>
	</div>
</div>

</body>
</html>