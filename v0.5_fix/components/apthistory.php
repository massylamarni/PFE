<?php
$apt_id = $_GET["aptid"];
$id = "£00000";
$pf_img = "assets/pfp2.png";
$name = "User Name";
$speciality = '<a href="#">Psychologue, </a><a href="#">Dermatologue</a>';
$apt_date = "Lundi, 31 mars";
$apt_time = "a 15:30";
$date = "Mardi, 1 Avril";
$time = "a 12:30";
$state = $_GET["state"];
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
		<div class="brief_datetime">
			<div class="brief_date"><?php echo $apt_date ?></div>
			<div class="brief_time"><?php echo $apt_time ?></div>
		</div>
		<div class="brief_datetime">
			<div class="brief_date"><?php echo $date ?></div>
			<div class="brief_time"><?php echo $time ?></div>
		</div>
		<div class="brief_motif"><p>Motif de consultation</p></div>
		<div class="brief_state"><p><?php echo $state ?></p></div>
	</div>
</div>