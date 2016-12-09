<?php
header('Access-Control-Allow-Origin: *');

require_once "core.inc.php";
require 'connect.inc.php';
error_reporting(E_ALL);
global $connection;

if(isset($_POST["home_address"])){
    // GATHER THE POSTED DATA INTO LOCAL VARIABLES
	$home_address = $_POST['home_address'];
    $work_address = $_POST['work_address'];
	
    $work_checkIn = mysqli_real_escape_string($connection, $_POST['work_checkIn']);
	$work_checkOut = mysqli_real_escape_string($connection, $_POST['work_checkOut']);

    // FORM DATA ERROR HANDLING
	if($home_address == "" || $work_address == "" || $work_checkIn == "" || $work_checkOut == "" ){
		echo "The form submission is missing values.";
        exit();
	} else {
		$query = "SELECT * FROM `user_details` WHERE `user_id`='".mysqli_real_escape_string($connection, $_SESSION['user_id'])."' ";
		
		if ($query_run = mysqli_query($connection, $query)) {
            $query_num_rows = mysqli_num_rows($query_run);
		
			if($query_num_rows==0){
				$user_id = $_SESSION['user_id'];
				$sql = "INSERT INTO `user_details` VALUES 
							('',
							'$user_id',
							'$home_address', 
							'$work_address', 
							'$work_checkIn', 
							'$work_checkOut'
							)";
			} else{
				$user_id = $_SESSION['user_id'];
				$sql = "UPDATE `user_details` SET 
							`home_address`='$home_address', 
							`work_address`='$work_address', 
							`work_login_time`='$work_checkIn', 
							`work_logout_time`='$work_checkOut'
						WHERE user_id='".mysqli_real_escape_string($connection, $_SESSION['user_id'])."'
							";
			}
			if ($query = mysqli_query($connection, $sql)){
				echo 'Success';
				exit();
        	}
        	else{
            	echo '<strong style="color:#ff0000;">Opps! Something went wrong, please try sending again.</strong>';
				exit();
        	}
		}
		else{
			echo '<strong style="color:#ff0000;">Could not run query</strong>';
			exit();
        }
	}
}
