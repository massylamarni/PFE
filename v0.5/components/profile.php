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

<div class="pf" id="<?php echo $id ?>">
	<div class="pf_header">
		<img src="<?php echo $pf_img ?>">
		<div class="pf_header_text">
			<div class="pf_header_text_name"><?php echo $name ?></div>
			<div class="pf_header_text_id"><?php echo $id ?></div>
		</div>
	</div>
	<div class="pf_body">
		<div class="pf_body_field"><h3>Numero telephone</h3><?php echo $phone ?></div>
		<div class="pf_body_field"><h3>Adresse</h3><?php echo $location ?></div>
		<div class="pf_body_field"><h3>Date Naissance</h3><?php echo $bday ?></div>
	</div>
</div>