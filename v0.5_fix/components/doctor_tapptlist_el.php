<?php

ini_set('display_errors', 1);

//get appt data for appt
$stmt = $conn->prepare( "SELECT * FROM tpatient WHERE tpatient_id  = ?");
$stmt->bind_param("i", $tpatient_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
$row = $result->fetch_assoc() ;

$tpatient_appt_date = $row['tpatient_appt_date'];
$tpatient_appt_motif = $row['tpatient_appt_motif'];
$tpatient_id = $row['tpatient_id'];
$tpatient_pf_img = $row['tpatient_pf_img'];
$tpatient_name = $row['tpatient_name'];

//set tpatient_appt_date remaining display
$tpatient_appt_date_obj = new DateTime($tpatient_appt_date);
$date_obj = new DateTime();
$ms_rem = abs($tpatient_appt_date_obj->format('U') * 1000 + $tpatient_appt_date_obj->format('u') - abs($date_obj->format('U') * 1000 + $date_obj->format('u')));
$days_rem = floor($ms_rem / (1000 * 60 * 60 * 24));
$hours_rem = floor(($ms_rem % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
$minutes_rem = floor(($ms_rem % (1000 * 60 * 60)) / (1000 * 60));
$MONTHS = array("?", "Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre");
$DAYS = array("Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam");
?>

<div class="list_el prevent_list_el" id="<?php echo $tpatient_id ?>">
	<div class="pfp">
		<img src="<?php echo $tpatient_pf_img ?>">
		<div class="pfp_text">
			<div class="pfp_text_name"><?php echo $tpatient_name ?></div>
			<div class="pfp_text_id"><?php echo $tpatient_id ?></div>
		</div>
	</div>
	<div class="list_el_brief">
		<div class="brief_datetime"><div class="brief_date"><?php echo $DAYS[$tpatient_appt_date_obj->format('w')] ?>, <?php echo $tpatient_appt_date_obj->format('d') ?> <?php echo $MONTHS[$tpatient_appt_date_obj->format('n')] ?></div><div class="brief_time">a <?php echo $tpatient_appt_date_obj->format('H:i') ?></div></div>
		<div class="brief_datetime"><div class="brief_date">Il reste <?php echo $days_rem ?>j, </div><div class="brief_time"><?php echo $hours_rem ?>h et <?php echo $minutes_rem ?>min</div></div>
		<div class="brief_motif"><p onclick="toggle_motif(1, this)">Motif de consultation</p></div>
		<div class="motif hidden"><?php echo $tpatient_appt_motif ?></div>
		<form class="brief_action" name="pass_<?php echo $tpatient_id?>" method="post" action="doctor_index.php">
			<input type="hidden" name="tpatient_id" value="<?php echo $tpatient_id?>">
			<input type="hidden" name="tpatient_id_state" value="Passé">
			<input type="submit" class="input_button" value="Faire Passer">
		</form>
	</div>
</div>
<?php } ?>