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


if(!isset($_SESSION))
{
session_start();
}
if(isset($_SESSION["usertype"]) && $_SESSION["usertype"]=='patient') {   ?>




<div class="simple_container">
	<div class="ep_container">		
<h3>Mon profile</h3>
<form class="ep_form" method="POST">
<div class="pf" id="<?php echo $_SESSION["id"] ?>">
	<div class="pf_header">
		<img src="<?php echo $_SESSION["pf_img"] ?>"/>
		<div class="pf_header_text">
    <div class="pf_body_field"><h3>Nom</h3><label><?php echo $_SESSION["name"] ?></label> </div>
		</div>
	</div>
	<div class="pf_body">
  <div class="pf_body_field"><h3>Email</h3><label><?php echo $_SESSION["email"] ?></label></div>
		<div class="pf_body_field"><h3>Date Naissance</h3><label><?php echo $_SESSION["bday"] ?></label></label></div>
	</div>
	<div>
  <div class="pf_body_field"><h3>Numero telephone</h3><label><?php echo $_SESSION["phone"] ?></label></div>
  <div class="pf_body_field"><h3>Location</h3><label><?php if (isset($_SESSION["location"])){ echo $_SESSION["location"]; } ?></label></div>
		
</div>
<a href="patient_editprofile.php"><button type="button">Modifier</button></a>
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