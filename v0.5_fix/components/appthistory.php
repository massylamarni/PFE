<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

               
//get appt data for appt
$stmt = $conn->prepare( "SELECT * FROM appt WHERE appt_id  = ?");
$stmt->bind_param("i",$appt_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc() ;

$appt_doctor_id = $row['appt_doctor_id'];
$appt_date = $row['appt_date'];
$appt_keep_date = $row['appt_keep_date'];
$appt_motif = $row['appt_motif'];


//get doctor data for appt
$stmt = $conn->prepare( "SELECT * FROM doctor WHERE doctor_id  = ?");
$stmt->bind_param("i",$appt_doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc() ;

$doctor_id = $row['doctor_id'];
$doctor_pf_img = $row['doctor_pf_img'];
$doctor_name = $row['doctor_name'];
$speciality = $row['speciality'];

//set appt_date display
$appt_date_obj = new DateTime($appt_date);
$appt_keep_date_obj = new DateTime($appt_keep_date);
$MONTHS = array("Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre");
$DAYS = array("Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam");
?>

<div class="list_el" id="<?php echo $appt_id ?>">
	<div class="pfp">
		<img src="<?php echo $doctor_pf_img ?>">
		<div class="pfp_text">
			<div class="pfp_text_name"><?php echo $doctor_name ?></div>
			<div class="pfp_text_id"><?php echo $doctor_id ?></div>
			<div class="pfp_text_speciality"><?php echo $speciality ?></div>
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