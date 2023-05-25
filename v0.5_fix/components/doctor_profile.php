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
	if (!$description) $description = "Non definis...";
	if (!$doctor_location) $doctor_location = "Non definis...";
	if (!$worktime) $worktime = '[["Non definis...","Non definis..."],["Non definis...","Non definis..."],["Non definis...","Non definis..."],["Non definis...","Non definis..."],["Non definis...","Non definis..."],["Non definis...","Non definis..."],["Non definis...","Non definis..."]]';
	if (!$pricing) $pricing = '[["Non definis... ","Non definis..."]]';
	if (!$dq) $dq = '[["Non definis...","Non definis..."]]';
	if (!$language) $language = '["Non definis..."]';
}
?>


<div class="pf" id="pf_<?php echo $doctor_id ?>">
	<div class="pf_header">
		<img src="<?php echo $doctor_pf_img ?>">
		<div class="pf_header_text">
			<div class="pf_header_text_name"><?php echo $doctor_name ?></div>
			<div class="pf_header_text_speciality">
				<?php echo $speciality ?>, 
			</div>
		</div>
	</div>
	<div class="pf_body">
	   <?php if (isset($description)) {  ?>
		<div class="pf_body_field"><h3>Description</h3>
			<pre><?php  echo $description ?></pre>
		</div>
		<?php  } ?>
		<div class="pf_body_field"><h3>Numero telephone</h3><?php echo $doctor_phone ?></div>
		<div class="pf_body_field"><h3>Adresse</h3><?php if (isset($doctor_location)) echo $doctor_location ?></div>

		<div class="pf_body_field"><h3>Horaires de travail</h3>
		<?php if (isset($worktime)){ $worktimes = json_decode($worktime); ?>
		<pre>
				Dim:<label><?php echo $worktimes[0][0] ?></label> - <label><?php echo $worktimes[0][1] ?></label>
				Lun:<label><?php echo $worktimes[1][0] ?></label> - <label><?php echo $worktimes[1][1] ?></label>
				Mar:<label><?php echo $worktimes[2][0] ?></label> - <label><?php echo $worktimes[2][1] ?></label>
				Mer:<label><?php echo $worktimes[3][0] ?></label> - <label><?php echo $worktimes[3][1] ?></label>
				Jeu:<label><?php echo $worktimes[4][0] ?></label> - <label><?php echo $worktimes[4][1] ?></label>
				Ven:<label><?php echo $worktimes[5][0] ?></label> - <label><?php echo $worktimes[5][1] ?></label>
				Sam:<label><?php echo $worktimes[6][0] ?></label> - <label><?php echo $worktimes[6][1] ?></label>
		</pre>
		</div>
		<?php } ?>

		<div class="pf_body_field"><h3>Tarifs</h3>
		<pre>
		<?php 
		if (isset($pricing)) { $pricing=json_decode($pricing);  
			 foreach ($pricing as $Pricing) { ?>
                <label><?php echo $Pricing[0] ?></label> : <label><?php echo $Pricing[1] ?></label>
		</pre>
		</div>
		<?php } } ?>
		<div class="pf_body_field"><h3>Diplomes & Qualifications</h3>
			<pre>
			<?php
		if (isset($dq)) { $dq=json_decode($dq); 
			  foreach ($dq as $Dq) { ?>
				<label> <?php echo $Dq[0] ?></label> : <label><?php echo $Dq[1] ?></label>
			</pre>
		</div>
		<?php } } ?>
		<div class="pf_body_field"><h3>Langues parlées</h3>
		<pre>
		<?php
		if (isset($language)) { $language=json_decode($language); 
		  foreach ($language as $Language) { ?>
			<label> <?php echo $Language ?></label> 
			</pre>
		</div>
		<?php } } ?>
		
		<div class="pf_body_images"><h3>∮ Images</h3></div>
	</div>
</div>