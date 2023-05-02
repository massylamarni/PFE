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

define("DB_NAME","Client");

if(!isset($_SESSION))
{
session_start();
}
if(isset($_SESSION["usertype"])) {

	$conn = mysqli_connect('localhost', 'root', '', DB_NAME);

	if($conn->connect_error){
		echo "$conn->connect_error";
     die("Connection Failed : ". $conn->connect_error);
	 }else { 

      $old_email= $_SESSION["email"];
	    $old_name=$_SESSION["name"];
      $old_password=$_SESSION["password"];
	    $old_bday=$_SESSION["bday"];
      $old_phone=$_SESSION["phone"];
      @$old_location=$_SESSION["location"];
		  $old_pf_img = "assets/pfp2.png";

      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        $new_name=$_POST["name"];
        $new_email=$_POST['email'];
        $confirm_password=$_POST['old_password'];
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $new_phone=$_POST["phone"];
        $new_bday=$_POST["bday"];
        $new_location=$_POST["location"];
         
        if ($new_email){
          $stmt = $conn->prepare("SELECT email FROM patient WHERE email = ? UNION SELECT email FROM doctor WHERE email = ?");
          $stmt->bind_param("ss", $new_email , $new_email);
          $stmt->execute();
          $result = $stmt->get_result();
          if ( $new_email != $old_email  &&  $result->num_rows > 0) {
            echo "email already exists";

        }else{
          $stmt = $conn->prepare("UPDATE patient SET  email = ? WHERE id = ?");
          $stmt->bind_param("si", $new_email, $_SESSION["id"]);
          $stmt->execute(); 
          $_SESSION["email"]= $new_email;
        }       
			}
         if( $new_name  && $new_name!=$old_name ){
          $stmt = $conn->prepare("UPDATE patient SET name = ? WHERE id = ?");
          $stmt->bind_param("si", $new_name, $_SESSION["id"]);
          $stmt->execute();
          $_SESSION["name"]=$new_name;
         }

         if($new_phone && $new_phone!=$old_phone ){
          $stmt = $conn->prepare("UPDATE patient SET phone = ? WHERE id = ?");
          $stmt->bind_param("si", $new_phone, $_SESSION["id"]);
          $stmt->execute();
          $_SESSION["phone"]=$new_phone;
         }
          if($new_bday  && $new_bday!=$old_bday ){
          $stmt = $conn->prepare("UPDATE patient SET bday = ? WHERE id = ?");
          $stmt->bind_param("si", $new_bday, $_SESSION["id"]);
          $stmt->execute();
          $_SESSION["bday"]=$new_bday;
         }
         if($new_location && $new_location!=$old_location ){
          $stmt = $conn->prepare("UPDATE patient SET location = ? WHERE id = ?");
          $stmt->bind_param("si", $new_location, $_SESSION["id"]);
          $stmt->execute();
          $_SESSION["location"]=$new_location;
         }
         if ($new_password && $confirm_password){
             if(password_verify($confirm_password,$old_password)) {
                $stmt = $conn->prepare("UPDATE patient SET password = ? WHERE id = ?");
                $stmt->bind_param("si",$new_password , $_SESSION["id"]);
                $stmt->execute();
                $_SESSION["password"]=$new_password;
        } 
      
      }
         //header("Location: components/profile.php");
         //exit(); 
         
         
         header("Location: index.php");
         exit();
        }   
      
}

 
   ?>




<div class="std_container">
	<div class="ep_container">		
<h3>Gerer Compte</h3>
<form class="ep_form" method="POST">
<div class="pf" id="<?php echo $_SESSION["id"] ?>">
	<div class="pf_header">
		<img src="<?php echo $old_pf_img ?>"/>
		<div class="pf_header_text">
    <div class="pf_body_field"><h3>Nom</h3><input type="text" placeholder="<?php echo $old_name ?>" name="name" autocomplete="off"/></div>
		</div>
	</div>
	<div class="pf_body">
  <div class="pf_body_field"><h3>Email</h3><input class="in_text" type="text"placeholder="<?php echo $old_email ?>" name="email" autocomplete="off"/></div>
		<div class="pf_body_field"><h3>Date Naissance</h3><input type="date" name="bday"></div>
	</div>
	<div>
  <div class="pf_body_field"><h3>Numero telephone</h3><input type="text" placeholder="<?php echo $old_phone ?>" name="phone"  autocomplete="off"/></div>
  <div class="pf_body_field"><h3>Location</h3><input type="text" placeholder="<?php  @$old_location ?>" name="location" autocomplete="off" /></div>
		<div class="pf_body_field"><h3>Password</h3><input class="in_text" type="password" placeholder="enter old password" name="old_password" autocomplete="off">
    <input class="in_text" type="password" placeholder="enter new password" name="new_password" autocomplete="off" ></div>
	</div>
</div>
<input type="submit" value="modifier">
</form>
</div>
</div>

<script src="index.js"></script>
</body>
</html> 

<?php   }else{

  header("Location: index.php");
  exit();
}  ?>