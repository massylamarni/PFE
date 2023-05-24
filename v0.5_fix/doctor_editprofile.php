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

$pf_img = "assets/pfp2.png";


			

//checking for session variables

      if (isset($_SESSION["location"])){
      $old_location=$_SESSION["location"];
      }
	/*if (isset($_SESSION["pf_img"])) {
		$old_pf_img=$_SESSION["pf_img"] ;
	}*/
	if (isset($_SESSION["description"])) {
		$old_description=$_SESSION["description"] ;
	}
	
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

		$stmt = $conn->prepare("UPDATE doctor SET language = ?, dq = ?, pricing = ?,worktime = ? WHERE doctor_id = ?");
		$stmt->bind_param("ssssi", $db_languages, $db_dq, $db_pricing,$db_worktimes, $_SESSION["id"]);
		$stmt->execute();
		
		$_SESSION["language"] = json_decode($db_languages);
		$_SESSION["dq"] = json_decode($db_dq);
		$_SESSION["pricing"] = json_decode($db_pricing);
		$_SESSION["worktime"]=$worktimes;
			
		$db_coord=$_POST["coord"];

		$stmt = $conn->prepare("UPDATE doctor SET doctor_coord = ? WHERE doctor_id = ?");
		$stmt->bind_param("si",  $db_coord, $_SESSION["id"]);
		$stmt->execute();
	
			
	    	

		header("Location: doctor_profile.php");
		exit();              
	} 

	?>

<div class="std_container">
	<div class="ep_container">

	<h3>Gerer Compte</h3>

