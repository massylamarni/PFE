<div class="navbar">
	<div class="prenav"></div>
	<div class="navbar_el_container">
	<?php
if(!isset($_SESSION))
{
session_start();
}
if(isset($_SESSION["usertype"])) {

	$name = $_SESSION['name'];
	$user_image = "assets/pfp6.png";

	if ($_SESSION["usertype"]=='patient'){?>

		<a href="index.php" class="navbar_logo"><img src="assets/logo.png"></a>
		<form id="navbar_search" action="resultlist.php">
			<input type="text" class="navbar_search_location" placeholder="Emplacement...">
			<input type="text" class="navbar_search_speciality" placeholder="Specialité...">
			<input type="submit" class="navbar_search_submit" value="Rechercher">
		</form>	
		<div class="navbar_auth">
	        <a href="editprofile.php" class="navbar_loggedin"><img src="<?php echo $user_image ?>"/><span><?php echo $name ?></span></a>||<a href="logout.php"><span>Logout</span></a>
        </div>

<?php }elseif($_SESSION["usertype"]=='doctor') { ?>

        <a href="PS_index.php" class="navbar_logo"><img src="assets/logo.png"></a>
		<form id="navbar_search" action="resultlist.php">
			<input type="text" class="navbar_search_location" placeholder="Emplacement...">
			<input type="text" class="navbar_search_speciality" placeholder="Specialité...">
			<input type="submit" class="navbar_search_submit" value="Rechercher">
		</form>	
		<div class="navbar_auth">
	        <a href="PS_editprofile.php" class="navbar_loggedin"><img src="<?php echo $user_image ?>"/><span><?php echo $name ?></span></a>||<a href="logout.php"><span>Logout</span></a>
        </div>


<?php } ?> 
					
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
