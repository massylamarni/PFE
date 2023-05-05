<?php
$apt_id = $_GET["apt_id"];
$id = "£00000";
$pf_img = "assets/pfp2.png";
$name = "User Name";
$speciality = '<a href="#">Psychologue, </a><a href="#">Dermatologue</a>';
$apt_date = "Lundi, 31 mars";
$apt_time = "a 15:30";
$apt_date_rem = "Il reste 2j, ";
$apt_time_rem = "12h et 9min";
?>
<div class="list_el" id="<?php echo $apt_id ?>">
	<div class="pfp">
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
			<div class="brief_date"><?php echo $apt_date_rem ?></div>
			<div class="brief_time"><?php echo $apt_time_rem ?></div>
		</div>
		<div class="brief_motif"><p>Motif de consultation</p></div>
		<div class="brief_cancel" id="<?php echo $apt_id?>" onclick="updateaptlist(1, this)"><p>Annuler RDV</p></div>
	</div>
</div>