<form action="" method="POST">
<div class="divnom">
				<label>Nom complet</label>
				<input type="text" name="doctor_name" required="">
			
				<label>Email</label>
				<input type="email" name="doctor_email" required="">
			
				<label>Mot passe</label>
				<input type="password" name="doctor_password" required="">
			
				<label>Numero telephone</label>
				<input type="tel" pattern="([0-9]{9})|([0-9]{10})" name="doctor_phone" required="">
				
				<label id="sp">Specialité</label>
				<input type="text" name="speciality" required=""/>
			     
				
				  <label>Date de naissance</label>
				  <input class="in_text" type="date" name="doctor_bday" required="">
                
					
						<input type="radio" id="r_male" name="doctor_gender" value="M" required="">
						<label for="r_male">Male</label>
					
						<input type="radio" id="r_female" name="doctor_gender" value="F" required="">
						<label for="r_female">Female</label>
					
				</div>
                <button class="ajouter"  type="submit" name="doctor_submit" >Ajouter</button>
</form>


<?php
if (isset($_POST["doctor_submit"])) {


	$name=$_POST["doctor_name"];
	$email=$_POST['doctor_email'];
	$password=$_POST['doctor_password'];
	$phone=$_POST["doctor_phone"];
    $speciality=$_POST["speciality"];
	$bday=$_POST["doctor_bday"];
	@$gender=$_POST["doctor_gender"];
	$pf_img = "assets/pfp2.png";


	if ($name && $password && $email && $bday && $phone && $gender && $speciality && $pf_img){

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
        $stmt = $conn->prepare("insert into doctor (doctor_name, doctor_email, doctor_password, doctor_phone, doctor_bday, doctor_gender, speciality, doctor_pf_img) values(?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $name, $email, $password_hashed, $phone, $bday, $gender, $speciality, $pf_img);
        $stmt->execute();
    
        $stmt->close();
        $conn->close();
      
		  }
		}
	}

?>