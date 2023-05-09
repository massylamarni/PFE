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

//getting the language array from db and sending it to js
	$stmt = $conn->prepare("SELECT language FROM doctor WHERE doctor_id = ?");
	$stmt->bind_param("s", $_SESSION["id"]);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
    $languages=$row["language"];
	$languages=json_decode($languages);
	echo '<script> var languagesData = ' . json_encode($languages) . ';</script>';
	
//getting the dq array from db and sending it to js


$pf_img = "assets/pfp2.png";
$worktime = array(array("09h30", "19h30"), array("09h30", "19h30"), array("09h30", "19h30"), array("09h30", "19h30"), array("09h30", "19h30"), array("", ""), array("09h30", "19h30"));
$pricing = array(array("Consultation simple", "100 £"), array("Consultation avec acte", "200 £"));
$dq = array(array("1977", "Diplôme d'État de docteur en médecine - Université Paris 11 - Paris-Saclay"), array("1977", "D.E.S. Dermatologie et vénéréologie - UFR de médecine Lariboisière-Saint-Louis"));



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
		//$new_worktime=$_POST["worktime"];
		//$new_pricing=$_POST["pricing"];
		//$new_dq=$_POST["dq"];
		//$new_language=$_POST["language"];

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
	     	$db_languages=json_encode($languages);
		    $stmt = $conn->prepare("UPDATE doctor SET language = ? WHERE doctor_id = ?");
	    	$stmt->bind_param("si", $db_languages, $_SESSION["id"]);
	    	$stmt->execute();
	    	$_SESSION["language"]=$languages;

		
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
				Dim:<textarea rows="1" cols="5"><?php echo $worktime[0][0] ?></textarea> - <textarea rows="1" cols="5"><?php echo $worktime[0][1] ?></textarea>
				Lun:<textarea rows="1" cols="5"><?php echo $worktime[1][0] ?></textarea> - <textarea rows="1" cols="5"><?php echo $worktime[1][1] ?></textarea>
				Mar:<textarea rows="1" cols="5"><?php echo $worktime[2][0] ?></textarea> - <textarea rows="1" cols="5"><?php echo $worktime[2][1] ?></textarea>
				Mer:<textarea rows="1" cols="5"><?php echo $worktime[3][0] ?></textarea> - <textarea rows="1" cols="5"><?php echo $worktime[3][1] ?></textarea>
				Jeu:<textarea rows="1" cols="5"><?php echo $worktime[4][0] ?></textarea> - <textarea rows="1" cols="5"><?php echo $worktime[4][1] ?></textarea>
				Ven:<textarea rows="1" cols="5"><?php echo $worktime[5][0] ?></textarea> - <textarea rows="1" cols="5"><?php echo $worktime[5][1] ?></textarea>
				Sam:<textarea rows="1" cols="5"><?php echo $worktime[6][0] ?></textarea> - <textarea rows="1" cols="5"><?php echo $worktime[6][1] ?></textarea>
			</pre>
		</div>
		<div class="pf_body_field"><h3>Tarifs</h3>
			<pre id="pretarif" >
				<textarea rows="1" cols="50"><?php echo $pricing[0][0] ?></textarea><textarea rows="1" cols="10"><?php echo $pricing[0][1] ?></textarea>
				<textarea rows="1" cols="50"><?php echo $pricing[1][0] ?></textarea><textarea rows="1" cols="10"><?php echo $pricing[1][1] ?></textarea>
			</pre>
			<input type="submit" id="tarif" value="ajouter un tarifs">
		</div>
		<div class="pf_body_field"><h3>Diplomes & Qualifications</h3>
			<pre id="prediplome" >
				<textarea rows="1" cols="10"><?php echo $dq[0][0] ?></textarea><textarea rows="1" cols="50"><?php echo $dq[0][1] ?></textarea>
				<textarea rows="1" cols="10"><?php echo $dq[1][0] ?></textarea><textarea rows="1" cols="50"><?php echo $dq[1][1] ?></textarea>
			</pre>
			<input type="submit" id="diplome" value="ajouter un diplome">
		</div>
		<div class="pf_body_field"><h3>Langues parlées</h3>
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


