<?php
$pf_id = "pf6";
$pf_image = "assets/pfp2.png";
$pf_name = "User Name";
$brief_date = "Lundi, 31 mars";
$brief_time = "a 15:30";
$brief_date_rem = "Il reste 2j, ";
$brief_time_rem = "12h et 9min";
?>
<div class="list_el">
	<div class="pfp" id="<?php echo $pf_id?>">
		<img src="<?php echo $pf_image?>">
		<div class="pfp_text">
			<div class="pfp_text_name"><?php echo $pf_name?></div>
		</div>
	</div>
	<div class="list_el_brief">
		<div class="brief_datetime">
			<div class="brief_date"><?php echo $brief_date?></div>
			<div class="brief_time"><?php echo $brief_time?></div>
		</div>
		<div class="brief_datetime">
			<div class="brief_date"><?php echo $brief_date_rem?></div>
			<div class="brief_time"><?php echo $brief_time_rem?></div>
		</div>
		<div class="brief_motif"><p>Motif de consultation</p></div>
		<div class="brief_cancel"><p>Faire passer</p></div>
	</div>
</div>