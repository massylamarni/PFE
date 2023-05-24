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
<?php 
if(!isset($_SESSION)){session_start();}

if(isset($_SESSION["usertype"]) && $_SESSION["usertype"]=='doctor'){

	header("Location: doctor_index.php");
	exit();
	
	}elseif(isset($_SESSION["usertype"]) && $_SESSION["usertype"]=='patient'){
	
	  header("Location: patient_index.php");
	  exit();
	}  

include("components/navbar.php"); ?>

<div class="std_containerI">
    <h1>BLANK</h1>
</div>
<script src="index.js"></script>
</body>
</html>