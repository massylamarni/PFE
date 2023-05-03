<div class="navbar">
	<div class="prenav"></div>
	<div class="navbar_el_container">
	<?php /*
	$current_file_name= basename($_SERVER["PHP_SELF"]);
	if ($current_file_name == "login.php" || $current_file_name == "signup.php" || $current_file_name == "PS_signup.php") {

?>
		<a href="index.php" class="navbar_logo"><img src="assets/logo.png"></a>
<?php 
}else{*/

	
if(!isset($_SESSION))
{
session_start();
}
if(isset($_SESSION["usertype"])) {

	$name = $_SESSION['name'];
	$user_image = "assets/pfp6.png";

		$logo_url = ($_SESSION["usertype"] == 'doctor') ? 'PS_index.php' : 'index.php';
		$edit_profile_url = ($_SESSION["usertype"] == 'doctor') ? 'PS_editprofile.php' : 'editprofile.php';		
		?>

		<a href=<?php echo $logo_url  ?> class="navbar_logo"><img src="assets/logo.png"></a>
		<form id="navbar_search" action="resultlist.php">
			<input type="text" class="navbar_search_location" placeholder="Emplacement...">
			<input type="text" class="navbar_search_speciality" placeholder="Specialité...">
			<input type="submit" class="navbar_search_submit" value="Rechercher">
		</form>	
		<div class="navbar_auth">
	        <a href=<?php echo $edit_profile_url  ?> class="navbar_loggedin"><img src="<?php echo $user_image ?>"/><span><?php echo $name ?></span></a>||<a href="logout.php"><span>Logout</span></a>
        </div>					
</div>
</div>

<?php	
}
else
{ 
?>
         <a href="index.php" class="navbar_logo"><img src="assets/logo.png"></a>
        <form id="navbar_search" action="resultlist.php">
			<input type="text" class="navbar_search_location" placeholder="Emplacement...">
			<input type="text" class="navbar_search_speciality" placeholder="Specialité...">
			<input type="submit" class="navbar_search_submit" value="Rechercher">
		</form>	
<div class="navbar_auth">
    <a href="PS_signup.php" class="navbar_auth_signup">Inscription Medecins</a>
	<a href="login.php" class="navbar_auth_login">Connexion</a>
	<a href="signup.php" class="navbar_auth_signup">Inscription</a>
</div>
</div>
</div>

<?php
}
?>
