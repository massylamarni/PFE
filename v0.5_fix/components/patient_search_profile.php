<?php
$id = "£00000";
$name = "User Name";
$email = "dummy@email.com";
$password = "**********";
$phone = "0752692364";
$bday = date("d-m-y");
$gender = "M";
$pf_img = "assets/pfp2.png";
$location = "75017 Colorado, USA";
?>

<h3>Gerer Compte</h3>
<form class="ep_form">
<div class="pf" id="<?php echo $id ?>">
	<div class="pf_header">
		<img src="<?php echo $pf_img ?>">
		<div class="pf_header_text">
			<div class="pf_header_text_name"><textarea rows="1" cols="50"><?php echo $name ?></textarea></div>
			<div class="pf_header_text_id"><?php echo $id ?></div>
		</div>
	</div>
	<div class="pf_body">
		<div class="pf_body_field"><h3>Numero telephone</h3><textarea rows="1" cols="15"><?php echo $phone ?></textarea></div>
		<div class="pf_body_field"><h3>Adresse</h3><textarea rows="1" cols="50"><?php echo $location ?></textarea></div>
		<div class="pf_body_field"><h3>Date Naissance</h3><input type="date"></div>
		<div class="pf_body_field">
			<h3>Genre</h3>
			<div class="in_radio">
				<div>
					<input type="radio" id="r_male" name="gender" value="male">
					<label for="r_male">Male</label>
				</div>
				<div>
					<input type="radio" id="r_female" name="gender" value="female">
					<label for="r_female">Female</label>
				</div>
			</div>
		</div>
	</div>
	<div>
		<div class="pf_body_field">
			<label>Email</label>
			<input class="in_text" type="text">
		</div>
		<div class="pf_body_field">
			<label>Mot Passe</label>
			<input class="in_text" type="text">
		</div>
	</div>
</div>
<input type="submit">
</form>