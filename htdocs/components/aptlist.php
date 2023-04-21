<?php
$pf_id = "pf2";
$pf_image = "assets/pfp2.png";
$pf_name = "User Name";
$pf_location = "COlorado, USA";
$pf_speciality = '<a href="#">Psychologue, </a><a href="#">Dermatologue</a>';
$brief_date = "Lundi, 31 mars";
$brief_time = "a 15:30";
$brief_date_remaining = "Il reste 2j, ";
$brief_time_remaining = "12h et 9min";
?>
<div class="list_el">
	<div class="pfp" id="<?php echo $pfid?>">
		<img src="<?php echo $pf_image ?>">
		<div class="pfp_text">
			<div class="pfp_text_name"><?php echo $pf_name ?></div>
			<div class="pfp_text_location"><?php echo $pf_location ?></div>
			<div class="pfp_text_speciality"><?php echo $pf_speciality ?></div>
		</div>
	</div>
	<div class="list_el_brief">
		<div class="brief_datetime">
			<div class="brief_date"><?php echo $brief_date ?></div>
			<div class="brief_time"><?php echo $brief_time ?></div>
		</div>
		<div class="brief_datetime">
			<div class="brief_date"><?php echo $brief_date_remaining ?></div>
			<div class="brief_time"><?php echo $brief_time_remaining ?></div>
		</div>
		<div class="brief_motif"><p>Motif de consultation</p></div>
		<div class="brief_cancel"><p>Annuler RDV</p></div>
	</div>
</div>