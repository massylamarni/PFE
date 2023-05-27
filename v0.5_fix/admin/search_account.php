 <form action="" method="POST">
  <input type="text" name="email_search" placeholder="email" required="">
  <button type="submit" name="account_search">Chercher un Client</button>
</form>


<?php 

 $conn = mysqli_connect('localhost', 'root', '', "Client");

 if($conn->connect_error){
     echo "$conn->connect_error";
     die("Connection Failed : ". $conn->connect_error);}

if (isset($_POST["account_search"])){

    $email=$_POST['email_search'];

        $stmt = $conn->prepare(" SELECT * FROM doctor WHERE doctor_email = ?");
		$stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0 ) {   
            $row = $result->fetch_assoc();	
           ?>
            
            <h3> Compte infromations </h3>
            <div class="compteinformation">
            <img src="<?php echo  "../".$row["doctor_pf_img"] ?>" width="100" height="100"/>
           
            <h4> Nom </p> <label><?php echo $row["doctor_name"] ?></label>
            <h4> speciality </h4>  <label><?php echo $row["speciality"] ?></label>
            <h4> date de naissance </h4>  <label><?php echo $row["doctor_bday"] ?></label>
            <h4> telephone </h4>  <label><?php echo $row["doctor_phone"] ?></label>
            <h4> description </h4>     <label><?php echo $row["description"] ?></label>
            <h4> adresse </h4>     <label><?php echo $row["doctor_location"] ?></label>
            <h4> Status de verification <h4> <?php if ($row["doctor_verified"]== 0){?>
                    <h4> Compte non verifié </h4>                
                    <form  action="" method="POST">
                         <input type="hidden" name ="verification" value="<?php echo $email; ?>"/>
           
            </div>
                         <button type="submit" name="verify">Verifier</button> 
                    </form>                   
<?php   }else{   ?> 
                     <label> Compte  verifié </label>                
                    <form  action="" method="POST">
                         <input type="hidden" name ="inverification" value="<?php echo $email; ?>"/>
                         <button type="submit" name="unverify">Inverifier</button> 
                    </form>
        <?php   }
       
          }else{ 
            $stmt = $conn->prepare(" SELECT * FROM patient WHERE patient_email = ?");
		    $stmt->bind_param("s", $email );
            $stmt->execute();
            $result = $stmt->get_result();

        if ($result->num_rows > 0 ) {   
            $row = $result->fetch_assoc();?>
            <h3> Compte infromations </h3>
            <div class="compteinformation">
            <img src="<?php echo  "../".$row["patient_pf_img"] ?>" width="100" height="100"/> 
            
            <h4> Nom </h4> <label><?php echo $row["patient_name"] ?></label>
            <h4> date de naissance </h4>  <label><?php echo $row["patient_bday"] ?></label>
            <h4> telephone </h4>  <label><?php echo $row["patient_phone"] ?></label>
            <h4> adresse </h4>     <label><?php echo $row["patient_location"] ?></label>
            <h4> Status de verification <h4> <?php if ($row["patient_prevent"]== 0){?>
                    <h5> Compte non Banni </h5>                
                    <form  action="" method="POST">
                         <input type="hidden" name ="prevention" value="<?php echo $email; ?>"/>
            
            </div>
                         <button type="submit" name="prevent">Prevent</button> 
                    </form>                   
<?php   }else{   ?> 
                     <label> Compte  Banni </label>                
                    <form  action="" method="POST">
                         <input type="hidden" name ="Inprevention" value="<?php echo $email; ?>"/>
                         <button type="submit" name="unprevent">Inprevent</button> 
                    </form>
        <?php   }

        }else{   
            $error_message = "Client doesnt exist";
}}}


if (isset($_POST["verify"])){
$a=1;
    $stmt = $conn->prepare("UPDATE doctor SET doctor_verified = ? WHERE doctor_email = ?");
    $stmt->bind_param("is", $a ,  $_POST["verification"]);
    $stmt->execute();      
}
if (isset($_POST["unverify"])){
    $a=0;
        $stmt = $conn->prepare("UPDATE doctor SET doctor_verified = ? WHERE doctor_email = ?");
        $stmt->bind_param("is", $a ,  $_POST["inverification"]);
        $stmt->execute();      
    }
if (isset($_POST["prevent"])){
$a= 1 ;
    $stmt = $conn->prepare("UPDATE patient SET patient_prevent = ? WHERE patient_email = ?");
    $stmt->bind_param("is", $a , $_POST["prevention"]);
    $stmt->execute();      
}
if (isset($_POST["unprevent"])){
$a= 0 ;
    $stmt = $conn->prepare("UPDATE patient SET patient_prevent = ? WHERE patient_email = ?");
    $stmt->bind_param("is", $a , $_POST["Inprevention"]);
    $stmt->execute();      
}


?>