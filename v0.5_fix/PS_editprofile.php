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

<?php  include("components/navbar.php"); 

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

//retreiving the language array from db and sending it to js
	$stmt = $conn->prepare("SELECT language FROM doctor WHERE doctor_id = ?");
	$stmt->bind_param("s", $_SESSION["id"]);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
    $languages=$row["language"];
	$languages=json_decode($languages);
	echo '<script> var languagesData = ' . json_encode($languages) . ';</script>';
	
//retreiving the dq array from db and sending it to js
    $stmt = $conn->prepare("SELECT dq FROM doctor WHERE doctor_id = ?");
	$stmt->bind_param("s", $_SESSION["id"]);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	$dqs=$row["dq"];
	$dqs=json_decode($dqs);
	echo '<script> var dqData = ' . json_encode($dqs) . ';</script>';
	
//retreiving the pricing array from db and sending it to js
   $stmt = $conn->prepare("SELECT pricing FROM doctor WHERE doctor_id = ?");
   $stmt->bind_param("s", $_SESSION["id"]);
   $stmt->execute();
   $result = $stmt->get_result();
   $row = $result->fetch_assoc();
   $pricings=$row["pricing"];
   $pricings=json_decode($pricings);
   echo '<script> var pricingData = ' . json_encode($pricings) . ';</script>';

	

$pf_img = "assets/pfp2.png";
$worktime = array("Dimmatin"=>"09h30","Dimsoir"=> "19h30", "Lunmatin"=>"09h30","Lunsoir"=> "19h30", 
             "Marmatin"=>"09h30","Marsoir"=> "19h30","Mermatin"=>"09h30","Mersoir"=> "19h30", 
			"Jeumatin"=>"09h30","Jeusoir"=>"19h30","Venmatin"=>"","Vensoir"=> "", 
			"Sammatin"=>"09h30","Samsoir"=> "19h30");

			

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
	if (isset($_SESSION["worktime"])) {
		$old_worktime=$_SESSION["worktime"] ;
	}
	if (isset($_SESSION["pricing"])) {
		$old_pricing=$_SESSION["pricing"] ;
	}
	if (isset($_SESSION["dq"])) {
		$old_dq=$_SESSION["dq"] ;
	}
	if (isset($_SESSION["language"])) {
		$old_language=$_SESSION["language"] ;
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
		if (isset($_POST["languages"])){    
	     	$db_languages=json_encode($languages);
		    $stmt = $conn->prepare("UPDATE doctor SET language = ? WHERE doctor_id = ?");
	    	$stmt->bind_param("si", $db_languages, $_SESSION["id"]);
	    	$stmt->execute();
	    	$_SESSION["language"]=$languages;
		}

		if (isset($_POST["dq"])){    
			$db_dq=json_encode($dqs);
		    $stmt = $conn->prepare("UPDATE doctor SET dq = ? WHERE doctor_id = ?");
	    	$stmt->bind_param("si", $db_dq, $_SESSION["id"]);
	    	$stmt->execute();
	    	$_SESSION["dq"]=$dqs;
		} 

		if (isset($_POST["pricing"])){    
			$db_pricing=json_encode($pricings);
		    $stmt = $conn->prepare("UPDATE doctor SET pricing = ? WHERE doctor_id = ?");
	    	$stmt->bind_param("si", $db_pricing, $_SESSION["id"]);
	    	$stmt->execute();
	    	$_SESSION["pricing"]=$pricings;

		} 	
	} 

	?>

<div class="std_container">
	<div class="ep_container">

	<h3>Gerer Compte</h3>

