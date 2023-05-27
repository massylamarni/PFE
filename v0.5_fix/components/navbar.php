<div class="navbar">
	<div class="prenav"></div>
	<div class="navbar_toggler" onclick="toggle_navbar(this)"></div>
	<div class="navbar_el_container">

<?php 
if (!isset($_SESSION)){ session_start();}
if (isset($_SESSION["usertype"]))
{
	$pf_img = $_SESSION['pf_img'];
	$name = $_SESSION["name"];
	$logo_url = ($_SESSION["usertype"] == 'doctor') ? 'doctor_index.php' : 'patient_index.php';
	$profile_url = ($_SESSION["usertype"] == 'doctor') ? 'doctor_profile.php' : 'patient_profile.php';	
		
?>
		
		<a href=<?php echo $logo_url ?> class="navbar_logo"><img src="assets/logo.svg" ></a>
		<form id="navbar_search_form" action="resultlist.php" method="POST">
			<input type="text" class="navbar_search_location" placeholder="Emplacement..."name="location">
			<input type="text" class="navbar_search_speciality" placeholder="Specialité..."name="speciality">
			<input type="submit" class="input_button" value="Rechercher">
		</form>	
		<div class="dummy_div"></div>
	</div>
</div>
<div class="navbar_auth">
	<button id="profile" class="navbar_loggedin" onclick="profile()"><img src="<?php echo $pf_img ?>"/><span><?php echo $name ?></span></button>
	<div class="hidden" id="divprofile">
		<a class="logout" href=<?php echo $profile_url ?>> profil </a>
		<a href="components/logout.php"><span class="logout">Logout</span></a>
	</div>
</div>
<?php	
}else{ 
?>
		<a href="index.php" class="navbar_logo"><img src="assets/logo.svg"></a>
		<form id="navbar_search_form" action="resultlist.php" method="POST">
			<input type="text" class="navbar_search_location" placeholder="Emplacement..." name="location">
			<input type="text" class="navbar_search_speciality" placeholder="Specialité..." name="speciality">
			<input type="submit" class="input_button" value="Rechercher">
		</form>
		<div class="dummy_div"></div>
	</div>
</div>
<div class="navbar_auth">
	<a href="login.php" class="input_button">Connexion</a>
	<button class="input_button" onclick="toggle_signup()">Inscription</button>
	<div class="hidden" id="toggle_signup">
		<a href="doctor_signup.php" class="navbar_auth_signup_el">Inscription Medecin</a>
		<a href="patient_signup.php" class="navbar_auth_signup_el">Inscription Patient</a>
	</div>
</div>
<?php
}
?>
