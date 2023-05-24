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
}

		
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

		<div class="pf_body_field"><h3>Horaires de travail</h3>
		<?php if (isset($row['worktime'])){ $worktimes = json_decode($row['worktime']); ?>
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
		if (isset($row["pricing"])) { $row["pricing"]=json_decode($row["pricing"]);  
			 foreach ($row["pricing"] as $pricing) { ?>
                <label><?php echo $pricing[0] ?></label> : <label><?php echo $pricing[1] ?></label>
		</pre>
		</div>
		<?php } } ?>
		<div class="pf_body_field"><h3>Diplomes & Qualifications</h3>
			<pre>
			<?php
		if (isset($row["dq"])) { $row["dq"]=json_decode($row["dq"]); 
			  foreach ($row["dq"] as $dq) { ?>
				<label> <?php echo $dq[0] ?></label> : <label><?php echo $dq[1] ?></label>
			</pre>
		</div>
		<?php } } ?>
		<div class="pf_body_field"><h3>Langues parlées</h3>
		<pre>
		<?php
		if (isset($row["language"])) { $row["language"]=json_decode($row["language"]); 
		  foreach ($row["language"] as $language) { ?>
			<label> <?php echo $language ?></label> 
			</pre>
		</div>
		<?php } } ?>
		
		<div class="pf_body_images"><h3>∮ Images</h3></div>
	</div>
</div>