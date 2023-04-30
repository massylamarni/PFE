

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="index.css">
	<title>Visuals</title>
</head>
<body>

<?php include("components/navbar.php");
if(!isset($_SESSION))
{
session_start();
}
if(isset($_SESSION["usertype"]))  {

	$conn = mysqli_connect('localhost', 'root', '', DB_NAME);

	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} else {
        $email= $_SESSION["email"];
	    $name=$_SESSION["name"];
	    $bday=$_SESSION["bday"];
      $phone=$_SESSION["phone"];
	    $gender=$_SESSION["gender"]; 
		  $pf_img = "assets/pfp2.png";


  // get user input
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $avatar = $_FILES['avatar'];

  // sanitize user input
  $name = filter_var($name, FILTER_SANITIZE_STRING);
  $email = filter_var($email, FILTER_SANITIZE_EMAIL);
  $password = filter_var($password, FILTER_SANITIZE_STRING);

  // validate user input
  $errors = array();

  // check name
  if (empty($name)) {
    $errors[] = "Name is required";
  }

  // check email
  if (empty($email)) {
    $errors[] = "Email is required";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email is invalid";
  }

  // check password
  if (!empty($password)) {
    // hash password
    $password = password_hash($password, PASSWORD_DEFAULT);
  } else {
    // use old password
    $sql = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->bind_result($password);
    $stmt->fetch();
    $stmt->close();
  }

  // check avatar
  if (!empty($avatar['name'])) {
    // get file info
    $filename = basename($avatar['name']);
    $filetype = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $filesize = $avatar['size'];
    $filetmp = $avatar['tmp_name'];

    // check file type
    if ($filetype != "jpg" && $filetype != "png" && $filetype != "gif") {
      $errors[] = "Only JPG, PNG and GIF files are allowed";
    }

    // check file size
    if ($filesize > 500000) {
      $errors[] = "File size must be less than 500 KB";
    }

    // move file to uploads folder
    if (empty($errors)) {
      move_uploaded_file($filetmp, "uploads/" . $filename);
      // set avatar path
      $avatar = "uploads/" . $filename;
    }
  } else {
    // use old avatar
    $sql = "SELECT avatar FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->bind_result($avatar);
    $stmt->fetch();
    $stmt->close();
  }

  // update user profile data
  if (empty($errors)) {
    // prepare sql query
    $sql = "UPDATE users SET name = ?, email = ?, password = ?, avatar = ? WHERE id = ?";

    // create prepared statement
    $stmt = $conn->prepare($sql);

    // bind parameters
    $stmt->bind_param("ssssi", $name, $email, $password, $avatar, $_SESSION['user_id']);

    // execute statement
    if ($stmt->execute()) {
      // update session variables
      $_SESSION['user_name'] = $name;
      $_SESSION['user_email'] = $email;
      $_SESSION['user_avatar'] = $avatar;

      // redirect to profile page
      header("Location: profile.php");
      exit();  }}
    }?>

<div class="std_container">
	<div class="ep_container">
		<?php //include("components/profile_blank.php"); ?>
	</div>
</div>

<h3>Gerer Compte</h3>
<form class="ep_form">
<div class="pf" id="<?php echo $id ?>">
	<div class="pf_header">
		<img src="<?php echo $pf_img ?>">
		<div class="pf_header_text">
			<div class="pf_header_text_name"><textarea rows="1" cols="50"><?php echo $name ?></textarea></div>
			<div class="pf_header_text_id"><?php echo $id ?></div>
		</div>
	</div>
	<div class="pf_body">
		<div class="pf_body_field"><h3>Numero telephone</h3><textarea rows="1" cols="15"><?php echo $phone ?></textarea></div>
		<div class="pf_body_field"><h3>Adresse</h3><textarea rows="1" cols="50"><?php echo $location ?></textarea></div>
		<div class="pf_body_field"><h3>Date Naissance</h3><input type="date"></div>
		<div class="pf_body_field">
			<h3>Genre</h3>
			<div class="in_radio">
				<div>
					<input type="radio" id="r_male" name="gender" value="male">
					<label for="r_male">Male</label>
				</div>
				<div>
					<input type="radio" id="r_female" name="gender" value="female">
					<label for="r_female">Female</label>
				</div>
			</div>
		</div>
	</div>
	<div>
		<div class="pf_body_field">
			<label>Email</label>
			<input class="in_text" type="text">
		</div>
		<div class="pf_body_field">
			<label>Mot Passe</label>
			<input class="in_text" type="text">
		</div>
	</div>
</div>
<input type="submit">
</form>

<script src="index.js"></script>
</body>
</html>