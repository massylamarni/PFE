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

include("components/navbar.php"); 

define("DB_NAME","Client");


if(!isset($_SESSION))
{
session_start();
}
if(isset($_SESSION["usertype"]) && $_SESSION["usertype"]=='doctor') {



$conn = mysqli_connect('localhost', 'root', '', DB_NAME);

	    if($conn->connect_error){
		echo "$conn->connect_error";
       die("Connection Failed : ". $conn->connect_error); }


	   $stmt = $conn->prepare("SELECT * FROM doctor WHERE doctor_id = ?");
	   $stmt->bind_param("s", $_SESSION["id"]);
	   $stmt->execute();
	   $result = $stmt->get_result();
	   $row = $result->fetch_assoc();
	   $languages=$row["language"];
	   $languages=json_decode($languages);
	   $dqs=$row["dq"];
	   $dqs=json_decode($dqs);
	   $pricings=$row["pricing"];
	   $pricings=json_decode($pricings);
	   $worktimes=$row["worktime"];
	   $worktimes=json_decode($worktimes);	  

        if (!isset($worktimes)) { 
			$worktimes = array(
			array('', ''),array('', ''),array('', ''),
			array('', ''),array('', ''),array('', ''),array('', '')
			);
		}



	

//checking for session variables

	
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        $new_name=$_POST["name"];
        $new_email=$_POST['email'];
        $confirm_password=$_POST['old_password'];
        $new_password=$_POST['new_password'];
        $new_phone=$_POST["phone"];
        $new_bday=$_POST["bday"];
        $new_location=$_POST["location"];
		$new_speciality=$_POST["speciality"];
		$new_description=$_POST["description"];
		
//updating database		
		   if ($new_email){
			$stmt = $conn->prepare("SELECT patient_email FROM patient WHERE patient_email = ? UNION SELECT doctor_email FROM doctor WHERE doctor_email = ?");
			$stmt->bind_param("ss", $new_email , $new_email);
			$stmt->execute();
			$result = $stmt->get_result();
			if ( $new_email != $_SESSION["email"]  &&  $result->num_rows > 0) {
			  echo "email already exists";
  
		  }else{
			$stmt = $conn->prepare("UPDATE doctor SET  doctor_email = ? WHERE doctor_id = ?");
			$stmt->bind_param("si", $new_email, $_SESSION["id"]);
			$stmt->execute(); 
			$_SESSION["email"]= $new_email;
		  }       
			  }
		   if( $new_name  && $new_name!=$_SESSION["name"] ){
			$stmt = $conn->prepare("UPDATE doctor SET doctor_name = ? WHERE doctor_id = ?");
			$stmt->bind_param("si", $new_name, $_SESSION["id"]);
			$stmt->execute();
			$_SESSION["name"]=$new_name;
		   }
  
		   if($new_phone && $new_phone!=$_SESSION["phone"] ){
			$stmt = $conn->prepare("UPDATE doctor SET doctor_phone = ? WHERE doctor_id = ?");
			$stmt->bind_param("si", $new_phone, $_SESSION["id"]);
			$stmt->execute();
			$_SESSION["phone"]=$new_phone;
		   }
			if($new_bday  && $new_bday!=$_SESSION["bday"]){
			$stmt = $conn->prepare("UPDATE doctor SET doctor_bday = ? WHERE doctor_id = ?");
			$stmt->bind_param("si", $new_bday, $_SESSION["id"]);
			$stmt->execute();
			$_SESSION["bday"]=$new_bday;
		   }
		   if($new_location && $new_location!=$old_location ){
			$stmt = $conn->prepare("UPDATE doctor SET doctor_location = ? WHERE doctor_id = ?");
			$stmt->bind_param("si", $new_location, $_SESSION["id"]);
			$stmt->execute();
			$_SESSION["location"]=$new_location;
		   }
		   if($new_speciality && $new_speciality!=$_SESSION["speciality"] ){
			$stmt = $conn->prepare("UPDATE doctor SET speciality = ? WHERE doctor_id = ?");
			$stmt->bind_param("si", $new_speciality, $_SESSION["id"]);
			$stmt->execute();
			$_SESSION["speciality"]=$new_speciality;
		   }
		   if($new_description && $new_description!=$old_description ){
			$stmt = $conn->prepare("UPDATE doctor SET description = ? WHERE doctor_id = ?");
			$stmt->bind_param("si", $new_description, $_SESSION["id"]);
			$stmt->execute();
			$_SESSION["description"]=$new_description;
		   }
		   if ($new_password && $confirm_password && !password_verify($new_password ,$_SESSION["password"])) {
			   if(password_verify($confirm_password,$_SESSION["password"])) {
				  $password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
				  $stmt = $conn->prepare("UPDATE doctor SET doctor_password = ? WHERE doctor_id = ?");
				  $stmt->bind_param("si",$password_hashed , $_SESSION["id"]);
				  $stmt->execute();
				  $_SESSION["password"]=$password_hashed;
		  } 		
		}
		echo $_FILES["picture"]["name"];
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
		
			$uploadDirectory = "assets/doctor_pf_img/";
			$targetFile = $uploadDirectory . basename($newFileName);
		
			if (move_uploaded_file($_FILES["picture"]["tmp_name"], $targetFile)) {
				$newPicturePath = $uploadDirectory . $newFileName;
				$stmt = $conn->prepare("UPDATE doctor SET doctor_pf_img = ? WHERE doctor_id = ?");
				$stmt->bind_param("si", $newPicturePath, $_SESSION["id"]);
				$stmt->execute();
				$_SESSION["pf_img"] = $newPicturePath;
			}
		}
		



		$db_coord=$_POST["coord"];
		$db_languages = $_POST["languages"];
		$db_dq = $_POST["dq"];
		$db_pricing = $_POST["pricing"];
		$worktimes = array(
			array($_POST['Dimmatin'], $_POST['Dimsoir']),
			array($_POST['Lunmatin'], $_POST['Lunsoir']),
			array($_POST['Marmatin'], $_POST['Marsoir']),
			array($_POST['Mermatin'], $_POST['Mersoir']),
			array($_POST['Jeumatin'], $_POST['Jeusoir']),
			array($_POST['Venmatin'], $_POST['Vensoir']),
			array($_POST['Sammatin'], $_POST['Samsoir'])
		);
		$db_worktimes=json_encode($worktimes);
		

		$stmt = $conn->prepare("UPDATE doctor SET language = ?, dq = ?, pricing = ?,worktime = ?,doctor_coord = ? WHERE doctor_id = ?");
		$stmt->bind_param("sssssi", $db_languages, $db_dq, $db_pricing,$db_worktimes,$db_coord, $_SESSION["id"]);
		$stmt->execute();
		
		$_SESSION["language"] = json_decode($db_languages);
		$_SESSION["dq"] = json_decode($db_dq);
		$_SESSION["pricing"] = json_decode($db_pricing);
		$_SESSION["worktime"]=$worktimes;
			

		header("Location: doctor_profile.php");
		exit();              
	} 

	?>

