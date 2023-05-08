<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$op = $_GET['op'];
if ($op == 0)	//send appt
{

	//$appt_id = $_GET['appt_id'];
	$patient_id = 15;
	$appt_patient_id = 0;
	$appt_doctor_id = $_GET['appt_doctor_id'];
	$appt_date = $_GET['appt_date'];
	$appt_keep_date = $_GET['appt_keep_date'];
	$appt_motif = $_GET['appt_motif'];


		$conn = mysqli_connect('localhost', 'root', '', 'Client');

		if($conn->connect_error){
			die("Connection Failed : ". $conn->connect_error);
		} else {
			$stmt = $conn->prepare("insert into appt (appt_patient_id, appt_doctor_id, appt_date,  appt_keep_date, appt_motif) values(?, ?, ?, ?, ?)");
			$stmt->bind_param("issss", $appt_patient_id, $appt_doctor_id, $appt_date,  $appt_keep_date, $appt_motif);
			$stmt->execute();
			$stmt->reset();

			$appt_id = mysqli_insert_id($conn);
			$query = "SELECT patient_apptlist FROM patient where patient_id = $patient_id";
			$result = mysqli_query($conn, $query);
			$data = array();
			while ($row = mysqli_fetch_assoc($result)) {
			    $data[] = $row;
			}
			$apptlist = $data[0]['patient_apptlist'];
			if (empty($apptlist))
			{
				$apptlist = json_encode([$appt_id]);
			}
			else
			{
				$apptlist = json_decode($apptlist);
				array_push($apptlist, $appt_id);
				$apptlist = json_encode($apptlist);
			}

			$stmt = $conn->prepare("update patient set patient_apptlist = ? where patient . patient_id = ?");
			$stmt->bind_param("ss", $apptlist, $patient_id);
			$stmt->execute();
			$stmt->close();
			$conn->close();
			exit();
    }
}
else if ($op == 1)	//send appthistory
{
	$conn = mysqli_connect('localhost', 'root', '', 'Client');

	//$appt_patient_id = $_GET['appt_patient_id'];
	$patient_id = 15;

	$query = "SELECT patient_appthistory FROM patient where patient_id = $patient_id";
	$result = mysqli_query($conn, $query);
	$data = array();
	while ($row = mysqli_fetch_assoc($result)) {
	    $data[] = $row;
	}
	$patient_appthistory_data = $data;
	$patient_appthistory_newel = array($_GET['patient_appthistory'], $_GET['appthistory_state']);
	$patient_appthistory = $patient_appthistory_data[0]['patient_appthistory'];
	if (empty($patient_appthistory))
	{
		$patient_appthistory = json_encode([$patient_appthistory_newel]);
	}
	else
	{
		$patient_appthistory = json_decode($patient_appthistory);
		array_push($patient_appthistory, $patient_appthistory_newel);
		$patient_appthistory = json_encode($patient_appthistory);
	}

		if($conn->connect_error){
			die("Connection Failed : ". $conn->connect_error);
		} else {
			$stmt = $conn->prepare("update patient set patient_appthistory = ? where patient . patient_id = ?");
			$stmt->bind_param("si", $patient_appthistory, $patient_id);
			$stmt->execute();
		
			$stmt->close();
			$conn->close();
			exit();
    }
}
if ($op == 3)	//edit appt
{
	$conn = mysqli_connect('localhost', 'root', '', 'Client');

	//$appt_id = $_GET['appt_id'];
	//$appt_patient_id = $_GET['appt_patient_id'];
	$appt_id = $_GET['appt_id'];
	$patient_id = 15;

	$query = "SELECT patient_apptlist FROM patient";
	$result = mysqli_query($conn, $query);
	$data = array();
	while ($row = mysqli_fetch_assoc($result)) {
	    $data[] = $row;
	}
	$apptlist = $data;
	echo json_encode($apptlist[0]['patient_apptlist']);
	$apptlist = json_decode($apptlist[0]['patient_apptlist']);
	for ($i = 0; $i < count($apptlist); $i++)
	{
		if ($apptlist[$i] == $appt_id)
		{
			\array_splice($apptlist, $i, 1);
		}
	}
	$apptlist = json_encode($apptlist);

		if($conn->connect_error){
			die("Connection Failed : ". $conn->connect_error);
		} else {
			$stmt = $conn->prepare("update patient set patient_apptlist = ? where patient . patient_id = ?");
			$stmt->bind_param("si", $apptlist, $patient_id);
			$stmt->execute();
		
			$stmt->close();
			$conn->close();
			exit();
    }
}
?>
			