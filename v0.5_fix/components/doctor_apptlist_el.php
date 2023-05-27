<?php

ini_set('display_errors', 1);

//get appt data for appt
$stmt = $conn->prepare( "SELECT * FROM appt WHERE appt_id  = ?");
$stmt->bind_param("i",$appt_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
$row = $result->fetch_assoc() ;

$appt_patient_id = $row['appt_patient_id'];
$appt_date = $row['appt_date'];
$appt_motif = $row['appt_motif'];

//get patient data for appt
$stmt = $conn->prepare( "SELECT * FROM patient WHERE patient_id  = ?");
$stmt->bind_param("i",$appt_patient_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
$row = $result->fetch_assoc() ;

$patient_id = $row['patient_id'];
$patient_pf_img = $row['patient_pf_img'];
$patient_name = $row['patient_name'];

//set appt_date remaining display
$appt_date_obj = new DateTime($appt_date);
$date_obj = new DateTime(null);
$date_rem = $appt_date_obj->diff($date_obj);
$days_rem = $date_rem->d;
$hours_rem = $date_rem->h;
$minutes_rem = $date_rem->i;
$MONTHS = array("?", "Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre");
$DAYS = array("Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam");
?>

<div class="list_el prevent_list_el" id="<?php echo $appt_id ?>">
	<div class="pfp">
		<img src="<?php echo $patient_pf_img ?>">
		<div class="pfp_text">
			<div class="pfp_text_name"><?php echo $patient_name ?></div>
			<div class="pfp_text_id"><?php echo $patient_id ?></div>
		</div>
	</div>
	<div class="list_el_brief">
		<div class="brief_datetime"><div class="brief_date"><?php echo $DAYS[$appt_date_obj->format('w')] ?>, <?php echo $appt_date_obj->format('d') ?> <?php echo $MONTHS[$appt_date_obj->format('n')] ?></div><div class="brief_time">a <?php echo $appt_date_obj->format('H:i') ?></div></div>
		<div class="brief_datetime"><div class="brief_date">Il reste <?php echo $days_rem ?>j, </div><div class="brief_time"><?php echo $hours_rem ?>h et <?php echo $minutes_rem ?>min</div></div>
		<div class="brief_motif"><p>Motif de consultation</p></div>
		<div class="motif hidden"><?php echo $appt_motif ?></div>
		<form class="brief_action" name="pass_<?php echo $appt_id?>" method="post" action="doctor_index.php">
			<input type="hidden" name="appt_id" value="<?php echo $appt_id?>">
			<input type="hidden" name="appt_id_state" value="Passé">
			<input type="submit" value="Faire Passer">
		</form>
	</div>
</div>
<?php }} ?>