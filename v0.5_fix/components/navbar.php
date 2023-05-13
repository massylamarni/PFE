<div class="navbar">
	<div class="prenav"></div>
	<div class="navbar_el_container">

<?php 
if (!isset($_SESSION)){ session_start();   }
if (isset($_SESSION["usertype"])) {

	

	$pf_img = "assets/pfp6.png";
	$logo_url = ($_SESSION["usertype"] == 'doctor') ? 'doctor_index.php' : 'patient_index.php';
	$profile_url = ($_SESSION["usertype"] == 'doctor') ? 'doctor_profile.php' : 'patient_profile.php';	
		
?>

		<a href=<?php echo $logo_url  ?> class="navbar_logo"><img src="assets/logo.png" ></a>
		<form id="navbar_search" action="resultlist.php" method="POST">
			<input type="text" class="navbar_search_location" placeholder="Emplacement..."name="location">
            <a href="gps.php"><img src="assets/maps.png"></a>
			<input type="text" class="navbar_search_speciality" placeholder="Specialité..."name="speciality">
			<input type="submit" class="navbar_search_submit" value="Rechercher">
		</form>	
		<div class="navbar_auth">
	        <a href=<?php echo $profile_url  ?> class="navbar_loggedin"><img src="<?php echo $pf_img ?>"/><span><?php echo $_SESSION["name"] ?></span></a>||<a href="components/logout.php"><span>Logout</span></a>
        </div>					
	</div>
</div>

<?php	
}else{ 
?>

         <a href="patient_index.php" class="navbar_logo"><img src="assets/logo.png"></a>
        <form id="navbar_search" action="resultlist.php" method="POST">
			<input type="text" class="navbar_search_location" placeholder="Emplacement..." name="location">
			<input type="text" class="navbar_search_speciality" placeholder="Specialité..." name="speciality">
			<input type="submit" class="navbar_search_submit" value="Rechercher">
		</form>	
		<div class="navbar_auth">
    		<a href="doctor_signup.php" class="navbar_auth_signup">Inscription Medecins</a>
			<a href="login.php" class="navbar_auth_login">Connexion</a>
			<a href="patient_signup.php" class="navbar_auth_signup">Inscription</a>
		</div>
	</div>
</div>

<?php
}
?>
