<?php

ini_set('display_errors', 1);

$conn = mysqli_connect('localhost', 'root', '', 'Client');

if (isset($_GET['doctor_id']))
{
	$doctor_id = $_GET['doctor_id'];
	$stmt = $conn->prepare( "SELECT * FROM doctor WHERE doctor_id = ?");
	$stmt->bind_param("i",$doctor_id);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc() ;

	$stmt->close();
}

$conn->close();
		
//if (isset($row["doctor_pf_img"])) $_SESSION["pf_img"] = $row["doctor_pf_img"];

?>


<div class="pf" id="pf_<?php echo $doctor_id ?>">
	<div class="pf_header">
		<img src="<?php echo $row['doctor_pf_img'] ?>">
		<div class="pf_header_text">
			<div class="pf_header_text_name"><?php echo $row['doctor_name'] ?></div>
			<div class="pf_header_text_speciality">
				<?php echo $row['speciality'] ?>, 
			</div>
		</div>
	</div>
	<div class="pf_body">
	   <?php if (isset($row["description"])) {  ?>
		<div class="pf_body_field"><h3>Description</h3>
			<pre><?php  echo $row["description"]  ?></pre>
		</div>
		<?php  } ?>
		<div class="pf_body_field"><h3>Numero telephone</h3><?php echo $row['doctor_phone'] ?></div>
		<div class="pf_body_field"><h3>Adresse</h3><?php if (isset($row['doctor_location'])) echo $row['doctor_location'] ?></div>

		<?php if (isset($row['worktime'])){ $worktime = json_decode($row['worktime']); ?>
		<div class="pf_body_field"><h3>Horaires de travail</h3>
		    <pre>
				Dim:<label><?php echo $worktime->Dimmatin ?></label> - <label><?php echo $worktime->Dimsoir ?></label>
				Lun:<label><?php echo $worktime->Lunmatin ?></label> - <label><?php echo $worktime->Lunsoir ?></label>
				Mar:<label><?php echo $worktime->Marmatin ?></label> - <label><?php echo $worktime->Marsoir ?></label>
				Mer:<label><?php echo $worktime->Mermatin ?></label> - <label><?php echo $worktime->Mersoir ?></label>
				Jeu:<label><?php echo $worktime->Jeumatin ?></label> - <label><?php echo $worktime->Jeusoir ?></label>
				Ven:<label><?php echo $worktime->Venmatin ?></label> - <label><?php echo $worktime->Vensoir ?></label>
				Sam:<label><?php echo $worktime->Sammatin ?></label> - <label><?php echo $worktime->Samsoir ?></label>
		    </pre>
		</div>
		<?php }

		if (isset($row["pricing"])) { $row["pricing"]=json_decode($row["pricing"]);  ?>
		<div class="pf_body_field"><h3>Tarifs</h3>
		<pre>
			<?php  foreach ($row["pricing"] as $pricing) { ?>
                <label><?php echo $pricing[0] ?></label> : <label><?php echo $pricing[1] ?></label>
		</pre>
		</div>
		<?php } } 
		
		if (isset($row["dq"])) { $row["dq"]=json_decode($row["dq"]); ?>
		<div class="pf_body_field"><h3>Diplomes & Qualifications</h3>
			<pre>
			<?php  foreach ($row["dq"] as $dq) { ?>
				<label> <?php echo $dq[0] ?></label> : <label><?php echo $dq[1] ?></label>
			</pre>
		</div>
		<?php } } 
		
		if (isset($row["language"])) { $row["language"]=json_decode($row["language"]); ?>
		<div class="pf_body_field"><h3>Langues parlées</h3>
		<?php  foreach ($row["language"] as $language) { ?>
			<label> <?php echo $language ?></label> 
		</div>
		<?php } } ?>
		
		<div class="pf_body_images"><h3>∮ Images</h3></div>
	</div>
</div>