<form class="ep_form" action="" method="POST" onsubmit="event.preventDefault(); getinput_doctor_editprofile()" id="editprofile">
<div class="pf" >
	<div class="flex flexstart spacebetween hdr">
	<div class="pf_header">
	
		<div class="flex jsend flexcol">
			
			<div class="file-input abpos">
			  <input type="file" id="photodeprofile" class="file-input__input" />
			  <label for="photodeprofile" class="file-input__label">
				<?xml version="1.0" encoding="utf-8"?> <!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  --> <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 261 222" enable-background="new 0 0 261 222" xml:space="preserve"> <g id="XMLID_2_"> <path id="XMLID_9_" fill="#010101" d="M254.2,54.7c0-8.2-5.3-13.4-13.4-13.4c-17.8,0-35.6,0-53.5,0c-1.3,0-1.9-0.3-2.4-1.6 c-3.7-9.4-7.5-18.8-11.2-28.2c-0.4-1-0.8-1.4-2-1.4c-28.2,0-56.3,0-84.5,0c-1.1,0-1.6,0.4-2,1.4c-3.7,9.5-7.5,18.9-11.3,28.4 c-0.4,1.1-1,1.5-2.2,1.5c-18,0-36,0-54.1,0c-2.1,0-4.2,0.4-6.1,1.4c-4.7,2.6-6.9,6.6-6.9,12c0,49.3,0,98.7,0,148c0,0.5,0,1,0,1.5 c0.1,2.6,1,4.9,2.6,7c2.8,3.5,6.4,4.8,10.8,4.8c37.1,0,74.2,0,111.2,0c37,0,73.9,0,110.9,0c1.4,0,2.8,0,4.1-0.3 c6.1-1.4,9.8-6.3,9.8-13C254.2,153.3,254.2,104,254.2,54.7z M191.5,130.3c-0.8,34-29.3,61.4-63.6,60.8c-34.3-0.6-61.6-29.1-61-63.7 c0.6-34.4,29-61.7,63.6-61.1C164.8,67,192.3,95.7,191.5,130.3z"/> <path id="XMLID_10_" fill="#010101" d="M129.9,97.5c-17.4,0-31.4,13.9-31.4,31.2c0,17.1,14,31.1,31.1,31.2 c17.2,0,31.3-13.9,31.3-31.1C161,111.6,147,97.5,129.9,97.5z"/> </g> <g id="XMLID_58_"> </g> <g id="XMLID_59_"> </g> <g id="XMLID_60_"> </g> <g id="XMLID_61_"> </g> <g id="XMLID_62_"> </g> <g id="XMLID_63_"> </g> </svg>
				Modifier
			  </label>
			</div>
			<img src="<?php echo $pf_img ?>">
		</div>
			
			
		<div class="pf_header_text">
		<div class="pf_header_text_name flex flexcol fiveg">
			<Label for="name" class="lbl">Nom complet</label>
			<input type="text" class="inpt" value="<?php echo $_SESSION["name"] ?>" name="name" autocomplete="off"/>
		</div>
		<div>

			


	    </div>
			<div class="pf_header_text_speciality flex flexcol fiveg">
				<Label for="name" class="lbl">Spécialité</label>
				<input class="inpt" type="text" value="<?php echo $_SESSION["speciality"] ?>" name="speciality" autocomplete="off"/>
			</div>
		</div>
	</div>
	
	
	
		
		<button type="submit" class="btnprimary" >Enregistrer</button>
	</div>
	
	
	<div class="pf_body">
		<div class="pf_body_field">
			<h3>Description</h3>
			<textarea class="txtar" name="description"><?php if(isset($_SESSION["description"])) { echo $old_description;  } ?></textarea>
		</div>
		<div class="pf_body_field"><h3>Numero telephone</h3><input class="txtarea" type="text" value="<?php echo $_SESSION["phone"] ?>" name="phone"  autocomplete="off"/></div>
		<div class="pf_body_field"><h3>Adresse</h3><textarea class="txtar" name="location"><?php if (isset($_SESSION["location"])){ echo $old_location; } ?></textarea></div>
		
		<div class="list_map"><?php include("components/gps.php") ?> </div>
		<input type="hidden" id="map_coord" name="coord" value="">
		
		<div class="pf_body_field"><h3>Date Naissance</h3><input type="date" name="bday"></div>
		<div class="pf_body_field flex flexcol twentg">
			<div class="flex flexcol teng">
				<h3>Horaires de travail</h3>
				<div class="flex flexcenter teng horr">Dim:<input type="text" value="<?php  echo $worktimes[0][0]?>" name="Dimmatin"></input> - <input type="text" name="Dimsoir" value="<?php  echo $worktimes[0][1]?>"></input></div>
				<div class="flex flexcenter teng horr">Lun:<input type="text" name="Lunmatin" value="<?php  echo $worktimes[1][0] ?>"></input> - <input type="text" name="Lunsoir" value="<?php echo $worktimes[1][1] ?>"></input></div>
				<div class="flex flexcenter teng horr">Mar:<input type="text" name="Marmatin" value="<?php  echo $worktimes[2][0] ?>"></input> - <input type="text" name="Marsoir" value="<?php echo $worktimes[2][1] ?>"></input></div>
				<div class="flex flexcenter teng horr">Mer:<input type="text" name="Mermatin" value="<?php  echo $worktimes[3][0] ?>"></input> - <input type="text" name="Mersoir" value="<?php echo $worktimes[3][1]?>"></input></div>
				<div class="flex flexcenter teng horr">Jeu:<input type="text" name="Jeumatin" value="<?php  echo $worktimes[4][0] ?>"></input> - <input type="text" name="Jeusoir" value="<?php echo $worktimes[4][1] ?>"></input></div>
				<div class="flex flexcenter teng horr">Ven:<input type="text" name="Venmatin" value="<?php  echo $worktimes[5][0] ?>"></input> - <input type="text" name="Vensoir" value="<?php echo $worktimes[5][1] ?>"></input></div>
				<div class="flex flexcenter teng horr">Sam:<input type="text" name="Sammatin" value="<?php  echo $worktimes[6][0] ?>"></input> - <input type="text" name="Samsoir" value="<?php echo $worktimes[6][1] ?>"></input></div>
			</pre>
		</div>
		<div class="pf_body_field">
		<div class="flex teng">
			<h3>Tarifs</h3> 
			<a class="rdvbutton" onclick="add_pricing()">
				<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 20 20" enable-background="new 0 0 20 20" xml:space="preserve" fill="#005ebf" width="14"> <g id="XMLID_1_"> <path id="XMLID_3_" fill="#005ebf" d="M18,11.7h-6.8v6.8H8.4v-6.8H1.5V8.9h6.9V2h2.8v6.9H18V11.7z"></path> </g> <g id="XMLID_2_"> </g> <g id="XMLID_5_"> </g> <g id="XMLID_6_"> </g> <g id="XMLID_7_"> </g> <g id="XMLID_8_"> </g> <g id="XMLID_9_"> </g> </svg> 
				Ajouter
			</a>
		</div>
		<input type="hidden" id="pricing_input" name="pricing" value="">
			<div id="pretarif" >
			<?php if (!empty($pricings)) { foreach ($pricings as $pricing) {  ?>
				<div class="tarif_el flex fiveg">
					<input placeholder="Sevice" class="tarif_el_service" value="<?php echo $pricing[0] ?>"> </input>
					<input placeholder="Prix" class="tarif_el_price" value="<?php echo $pricing[1] ?>"></input>
				</div>
			<?php  } } ?>
			</div>
			
			
		</div>
		<div class="pf_body_field">
		<div class="flex teng">
			<h3>Diplomes & Qualifications</h3> 
			<a class="rdvbutton" onclick="add_dq()">
				<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 20 20" enable-background="new 0 0 20 20" xml:space="preserve" fill="#005ebf" width="14"> <g id="XMLID_1_"> <path id="XMLID_3_" fill="#005ebf" d="M18,11.7h-6.8v6.8H8.4v-6.8H1.5V8.9h6.9V2h2.8v6.9H18V11.7z"></path> </g> <g id="XMLID_2_"> </g> <g id="XMLID_5_"> </g> <g id="XMLID_6_"> </g> <g id="XMLID_7_"> </g> <g id="XMLID_8_"> </g> <g id="XMLID_9_"> </g> </svg> 
				Ajouter
			</a>
		</div>
		<input type="hidden" id="dq_input" name="dq" value="">
		<div id="prediplome" class="flex teng flexcol" > 
			<?php if (!empty($dqs)) { foreach ($dqs as $dq) {  ?>
				<div class="dq_el flex flex fiveg">
					<input class="dq_el_date txtarea" value="<?php echo $dq[0] ?>"></input>
					<input class="dq_el_event txtarea" value="<?php echo $dq[1] ?>"></input>
				</div>
			<?php  } } ?>
			</div>
		</div>
		<div class="pf_body_field">
		<div class="flex teng">
			<h3>Langues parlées</h3> 
			<a class="rdvbutton" onclick="add_language(0)">
				<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 20 20" enable-background="new 0 0 20 20" xml:space="preserve" fill="#005ebf" width="14"> <g id="XMLID_1_"> <path id="XMLID_3_" fill="#005ebf" d="M18,11.7h-6.8v6.8H8.4v-6.8H1.5V8.9h6.9V2h2.8v6.9H18V11.7z"></path> </g> <g id="XMLID_2_"> </g> <g id="XMLID_5_"> </g> <g id="XMLID_6_"> </g> <g id="XMLID_7_"> </g> <g id="XMLID_8_"> </g> <g id="XMLID_9_"> </g> </svg> 
				Ajouter
			</a>
		</div>
		<input type="hidden" id="languages_input" name="languages" value="">
		
		<div class="flex bsline teng rvsrow flxend">
		
			<div id="prelangue" >
			<?php if (!empty($languages)) { foreach ($languages as $language) {  ?>
				 <input class="language_el txtarea" value="<?php echo $language; ?>"></input>
			<?php   } } ?>
			</div>
			
		</div>
		
		</div>
		<div class="pf_body_images"><h3>∮ Images</h3></div>
	</div>
	<div>
	<div class="pf_body_field"><h3>Email</h3><input class="in_text" type="text"value="<?php echo $_SESSION["email"] ?>" name="email" autocomplete="off"/></div>
	<div class="pf_body_field"><h3>Password</h3>
		<div class="flex flexcol teng pf_body_field ">
			<input class="in_text" type="password" placeholder="enter old password" name="old_password" autocomplete="off">
			<input class="in_text" type="password" placeholder="enter new password" name="new_password" autocomplete="off" >
		</div>
	</div>
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
<?php     }elseif(isset($_SESSION["usertype"]) && $_SESSION["usertype"]=='patient'){

header("Location: patient_index.php");
exit();

}else{

  header("Location: index.php");
  exit();
}  ?>


