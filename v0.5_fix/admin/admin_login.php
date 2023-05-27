<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../index.css">
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<title>Admin login</title>
</head>
<body>



<?php  
if(isset($_SESSION["usertype"])){

header("Location: ../index.php");
exit();

}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$username=$_POST['username'];
	$password=$_POST['password'];

	include("../components/recaptcha.php");

  if ($username && $password ){

	$conn = mysqli_connect('localhost','root','','Admin');

if($conn->connect_error){
    echo "$conn->connect_error";
    die("Connection Failed : " .$conn->connect_error);  } 

// Check if admin exists in the admin table
$stmt = $conn->prepare("SELECT * FROM admin WHERE admin_username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {

	$row = $result->fetch_assoc();
	if(password_verify($password,$row["admin_password"])) {

    // User is found 
	session_start();

	$_SESSION["id"]=$row["admin_id"];
	$_SESSION["usertype"]="admin";

	header('Location: admin_dashboard.php');
    $stmt->close();
    $conn->close();
    exit(); 
}else{   $error_message="Invalid Password" ; }

}else{  
    $stmt = $conn->prepare("SELECT * FROM moderateur WHERE mod_username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
    
        $row = $result->fetch_assoc();
        if(password_verify($password,$row["mod_password"])) {
    
        // User is found 
        session_start();
    
        $_SESSION["id"]=$row["mod_id"];
        $_SESSION["usertype"]="moderateur";
    
        header('Location: mod_dashboard.php');
        $stmt->close();
        $conn->close();
        exit(); 
    }else{   $error_message="Invalid Password" ; }

        }else{
            $error_message="invalid username or password";
        }
    }
}
}

?>


<div class="simple_container">
	<div class="auth">
		<form id="auth_form" onsubmit="return verifyRecaptcha();" action="" method="POST">
			<a href="../index.php" class="auth_logo"><img src="../assets/logo.svg"></a>
			<?php if (!empty($error_message)): ?>
				<div class="auth_error_message"><?php echo $error_message; ?></div>
			<?php endif; ?>
			<div class="auth_form_field">
				<label>Nom utilisateur</label>
				<input type="text" name="username" required=""/>
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
<script src="../index.js"></script>
</html>