<?php
header('Access-Control-Allow-Origin: *');

require_once "core.inc.php";
require 'connect.inc.php';
error_reporting(E_ALL);
global $connection;

$user_id = $_SESSION['user_id'];


if (isset($_POST['add'])){
	$date = mysqli_real_escape_string($connection, $_POST['date']);
	$sql = "Insert INTO `user_requests` VALUES
			('', 
			'".mysqli_real_escape_string($connection, $_SESSION['user_id'])."', 
			'$date', 
			'Home to Work',
			''
			)";
	if ($sql_run = mysqli_query($connection, $sql)) {
		echo 'DateSaved';
		exit();
	}
}
else if (isset($_POST['remove'])) {
	$date = mysqli_real_escape_string($connection, $_POST['date']);
	$query = "DELETE FROM `user_requests` WHERE `user_id`='".mysqli_real_escape_string($connection, $_SESSION['user_id'])."' AND `date`='".mysqli_real_escape_string($connection, $_POST['date'])."'";
		
	if ($query = mysqli_query($connection, $query)) {
		echo 'Deleted';
		exit();
	}
}


if (isset($_POST['getDates'])) {
	$query = "SELECT * FROM `user_requests` WHERE `user_id`='".mysqli_real_escape_string($connection, $_SESSION['user_id'])."'";
	
	if ($query_run = mysqli_query($connection, $query)) {
		$query_num_rows = mysqli_num_rows($query_run);
 
		if ($query_num_rows > 0) {
		//send details into array and sent to html
			
			$datesArray = array();
			while($rows = mysqli_fetch_array($query_run)) {
				array_push($datesArray, $rows['date']);
			}
			echo json_encode($datesArray); 
		}
	}
}
