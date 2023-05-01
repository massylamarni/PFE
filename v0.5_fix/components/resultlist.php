<?php
$id = $_GET["id"];
$pf_img = "assets/pfp2.png";
$name = "User Name";
$speciality = '<a href="#">Psychologue, </a><a href="#">Dermatologue</a>';
$location = "75017 Colorado, USA";
$phone = "0752692364";
$brief_date = "Lundi, 31 mars";
$brief_time = "a 15:30";
?>
<div class="list_el">
	<div class="pfp" id="<?php echo $id?>">
		<img src="<?php echo $pf_img ?>">
		<div class="pfp_text">
			<div class="pfp_text_name"><?php echo $name ?></div>
			<div class="pfp_text_id"><?php echo $id ?></div>
			<div class="pfp_text_speciality"><?php echo $speciality ?></div>
		</div>
	</div>
	<div class="list_el_brief">
		<div class="brief_adress"><?php echo $location ?></div>
		<div class="brief_datetime">
			<div class="brief_date"><?php echo $brief_date ?></div>
			<div class="brief_time"><?php echo $brief_time ?></div>
		</div>
		<div class="brief_phone"><?php echo $phone ?></div>
		<div class="brief_book" onclick="bookform(0, this)"><p>Prendre RDV</p></div>
	</div>
</div>