<div class="std_containerII">
	<div class="ep_container">

	<h3>Gerer Compte</h3>

<form class="ep_form" action="" method="POST" onsubmit="event.preventDefault(); getinput_doctor_editprofile()" id="editprofile" enctype="multipart/form-data">
<div class="pf">
	<div class="float_right_button_container"><input type="submit" class="input_button" value="modifier" id="modifie" ></div>
	<div class="pf_header pf_header_fix">
		<img id="preview" src="<?php echo $_SESSION["pf_img"] ?>">
		<!-- image -->
 		<button type="button" class="edit_profile_picture" onclick="previewImage(event, 0)">Modifier</button>
		<input type="file" id="profile_picture" name="picture" onchange="previewImage(event, 1)" accept="image/*">
		
		<div class="pf_header_text pf_header_text_fix">
			<div class="pf_header_text_name"><input class="txtarea" type="text" value="<?php echo $_SESSION["name"] ?>" name="name" autocomplete="off"/></div>
			<div class="pf_header_text_speciality"><input class="txtarea" type="text" value="<?php echo $_SESSION["speciality"] ?>" name="speciality" autocomplete="off"/></div>
		</div>
	</div>
	<div class="pf_body">
		<div class="pf_body_field"><h3>Description</h3>
			<textarea class="txtarea" name="description"><?php if(isset($_SESSION["description"])) { echo $_SESSION["description"];  } ?></textarea>
		</div>
		<div class="pf_body_field"><h3>Numero telephone</h3><input class="txtarea" type="text" value="<?php echo $_SESSION["phone"] ?>" name="phone"  autocomplete="off"/></div>
		<div class="pf_body_field"><h3>Adresse</h3><textarea class="txtarea" name="location"><?php if (isset($_SESSION["location"])){ echo $_SESSION["location"]; } ?></textarea></div>
		<div class="profile_map"><?php include("components/gps.php") ?></div>
		<input type="hidden" id="map_coord" name="coord" value="">
		<div class="pf_body_field"><h3>Date Naissance</h3><input type="date" name="bday"></div>
		<div class="pf_body_field"><h3>Horaires de travail</h3>
			<?php
			$DAYS = array("Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam");
			for ($i = 0; $i < 7; $i++) { ?>
			<p><?php echo $DAYS[$i] ?><input class="txtarea" name="<?php echo $DAYS[$i] ?>matin" value="<?php echo $worktimes[$i][0]?>"> - <input class="txtarea" name="<?php echo $DAYS[$i] ?>soir" value="<?php echo $worktimes[$i][1] ?>"></p>
			<?php } ?>
		</div>
		<div class="pf_body_field">
			<div class="float_right_button_container"><button type="button" class="input_button" onclick="add_pricing()">Ajouter</button></div>
			<h3 class="h3_fix">Tarifs</h3>
			<input type="hidden" id="pricing_input" name="pricing" value="">
			<p id="pretarif" >
				<?php if (!empty($pricings)) { foreach ($pricings as $pricing) { ?>
				<textarea class="tarif_el_service txtarea" rows="1" cols="50"><?php echo $pricing[0] ?> </textarea><textarea class="tarif_el_price txtarea" rows="1" cols="10"><?php echo $pricing[1] ?></textarea>	
				<?php  } } ?>
			</p>
		</div>
		<div class="pf_body_field">
			<div class="float_right_button_container"><button type="button" class="input_button" onclick="add_dq()">Ajouter</button></div>
			<h3 class="h3_fix">Diplomes & Qualifications</h3>
			<input type="hidden" id="dq_input" name="dq" value="">
			<p id="prediplome">
				<?php if (!empty($dqs)) { foreach ($dqs as $dq) {  ?>
				<textarea class="dq_el_date txtarea" rows="1" cols="10"><?php echo $dq[0] ?></textarea><textarea class="dq_el_event txtarea" rows="1" cols="50"><?php echo $dq[1] ?> </textarea>
				<?php  } } ?>
			</p>
		</div>
		<div class="pf_body_field">
			<div class="float_right_button_container"><button type="button" class="input_button" onclick="add_language()">Ajouter</button></div>
			<h3 class="h3_fix">Langues parlées</h3>
			<input type="hidden" id="languages_input" name="languages" value="">
			<p id="prelangue">
				<?php if (!empty($languages)) { foreach ($languages as $language) {  ?>
            	<textarea class="language_el txtarea"><?php echo $language; ?></textarea>,
				<?php } } ?>
			</p>
		</div>
	</div>
	<div>
		<div class="pf_body_field"><h3>Email</h3><input class="in_text" type="text"value="<?php echo $_SESSION["email"] ?>" name="email" autocomplete="off"/></div>
		<div class="pf_body_field"><h3>Password</h3><input class="in_text" type="password" placeholder="enter old password" name="old_password" autocomplete="off">
    	<input class="in_text" type="password" placeholder="enter new password" name="new_password" autocomplete="off" ></div>
	</div>
</div>
</form>
	</div>
</div>

<script src="index.js"></script>
<script type="text/javascript">//txtarea_autosize(0); 
add_language();getinput_doctor_editprofile </script>
</html>
</body>
</html>
<?php
}elseif(isset($_SESSION["usertype"]) && $_SESSION["usertype"]=='patient'){

header("Location: patient_index.php");
exit();

}else{

  header("Location: index.php");
  exit();
}  ?>


