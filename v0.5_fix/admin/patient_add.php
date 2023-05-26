<form action="" method="POST">
<div >
				<label>Nom complet</label>
				<input type="text" name="patient_name" required="">
			</div>
			<div >
				<label>Email</label>
				<input type="email" name="patient_email" required="">
			</div>
			<div>
				<label>Mot passe</label>
				<input type="password" name="patient_password" required="">
			</div>
			<div>
				<label>Numero telephone</label>
				<input type="tel" pattern="([0-9]{9})|([0-9]{10})" name="patient_phone" required="">
			</div>
			<div>
				<label>Date de naissance</label>
				<input class="in_text" type="date" name="patient_bday" required="">
			</div>
			<div>
					<div>
						<input type="radio" id="r_male" name="patient_gender" value="M" required="">
						<label for="r_male">Male</label>
					</div>
					<div>
						<input type="radio" id="r_female" name="patient_gender" value="F" required="">
						<label for="r_female">Female</label>
					</div>
				</div>
                <input  type="submit" name="patient_submit" value="Ajouter">
</form>


<?php
if (isset($_POST["patient_submit"])) {

	$name=$_POST["patient_name"];
	$email=$_POST['patient_email'];
	$password=$_POST['patient_password'];
	$phone=$_POST["patient_phone"];
	$bday=$_POST["patient_bday"];
	@$gender=$_POST["patient_gender"];
	$pf_img = "assets/pfp2.png";


	if ($name && $password && $email && $bday && $phone && $gender && $pf_img){

		$conn = mysqli_connect('localhost', 'root', '', "Client");

		if($conn->connect_error){
			echo "$conn->connect_error";
			die("Connection Failed : ". $conn->connect_error);
		}
			$stmt = $conn->prepare("SELECT patient_email FROM patient WHERE patient_email = ? UNION SELECT doctor_email FROM doctor WHERE doctor_email = ?");
			$stmt->bind_param("ss", $email , $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0 ) {
				$error_message = "Email already exists";
			}else{
			$password_hashed = password_hash($password, PASSWORD_DEFAULT);
			$stmt = $conn->prepare("insert into patient (patient_name, patient_email, patient_password, patient_phone,  patient_bday,  patient_gender, patient_pf_img) values(?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("sssssss", $name, $email, $password_hashed, $phone, $bday, $gender, $pf_img);
			$stmt->execute();
		
			$stmt->close();
			$conn->close();
		  }
		}
	}

?>