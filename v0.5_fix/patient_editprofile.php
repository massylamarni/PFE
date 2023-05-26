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
//hellow
define("DB_NAME","Client");

if(!isset($_SESSION))
{
session_start();
}
if(isset($_SESSION["usertype"]) && $_SESSION["usertype"]=='patient') {

	$conn = mysqli_connect('localhost', 'root', '', DB_NAME);

	if($conn->connect_error){
		echo "$conn->connect_error";
     die("Connection Failed : ". $conn->connect_error);
	 } 

      
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        $new_name=$_POST["name"];
        $new_email=$_POST['email'];
        $confirm_password=$_POST['old_password'];
        $new_password=$_POST['new_password'];
        $new_phone=$_POST["phone"];
        $new_bday=$_POST["bday"];
        $new_location=$_POST["location"];
         
        if ($new_email){
          $stmt = $conn->prepare("SELECT patient_email FROM patient WHERE patient_email = ? UNION SELECT doctor_email FROM doctor WHERE doctor_email = ?");
          $stmt->bind_param("ss", $new_email , $new_email);
          $stmt->execute();
          $result = $stmt->get_result();
          if ( $new_email != $_SESSION["email"]  &&  $result->num_rows > 0) {
            echo "email already exists";

        }else{
          $stmt = $conn->prepare("UPDATE patient SET  patient_email = ? WHERE patient_id = ?");
          $stmt->bind_param("si", $new_email, $_SESSION["id"]);
          $stmt->execute(); 
          $_SESSION["email"]= $new_email;
        }       
			}
         if( $new_name  && $new_name!=$_SESSION["name"] ){
          $stmt = $conn->prepare("UPDATE patient SET patient_name = ? WHERE patient_id = ?");
          $stmt->bind_param("si", $new_name, $_SESSION["id"]);
          $stmt->execute();
          $_SESSION["name"]=$new_name;
         }

         if($new_phone && $new_phone!=$_SESSION["phone"] ){
          $stmt = $conn->prepare("UPDATE patient SET patient_phone = ? WHERE patient_id = ?");
          $stmt->bind_param("si", $new_phone, $_SESSION["id"]);
          $stmt->execute();
          $_SESSION["phone"]=$new_phone;
         }
          if($new_bday  && $new_bday!=$_SESSION["bday"] ){
          $stmt = $conn->prepare("UPDATE patient SET patient_bday = ? WHERE patient_id = ?");
          $stmt->bind_param("si", $new_bday, $_SESSION["id"]);
          $stmt->execute();
          $_SESSION["bday"]=$new_bday;
         }
         if($new_location && $new_location!=$old_location ){
          $stmt = $conn->prepare("UPDATE patient SET patient_location = ? WHERE patient_id = ?");
          $stmt->bind_param("si", $new_location, $_SESSION["id"]);
          $stmt->execute();
          $_SESSION["location"]=$new_location;
         }
         if ($new_password && $confirm_password && !password_verify($new_password ,$_SESSION["password"])) {
             if(password_verify($confirm_password,$_SESSION["password"])) {
                $password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE patient SET patient_password = ? WHERE patient_id = ?");
                $stmt->bind_param("si",$password_hashed , $_SESSION["id"]);
                $stmt->execute();
                $_SESSION["password"]=$password_hashed;
        }   
      }

      if (!empty($_FILES["picture"]["name"])) {
        $currentPicturePath = $_SESSION["pf_img"];
      
        if ($currentPicturePath != "assets/pfp2.png") {
          if (file_exists($currentPicturePath)) {
            unlink($currentPicturePath);
          }
        }
      
        $uploadedFileName = $_FILES["picture"]["name"];
        $fileExtension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
        $newFileName = "pf_img_".$_SESSION["id"]."." . $fileExtension;
      
        $uploadDirectory = "assets/patient_pf_img/";
        $targetFile = $uploadDirectory . basename($newFileName);
      
        if (move_uploaded_file($_FILES["picture"]["tmp_name"], $targetFile)) {
          $newPicturePath = $uploadDirectory . $newFileName;
          $stmt = $conn->prepare("UPDATE patient SET patient_pf_img = ? WHERE patient_id = ?");
          $stmt->bind_param("si", $newPicturePath, $_SESSION["id"]);
          $stmt->execute();
          $_SESSION["pf_img"] = $newPicturePath;
        }
      }

         header("Location: patient_profile.php");
         exit();              
}

 
   ?>




<div class="std_containerI">
	<div class="ep_container">		
<h3>Gerer Compte</h3>
<form class="ep_form" method="POST" enctype="multipart/form-data">
<div class="pf" id="<?php echo $_SESSION["id"] ?>">
	<div class="pf_header">
		<img id="preview" src="<?php echo $_SESSION["pf_img"] ?>"/>
		<div class="pf_header_text">
    <div class="pf_body_field"><h3>Nom</h3><input type="text" value="<?php echo $_SESSION["name"] ?>" name="name" autocomplete="off"/></div>
		<div>
			<p>modifie la photo de profile</p>
			<input type="file" id="profile_picture" name="picture" onchange="previewImage(event)" accept="image/*">

	  </div>
  </div>
	</div>
	<div class="pf_body">
  <div class="pf_body_field"><h3>Email</h3><input class="in_text" type="text"value="<?php echo $_SESSION["email"] ?>" name="email" autocomplete="off"/></div>
		<div class="pf_body_field"><h3>Date Naissance</h3><input type="date" name="bday" value="<?php echo $_SESSION["bday"] ?>"></div>
	</div>
	<div>
  <div class="pf_body_field"><h3>Numero telephone</h3><input type="text" value="<?php echo $_SESSION["phone"] ?>" name="phone"  autocomplete="off"/></div>
  <div class="pf_body_field"><h3>Location</h3><input type="text" value="<?php if (isset($_SESSION["location"])){ echo $_SESSION["location"]; } ?>" name="location" autocomplete="off" /></div>
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

<?php   }elseif(isset($_SESSION["usertype"]) && $_SESSION["usertype"]=='doctor'){

header("Location: doctor_index.php");
exit();

}else{

  header("Location: index.php");
  exit();
}  ?>