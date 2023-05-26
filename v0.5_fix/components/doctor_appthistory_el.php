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
$appt_keep_date = $row['appt_keep_date'];
$appt_motif = $row['appt_motif'];

   
//get patient data for appt
$stmt = $conn->prepare( "SELECT * FROM patient WHERE patient_id  = ?");
$stmt->bind_param("i", $appt_patient_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
$row = $result->fetch_assoc() ;
$patient_id = $row['patient_id'];
$patient_pf_img = $row['patient_pf_img'];
$patient_name = $row['patient_name'];

//set appt_date display
$appt_date_obj = new DateTime($appt_date);
$appt_keep_date_obj = new DateTime($appt_keep_date);
$MONTHS = array("?", "Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre");
$DAYS = array("?", "Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam");
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
		<div class="brief_datetime"><div class="brief_date"><?php echo $DAYS[$appt_keep_date_obj->format('w')] ?>, <?php echo $appt_keep_date_obj->format('d') ?> <?php echo $MONTHS[$appt_keep_date_obj->format('n')] ?></div><div class="brief_time">a <?php echo $appt_keep_date_obj->format('H:i') ?></div></div>
		<div class="brief_motif"><p>Motif de consultation</p></div>
		<div class="motif hidden"><?php echo $appt_motif ?></div>
		<div class="brief_state"><p><?php echo $state ?></p></div>
	</div>
</div>

<?php }  } ?>