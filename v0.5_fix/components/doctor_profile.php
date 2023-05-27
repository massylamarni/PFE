<?php

ini_set('display_errors', 1);

if (isset($_GET['doctor_id']))
{
	$conn = mysqli_connect('localhost', 'root', '', 'Client');
	$doctor_id = $_GET['doctor_id'];
	$stmt = $conn->prepare( "SELECT * FROM doctor WHERE doctor_id = ?");
	$stmt->bind_param("i",$doctor_id);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc() ;

	$stmt->close();
	$conn->close();

	$doctor_id = $row['doctor_id'];
	$doctor_pf_img = $row['doctor_pf_img'];
	$doctor_name = $row['doctor_name'];
	$speciality = $row['speciality'];
	$doctor_phone = $row['doctor_phone'];
	$description = $row['description'];
	$doctor_location = $row['doctor_location'];
	$worktime = $row['worktime'];
	$pricing = $row['pricing'];
	$dq = $row['dq'];
	$language = $row['language'];
	if ((empty($description)) || ($description == '[]')) $description = "Non definis...";
	if ((empty($doctor_location)) || ($doctor_location == '[]')) $doctor_location = "Non definis...";
	if ((empty($worktime)) || ($worktime == '[]')) $worktime = '[["Non definis...","Non definis..."],["Non definis...","Non definis..."],["Non definis...","Non definis..."],["Non definis...","Non definis..."],["Non definis...","Non definis..."],["Non definis...","Non definis..."],["Non definis...","Non definis..."]]';
	$worktime_decoded = json_decode($worktime);
	if ((empty($pricing)) || ($pricing == '[]')) $pricing = '[["Non definis... ","Non definis..."]]';
	$pricing_decoded = json_decode($pricing);
	if ((empty($dq)) || ($dq == '[]')) $dq = '[["Non definis...","Non definis..."]]';
	$dq_decoded = json_decode($dq);
	if ((empty($language)) || ($language == '[]')) $language = '["Non definis..."]';
	$language_decoded = json_decode($language); 
}
?>


<div class="pf" id="pf_<?php echo $doctor_id ?>">
	<div class="pf_header">
		<img src="<?php echo $doctor_pf_img ?>">
		<div class="pf_header_text">
			<div class="pf_header_text_name"><p><?php echo $doctor_name ?></p></div>
			<div class="pf_header_text_speciality"><p><?php echo $speciality ?></p></div>
		</div>
	</div>
	<div class="pf_body">
		<div class="pf_body_field"><h3>Description</h3><p><?php  echo $description ?></p></div>
		<div class="pf_body_field"><h3>Numero telephone</h3><p><?php echo $doctor_phone ?></p></div>
		<div class="pf_body_field"><h3>Adresse</h3><p><?php echo $doctor_location ?></p></div>
		<div class="pf_body_field"><h3>Horaires de travail</h3>
			<?php
			$DAYS = array("Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam");
			for ($i = 0; $i < 7; $i++) { ?>
			<p><?php echo $DAYS[$i] ?> : <?php echo $worktime_decoded[$i][0] ?> - <?php echo $worktime_decoded[$i][1] ?></p>
			<?php } ?>
		</div>
		<div class="pf_body_field"><h3>Tarifs</h3>
			<?php foreach ($pricing_decoded as $i) { ?>
			<p><?php echo $i[0] ?> :&emsp;&emsp;&emsp; <?php echo $i[1] ?></p>
			<?php } ?>
		</div>
		<div class="pf_body_field"><h3>Diplomes & Qualifications</h3>
			<?php foreach ($dq_decoded as $i) { ?>
			<p><?php echo $i[0] ?> :&emsp;&emsp;&emsp; <?php echo $i[1] ?></p>
			<?php } ?>
		</div>
		<div class="pf_body_field"><h3>Langues parlées</h3>
			<?php foreach ($language_decoded as $i) { ?>
			<p><?php echo $i ?></p>
			<?php } ?>
		</div>
	</div>
</div>