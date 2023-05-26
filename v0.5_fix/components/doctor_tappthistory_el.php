<?php

ini_set('display_errors', 1);
              
//get appt data for appt
$stmt = $conn->prepare( "SELECT * FROM tpatient WHERE tpatient_id  = ?");
$stmt->bind_param("i", $tpatient_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
$row = $result->fetch_assoc() ;

$tpatient_name = $row['tpatient_name'];
$tpatient_appt_date = $row['tpatient_appt_date'];
$tpatient_appt_keep_date = $row['tpatient_appt_keep_date'];
$tpatient_appt_motif = $row['tpatient_appt_motif'];
$tpatient_pf_img = $row['tpatient_pf_img'];

//set appt_date display
$tpatient_appt_date_obj = new DateTime($tpatient_appt_date);
$tpatient_appt_keep_date_obj = new DateTime($tpatient_appt_keep_date);
$MONTHS = array("?", "Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre");
$DAYS = array("?", "Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam");
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
		<div class="brief_datetime"><div class="brief_date"><?php echo $DAYS[$tpatient_appt_keep_date_obj->format('w')] ?>, <?php echo $tpatient_appt_keep_date_obj->format('d') ?> <?php echo $MONTHS[$tpatient_appt_keep_date_obj->format('n')] ?></div><div class="brief_time">a <?php echo $tpatient_appt_keep_date_obj->format('H:i') ?></div></div>
		<div class="brief_motif"><p>Motif de consultation</p></div>
		<div class="motif hidden"><?php echo $tpatient_appt_motif ?></div>
		<div class="brief_state"><p><?php echo $state ?></p></div>
	</div>
</div>

<?php } ?>