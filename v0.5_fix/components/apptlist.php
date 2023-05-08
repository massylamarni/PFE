<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//appt
$query_appt = "SELECT * FROM appt WHERE appt_id = $appt_id";
$result_appt = mysqli_query($conn, $query_appt);
$appt_data = array();
while ($row = mysqli_fetch_assoc($result_appt)) {
    $appt_data[] = $row;
}
$appt_doctor_id = $appt_data[0]['appt_doctor_id'];
$appt_date = $appt_data[0]['appt_date'];
$appt_motif = $appt_data[0]['appt_motif'];
//doctor
$query_doctor = "SELECT * FROM doctor WHERE doctor_id = '$appt_doctor_id'";
$result_doctor = mysqli_query($conn, $query_doctor);
$doctor_data = array();
while ($row = mysqli_fetch_assoc($result_doctor)) {
    $doctor_data[] = $row;
}
$doctor_id = $doctor_data[0]['doctor_id'];
$doctor_pf_img = $doctor_data[0]['doctor_pf_img'];
$doctor_name = $doctor_data[0]['doctor_name'];
$speciality = $doctor_data[0]['speciality'];

//appt_date_rem
$appt_date_obj = new DateTime($appt_date);
$date_obj = new DateTime();
$ms_rem = abs($appt_date_obj->format('U') * 1000 + $appt_date_obj->format('u') - abs($date_obj->format('U') * 1000 + $date_obj->format('u')));
$days_rem = floor($ms_rem / (1000 * 60 * 60 * 24));
$hours_rem = floor(($ms_rem % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
$minutes_rem = floor(($ms_rem % (1000 * 60 * 60)) / (1000 * 60));
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
		<div class="brief_datetime"><div class="brief_date">Il reste <?php echo $days_rem ?>j, </div><div class="brief_time"><?php echo $hours_rem ?>h et <?php echo $minutes_rem ?>min</div></div>
		<div class="brief_motif"><p>Motif de consultation</p></div>
		<div class="motif hidden"><?php echo $appt_motif ?></div>
		<div class="brief_cancel" id="<?php echo $appt_id?>" onclick="updateapptlist(1, this)"><p>Annuler RDV</p></div>
	</div>
</div>