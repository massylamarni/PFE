
<?php 

if (isset($_GET['patient_id']))
{
	$conn = mysqli_connect('localhost', 'root', '', 'Client');
	$patient_id = $_GET['patient_id'];
	$stmt = $conn->prepare( "SELECT * FROM patient WHERE patient_id = ?");
	$stmt->bind_param("i",$patient_id);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc() ;

	$stmt->close();
	$conn->close();
}
?>

<div class="pf" id="<?php echo $id ?>">
	<div class="pf_header">
		<img src="<?php echo $pf_img ?>">
		<div class="pf_header_text">
			<div class="pf_header_text_name"><?php echo $row['patient_name']?></div>
		</div>
	</div>
	<div class="pf_body">
		<div class="pf_body_field"><h3>Numero telephone</h3><?php echo $row['patient_phone'] ?></div>
		<div class="pf_body_field"><h3>Adresse</h3><?php echo $row['patient_location'] ?></div>
		<div class="pf_body_field"><h3>Date Naissance</h3><?php echo $row['patient_bday'] ?></div>
	</div>
</div>