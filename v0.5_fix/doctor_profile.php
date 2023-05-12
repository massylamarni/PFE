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
//ini_set('display_errors', 1);

include("components/navbar.php");

if(!isset($_SESSION)){session_start(); }

if(isset($_SESSION["usertype"]) && $_SESSION["usertype"]=='doctor') {

$pf_img = "assets/pfp2.png";  ?>

<div class="std_container">
	<div class="ep_container">

	<h3>Mon profile</h3>

<form class="ep_form" >
<div class="pf" >
	<div class="pf_header">
		<img src="<?php echo $pf_img ?>">
		<div class="pf_header_text">
		<div class="pf_header_text_name"><label><?php echo $_SESSION["name"] ?></label></div>
			<div class="pf_header_text_speciality">
				<label><?php echo $_SESSION["speciality"] ?></label>
			</div>
		</div>
	</div>
	<div class="pf_body">
		<div class="pf_body_field"><h3>Description</h3>
			<pre><label><?php if(isset($_SESSION["description"])){ echo $_SESSION["description"]; }?></label></pre>
		</div>
		<div class="pf_body_field"><h3>Numero telephone</h3><label><?php echo $_SESSION["phone"] ?></label></div>
		<div class="pf_body_field"><h3>Adresse</h3><label><?php if (isset($_SESSION["location"])){ echo $_SESSION["location"]; } ?></label></div>
		<div class="pf_body_field"><h3>Date Naissance</h3><label><?php echo $_SESSION["bday"] ?></label> </div>
		<div class="pf_body_field"><h3>Horaires de travail</h3>
		<?php if (isset($_SESSION["worktime"])) { 
			if (is_string($_SESSION["worktime"])) {
				$worktime =json_decode($_SESSION["worktime"]) ;
			} else {$worktime= $_SESSION["worktime"]; }?>
			<pre>
				Dim:<label><?php echo $worktime->Dimmatin ?></label> - <label><?php echo $worktime->Dimsoir ?></label>
				Lun:<label><?php echo $worktime->Lunmatin ?></label> - <label><?php echo $worktime->Lunsoir ?></label>
				Mar:<label><?php echo $worktime->Marmatin ?></label> - <label><?php echo $worktime->Marsoir ?></label>
				Mer:<label><?php echo $worktime->Mermatin ?></label> - <label><?php echo $worktime->Mersoir ?></label>
				Jeu:<label><?php echo $worktime->Jeumatin ?></label> - <label><?php echo $worktime->Jeusoir ?></label>
				Ven:<label><?php echo $worktime->Venmatin ?></label> - <label><?php echo $worktime->Vensoir ?></label>
				Sam:<label><?php echo $worktime->Sammatin ?></label> - <label><?php echo $worktime->Samsoir ?></label>
			<?php  }  ?>
			</pre>
		</div>
		
		
		<div class="pf_body_field"><h3>Tarifs</h3>
		<pre>
		<?php if (isset($_SESSION["pricing"])) { 
			if (is_string($_SESSION["pricing"])) {$_SESSION["pricing"]=json_decode($_SESSION["pricing"]);}
			foreach ($_SESSION["pricing"] as $pricing) {  ?>
<label> <?php echo $pricing[0] ?></label> : <label><?php echo $pricing[1] ?></label>
        <?php } } ?>
        </pre>			
		</div>

		<div class="pf_body_field"><h3>Diplomes & Qualifications</h3>
		<pre>
		<?php if (isset($_SESSION["dq"])){
		if (is_string($_SESSION["dq"])) {$_SESSION["dq"]=json_decode($_SESSION["dq"]);}
		 foreach ($_SESSION["dq"] as $dq) {  ?>
<label> <?php echo $dq[0] ?></label> : <label><?php echo $dq[1] ?></label>
        <?php  } } ?>
		</pre>	
		</div>

		<div class="pf_body_field"><h3>Langues parlées</h3>
		<pre>
		<?php if (isset($_SESSION["language"])) {
		if (is_string($_SESSION["language"])) {$_SESSION["language"]=json_decode($_SESSION["language"]);}
		 foreach ($_SESSION["language"] as $language) {  ?>
<label> <?php echo $language ?></label> 
        <?php  } } ?>
		</pre>
		</div>


		<div class="pf_body_images"><h3>∮ Images</h3></div>
	</div>
	<div>
	<div class="pf_body_field"><h3>Email</h3><label><?php echo $_SESSION["email"] ?></label></div>
	</div>
</div>
<a href="doctor_editprofile.php"><button type="button">Modifier</button></a>
</form>
	</div>
</div>

<script src="index.js"></script>
</body>
</html>

<?php   }else{

header("Location: patient_index.php");
exit();

}  

?>


