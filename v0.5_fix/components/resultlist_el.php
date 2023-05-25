<?php
ini_set('display_errors', 1);
if (!isset($_SESSION)){ session_start();   }



//doctor

    $stmt = $conn->prepare( "SELECT * FROM doctor WHERE doctor_id = ?");
	$stmt->bind_param("i",$doctor_id);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc() ;
			
$doctor_pf_img = $row['doctor_pf_img'];
$doctor_name = $row['doctor_name'];
$speciality = $row['speciality'];
$doctor_location = $row['doctor_location'];
$doctor_phone = $row['doctor_phone'];
$worktime = $row['worktime'];
if (!$doctor_location) $doctor_location = "Non definis...";
if (!$worktime) $worktime = '[["Non definis...","Non definis..."],["Non definis...","Non definis..."],["Non definis...","Non definis..."],["Non definis...","Non definis..."],["Non definis...","Non definis..."],["Non definis...","Non definis..."],["Non definis...","Non definis..."]]';
?>

<div class="list_el" id="<?php echo $doctor_id?>">
	<div class="pfp">
		<img src="<?php echo $doctor_pf_img ?>">
		<div class="pfp_text">
			<div class="pfp_text_name"><?php echo $doctor_name ?></div>
			<div class="pfp_text_id"><?php echo $doctor_id ?></div>
			<div class="pfp_text_speciality"><?php echo $speciality ?></div>
		</div>
	</div>
	<div class="list_el_brief">
		<div class="brief_adress"><?php echo $doctor_location ?></div>
		<div class="brief_datetime">/</div><!-- Date de prise de RDV disponible la plus proche -->
		<div class="brief_phone"><?php echo $doctor_phone ?></div>
		<?php if (isset($_SESSION["usertype"]) && $_SESSION["usertype"]=='patient') {?> <div class="brief_book" onclick="bookform(0, <?php echo $doctor_id?>)"><p>Prendre RDV</p></div>
	<?php include("components/bookform.php"); } ?>
	</div>
</div>