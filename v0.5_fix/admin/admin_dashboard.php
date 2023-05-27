<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
</head>
<body>
     <a href="">Logout</a>
    <h1>Paneau Adminestration </h1> 
    
<div class="top-container">
<form action="" method="POST">
 <input type="text" name="username" placeholder="Username" required="" autocomplete="off">
 <input type="password" name="password" placeholder="Password"required=""autocomplete="off">
  <button type="submit">Ajouter Un Moderateur</button>
</form>

<form action="" method="POST">
  <input type="text" name="mod_search" placeholder="Username" required="">
  <button type="submit">Chercher un moderateur</button>
</form>
</div>



<?php 
session_start();
//if (isset($_SESSION["usertype"]) && $_SESSION["usertype"]=="admin" ){ 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	 isset($_POST["username"]) ? $username=$_POST["username"]: $username=null;
	 isset($_POST["password"])? $password=$_POST['password']: $password=null;
     isset($_POST["mod_search"]) ? $search=$_POST['mod_search']: $search=null;

    $conn = mysqli_connect('localhost', 'root', '', "Admin");

    if($conn->connect_error){
        echo "$conn->connect_error";
        die("Connection Failed : ". $conn->connect_error);
    } 

    if ($username &&  $password ){

            $stmt = $conn->prepare("SELECT mod_username FROM moderateur WHERE mod_username = ? ");
			$stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0 ) {
				$error_message = "username already exists";
			}else{

			$password_hashed = password_hash($password, PASSWORD_DEFAULT);
            for ($i = 0; $i < 9 ; $i++){ 
                
            $password_hashed = password_hash($password_hashed, PASSWORD_DEFAULT);  }

			$stmt = $conn->prepare("insert into moderateur (mod_username, mod_password) values(?,?)");
			$stmt->bind_param("ss", $username, $password_hashed);
			$stmt->execute();
		
        }
    }

    if ($search){

        $stmt = $conn->prepare("SELECT * FROM moderateur WHERE mod_username = ?");
        $stmt->bind_param("s", $search);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {

        $row = $result->fetch_assoc();?>
        <div class="top-container">
            <div class="mod">
        <p> mod ID :</p> <?php echo $row["mod_id"]; ?> <p> mod username :</p> <?php echo $row["mod_username"]; ?>
        <br><br> 
    <form  action="" method="POST">
        <input type="hidden" name ="deleted_mod" value="<?php echo $row["mod_id"]; ?>"/>
        </div>
        <button class="delete" type="submit" name="delete">Delete</button> 
        
        </div>
    </form>
        
<?php 


}}}

    if (isset($_POST["delete"])){

        $stmt = $conn->prepare("DELETE FROM moderateur WHERE mod_id = ?");
        $stmt->bind_param("i", $_POST["deleted_mod"]);
        $stmt->execute();      
}?>

<div class="bottom-container">
<h3>Patient Ajout </h3>
<?php include("patient_add.php");?> </div>

<br><br>
<div class="bottom-container">
<h3>Doctor Ajout </h3><br><br>
<?php include("doctor_add.php");?></div>
<br><br>
<div class="search-container">
<h3>recherche de compte </h3>
<?php include("search_account.php");?>
</div>


</body>
</html>