<form class="ep_form" action="" method="POST">
<div class="pf" >
	<div class="pf_header">
		<img src="<?php echo $pf_img ?>">
		<div class="pf_header_text">
		<div class="pf_header_text_name"><input type="text" value="<?php echo $_SESSION["name"] ?>" name="name" autocomplete="off"/></div>
			<div class="pf_header_text_speciality">
				<input type="text" value="<?php echo $_SESSION["speciality"] ?>" name="speciality" autocomplete="off"/>
			</div>
		</div>
	</div>
	<div class="pf_body">
		<div class="pf_body_field"><h3>Description</h3>
			<pre><textarea rows="5" cols="100" name="description"><?php if(isset($_SESSION["description"])) { echo $old_description;  } ?></textarea></pre>
		</div>
		<div class="pf_body_field"><h3>Numero telephone</h3><input type="text" value="<?php echo $_SESSION["phone"] ?>" name="phone"  autocomplete="off"/></div>
		<div class="pf_body_field"><h3>Adresse</h3><textarea rows="1" cols="50" name="location"><?php if (isset($_SESSION["location"])){ echo $old_location; } ?></textarea></div>
		<div class="pf_body_field"><h3>Date Naissance</h3><input type="date" name="bday"></div>
		<div class="pf_body_field"><h3>Horaires de travail</h3>
			<pre>
				Dim:<textarea rows="1" cols="5"name="Dimmatin"><?php echo$worktime["Dimmatin"] ?></textarea> - <textarea rows="1" cols="5" name="Dimsoir"><?php echo $worktime["Dimsoir"] ?></textarea>
				Lun:<textarea rows="1" cols="5"name="Lunmatin"><?php echo $worktime["Lunmatin"] ?></textarea> - <textarea rows="1" cols="5"name="Lunsoir"><?php echo $worktime["Lunsoir"] ?></textarea>
				Mar:<textarea rows="1" cols="5"name="Marmatin"><?php echo $worktime["Marmatin"] ?></textarea> - <textarea rows="1" cols="5"name="Marsoir"><?php echo $worktime["Marsoir"] ?></textarea>
				Mer:<textarea rows="1" cols="5"name="Mermatin"><?php echo $worktime["Mermatin"] ?></textarea> - <textarea rows="1" cols="5"name="Mersoir"><?php echo $worktime["Mersoir"] ?></textarea>
				Jeu:<textarea rows="1" cols="5"name="Jeumatin"><?php echo $worktime["Jeumatin"] ?></textarea> - <textarea rows="1" cols="5"name="Jeusoir"><?php echo $worktime["Jeusoir"] ?></textarea>
				Ven:<textarea rows="1" cols="5"name="Venmatin"><?php echo $worktime["Venmatin"] ?></textarea> - <textarea rows="1" cols="5"name="Vensoir"><?php echo $worktime["Vensoir"] ?></textarea>
				Sam:<textarea rows="1" cols="5"name="Sammatin"><?php echo $worktime["Sammatin"] ?></textarea> - <textarea rows="1" cols="5"name="Samsoir"><?php echo $worktime["Samsoir"] ?></textarea>
			</pre>
		</div>
		<div class="pf_body_field"><h3>Tarifs</h3>
		<input type="hidden" id="pricing_input" name="pricing" value="">
			<pre id="pretarif" >
				<textarea rows="1" cols="50"><?php  ?></textarea>
			</pre>
			<input type="submit" id="tarif" value="ajouter un tarifs">
		</div>
		<div class="pf_body_field"><h3>Diplomes & Qualifications</h3>
		<input type="hidden" id="dq_input" name="dq" value="">
			<pre id="prediplome" >
				<textarea rows="1" cols="10"><?php  ?></textarea>
			</pre>
			<input type="submit" id="diplome" value="ajouter un diplome">
		</div>
		<div class="pf_body_field"><h3>Langues parlées</h3>
		<input type="hidden" id="languages_input" name="languages" value="">
		<pre id="prelangue" ><?php if (!empty($languages)) { foreach ($languages as $language) {  ?>
             <textarea class="langue" rows="1" cols="15"><?php echo $language; ?></textarea>,
		</pre>
		<?php   } } ?>
		<input type="submit" id="ajouter" value="ajouter une langue">
		</div>
		<div class="pf_body_images"><h3>∮ Images</h3></div>
	</div>
	<div>
	<div class="pf_body_field"><h3>Email</h3><input class="in_text" type="text"value="<?php echo $_SESSION["email"] ?>" name="email" autocomplete="off"/></div>
	<div class="pf_body_field"><h3>Password</h3><input class="in_text" type="password" placeholder="enter old password" name="old_password" autocomplete="off">
    <input class="in_text" type="password" placeholder="enter new password" name="new_password" autocomplete="off" ></div>
	</div>
</div>
<input type="submit" value="modifier" id="modifie" >
</form>
	</div>
</div>

<script src="index.js"></script>
<script type="text/javascript">ajouterunelangue();ajouterundiplome ();ajoutertarifs();modifie() </script>
</html>
</body>
</html>
<?php   }else{

header("Location: index.php");
exit();

}  

?>


