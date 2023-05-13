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
			
			
	    	

		header("Location: doctor_profile.php");
		exit();              
	} 

	?>

<div class="std_container">
	<div class="ep_container">

	<h3>Gerer Compte</h3>

<form class="ep_form" action="" method="POST" onsubmit="event.preventDefault(); getinput_doctor_editprofile()" id="editprofile">
<div class="pf" >
	<div class="pf_header">
		<img src="<?php echo $pf_img ?>">
		<div class="pf_header_text">
		<div class="pf_header_text_name"><input class="txtarea" type="text" value="<?php echo $_SESSION["name"] ?>" name="name" autocomplete="off"/></div>
		<div>
			<p>modifie la photo de profile</p>
			<input type="file" id="photodeprofile">

	    </div>
			<div class="pf_header_text_speciality">
				<input class="txtarea" type="text" value="<?php echo $_SESSION["speciality"] ?>" name="speciality" autocomplete="off"/>
			</div>
		</div>
	</div>
	<div class="pf_body">
		<div class="pf_body_field"><h3>Description</h3>
			<pre><textarea class="txtarea" name="description"><?php if(isset($_SESSION["description"])) { echo $old_description;  } ?></textarea></pre>
		</div>
		<div class="pf_body_field"><h3>Numero telephone</h3><input class="txtarea" type="text" value="<?php echo $_SESSION["phone"] ?>" name="phone"  autocomplete="off"/></div>
		<div class="pf_body_field"><h3>Adresse</h3><textarea class="txtarea" name="location"><?php if (isset($_SESSION["location"])){ echo $old_location; } ?></textarea></div>
		<div class="pf_body_field"><h3>Date Naissance</h3><input type="date" name="bday"></div>
		<div class="pf_body_field"><h3>Horaires de travail</h3>
			<pre>
				Dim:<textarea class="txtarea" name="Dimmatin"><?php  echo $worktimes[0][0]?></textarea> - <textarea class="txtarea" name="Dimsoir"><?php  echo $worktimes[0][1]?></textarea>	
				Lun:<textarea class="txtarea" name="Lunmatin"><?php  echo $worktimes[1][0] ?></textarea> - <textarea class="txtarea" name="Lunsoir"><?php echo $worktimes[1][1] ?></textarea>
				Mar:<textarea class="txtarea" name="Marmatin"><?php  echo $worktimes[2][0] ?></textarea> - <textarea class="txtarea" name="Marsoir"><?php echo $worktimes[2][1] ?></textarea>
				Mer:<textarea class="txtarea" name="Mermatin"><?php  echo $worktimes[3][0] ?></textarea> - <textarea class="txtarea" name="Mersoir"><?php echo $worktimes[3][1]?></textarea>
				Jeu:<textarea class="txtarea" name="Jeumatin"><?php  echo $worktimes[4][0] ?></textarea> - <textarea class="txtarea" name="Jeusoir"><?php echo $worktimes[4][1] ?></textarea>
				Ven:<textarea class="txtarea" name="Venmatin"><?php  echo $worktimes[5][0] ?></textarea> - <textarea class="txtarea" name="Vensoir"><?php echo $worktimes[5][1] ?></textarea>
				Sam:<textarea class="txtarea" name="Sammatin"><?php  echo $worktimes[6][0] ?></textarea> - <textarea class="txtarea" name="Samsoir"><?php echo $worktimes[6][1] ?></textarea>
			</pre>
		</div>
		<div class="pf_body_field"><h3>Tarifs</h3>
		<input type="hidden" id="pricing_input" name="pricing" value="">
			<pre id="pretarif" ><?php if (!empty($pricings)) { foreach ($pricings as $pricing) {  ?>
<textarea class="tarif_el_service txtarea" rows="1" cols="50"><?php echo $pricing[0] ?> </textarea><textarea class="tarif_el_price txtarea" rows="1" cols="10"><?php echo $pricing[1] ?></textarea>
			</pre>
			<?php  } } ?>
			<buton type="button" onclick="add_pricing()">Ajouter</button>
		</div>
		<div class="pf_body_field"><h3>Diplomes & Qualifications</h3>
		<input type="hidden" id="dq_input" name="dq" value="">
			<pre id="prediplome" > <?php if (!empty($dqs)) { foreach ($dqs as $dq) {  ?>
</textarea><textarea class="dq_el_date txtarea" rows="1" cols="10"><?php echo $dq[0] ?></textarea><textarea class="dq_el_event txtarea" rows="1" cols="50"><?php echo $dq[1] ?> </textarea>
			</pre>
			<?php  } } ?>
			<button type="button" onclick="add_dq()">Ajouter</button>
		</div>
		<div class="pf_body_field"><h3>Langues parlées</h3>
		<input type="hidden" id="languages_input" name="languages" value="">
		<pre id="prelangue" ><?php if (!empty($languages)) { foreach ($languages as $language) {  ?>
             <textarea class="language_el txtarea"><?php echo $language; ?></textarea>,
		</pre>
		<?php   } } ?>
		<button type="button" onclick="add_language()">Ajouter</button>
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


