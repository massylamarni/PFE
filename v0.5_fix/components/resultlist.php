<?php
//ini_set('display_errors', 1);

//doctor
$query = "SELECT * FROM doctor WHERE doctor_id = $doctor_id";
$result = mysqli_query($conn, $query);
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
	$data[] = $row;
}
$doctor_pf_img = $data[0]['doctor_pf_img'];
$doctor_name = $data[0]['doctor_name'];
$speciality = $data[0]['speciality'];
$doctor_location = $data[0]['doctor_location'];
$doctor_phone = $data[0]['doctor_phone'];
$worktime = $data[0]['worktime'];
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
		<div class="brief_book" onclick="bookform(0, <?php echo $doctor_id?>)"><p>Prendre RDV</p></div>
	</div>
	<?php include("components/bookform.php"); ?>
</div>