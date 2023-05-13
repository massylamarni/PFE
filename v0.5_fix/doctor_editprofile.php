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


//retreiving the language array from db 
	$stmt = $conn->prepare("SELECT language FROM doctor WHERE doctor_id = ?");
	$stmt->bind_param("s", $_SESSION["id"]);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
    $languages=$row["language"];
	$languages=json_decode($languages);
	
//retreiving the dq array from db 
    $stmt = $conn->prepare("SELECT dq FROM doctor WHERE doctor_id = ?");
	$stmt->bind_param("s", $_SESSION["id"]);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	$dqs=$row["dq"];
	$dqs=json_decode($dqs);
	
//retreiving the pricing array from db 
   $stmt = $conn->prepare("SELECT pricing FROM doctor WHERE doctor_id = ?");
   $stmt->bind_param("s", $_SESSION["id"]);
   $stmt->execute();
   $result = $stmt->get_result();
   $row = $result->fetch_assoc();
   $pricings=$row["pricing"];
   $pricings=json_decode($pricings);

//retreiving the worktime object from db 
    $stmt = $conn->prepare("SELECT worktime FROM doctor WHERE doctor_id = ?");
	$stmt->bind_param("s", $_SESSION["id"]);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
    $worktimes=$row["worktime"];
	$worktimes=json_decode($worktimes);

	if (empty($worktimes)) {
		$worktimes = new stdClass();
		$worktimes->Dimmatin = '';$worktimes->Dimsoir = '';
		$worktimes->Lunmatin = '';$worktimes->Lunsoir = '';
		$worktimes->Marmatin = '';$worktimes->Marsoir = '';
		$worktimes->Mermatin = '';$worktimes->Mersoir = '';
		$worktimes->Jeumatin = '';$worktimes->Jeusoir = '';
		$worktimes->Venmatin = '';$worktimes->Vensoir = '';
		$worktimes->Sammatin = '';$worktimes->Samsoir = '';	
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

		    $db_languages=$_POST["languages"];
		    $stmt = $conn->prepare("UPDATE doctor SET language = ? WHERE doctor_id = ?");
	    	$stmt->bind_param("si", $db_languages, $_SESSION["id"]);
	    	$stmt->execute();
	    	$_SESSION["language"]= json_decode($db_languages);


			$db_dq=($_POST["dq"]);
		    $stmt = $conn->prepare("UPDATE doctor SET dq = ? WHERE doctor_id = ?");
	    	$stmt->bind_param("si", $db_dq, $_SESSION["id"]);
	    	$stmt->execute();
	    	$_SESSION["dq"]=json_decode($db_dq);
		
		
			$db_pricing=$_POST["pricing"];
		    $stmt = $conn->prepare("UPDATE doctor SET pricing = ? WHERE doctor_id = ?");
	    	$stmt->bind_param("si", $db_pricing, $_SESSION["id"]);
	    	$stmt->execute();
	    	$_SESSION["pricing"]=json_decode($db_pricing);

			$submittedWorktime = array(
				'Dimmatin' => $_POST['Dimmatin'],'Dimsoir' => $_POST['Dimsoir'],
				'Lunmatin' => $_POST['Lunmatin'],'Lunsoir' => $_POST['Lunsoir'],
				'Marmatin' => $_POST['Marmatin'],'Marsoir' => $_POST['Marsoir'],
				'Mermatin' => $_POST['Mermatin'],'Mersoir' => $_POST['Mersoir'],
				'Jeumatin' => $_POST['Jeumatin'],'Jeusoir' => $_POST['Jeusoir'],
				'Venmatin' => $_POST['Venmatin'],'Vensoir' => $_POST['Vensoir'],
				'Sammatin' => $_POST['Sammatin'],'Samsoir' => $_POST['Samsoir'],
			);
		
			foreach ($submittedWorktime as $key => $value) {
				$worktimes->$key = $value;
			}
			
			$db_worktimes=json_encode($worktimes);
			$stmt = $conn->prepare("UPDATE doctor SET worktime = ? WHERE doctor_id = ?");
	    	$stmt->bind_param("si", $db_worktimes, $_SESSION["id"]);
	    	$stmt->execute();
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
				Dim:<textarea class="txtarea" name="Dimmatin"><?php echo $worktimes->Dimmatin ?></textarea> - <textarea class="txtarea" name="Dimsoir"><?php echo $worktimes->Dimsoir?></textarea>	
				Lun:<textarea class="txtarea" name="Lunmatin"><?php echo $worktimes->Lunmatin ?></textarea> - <textarea class="txtarea" name="Lunsoir"><?php echo $worktimes->Lunsoir ?></textarea>
				Mar:<textarea class="txtarea" name="Marmatin"><?php echo $worktimes->Marmatin ?></textarea> - <textarea class="txtarea" name="Marsoir"><?php echo $worktimes->Marsoir ?></textarea>
				Mer:<textarea class="txtarea" name="Mermatin"><?php echo $worktimes->Mermatin ?></textarea> - <textarea class="txtarea" name="Mersoir"><?php echo $worktimes->Mersoir?></textarea>
				Jeu:<textarea class="txtarea" name="Jeumatin"><?php echo $worktimes->Jeumatin ?></textarea> - <textarea class="txtarea" name="Jeusoir"><?php echo $worktimes->Jeusoir ?></textarea>
				Ven:<textarea class="txtarea" name="Venmatin"><?php echo $worktimes->Venmatin ?></textarea> - <textarea class="txtarea" name="Vensoir"><?php echo $worktimes->Vensoir ?></textarea>
				Sam:<textarea class="txtarea" name="Sammatin"><?php echo $worktimes->Sammatin ?></textarea> - <textarea class="txtarea" name="Samsoir"><?php echo $worktimes->Samsoir ?></textarea>
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
ajouterunelangue();ajouterundiplome ();ajoutertarifs(); modifie() </script>
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

