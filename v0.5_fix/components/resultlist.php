<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$doctor_id = $_GET['doctor_id'];

//doctor
$query_doctor = "SELECT * FROM doctor WHERE doctor_id = $doctor_id";
$result_doctor = mysqli_query($conn, $query_doctor);
$doctor_data = array();
while ($row = mysqli_fetch_assoc($result_doctor)) {
    $doctor_data[] = $row;
}
$doctor_pf_img = $doctor_data[0]['doctor_pf_img'];
$doctor_name = $doctor_data[0]['doctor_name'];
$speciality = $doctor_data[0]['speciality'];
$doctor_location = $doctor_data[0]['doctor_location'];
$doctor_phone = $doctor_data[0]['doctor_phone'];
$worktime = $doctor_data[0]['worktime'];
?>

<div class="list_el">
	<div class="pfp" id="<?php echo $doctor_id?>">
		<img src="<?php echo $doctor_pf_img ?>">
		<div class="pfp_text">
			<div class="pfp_text_name"><?php echo $doctor_name ?></div>
			<div class="pfp_text_id"><?php echo $doctor_id ?></div>
			<div class="pfp_text_speciality"><?php echo $speciality ?></div>
		</div>
	</div>
	<div class="list_el_brief">
		<div class="brief_adress"><?php echo $doctor_location ?></div>
		<div class="brief_datetime"></div>
		<div class="brief_phone"><?php echo $doctor_phone ?></div>
		<div class="brief_book" id="<?php echo $doctor_id?>" onclick="bookform(0, this)"><p>Prendre RDV</p></div>
	</div>
</div>