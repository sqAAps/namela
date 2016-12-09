<?php
header('Access-Control-Allow-Origin: *');

require_once "core.inc.php";
require 'connect.inc.php';
error_reporting(E_ALL);
global $connection;

$code = mysqli_real_escape_string($connection, $_POST['Confcode']);

$query = "SELECT `code` FROM `users` WHERE `id`='".mysqli_real_escape_string($connection, $_SESSION['user_id'])."'";

if ($query_run = mysqli_query($connection, $query)) {
	$query_num_rows = mysqli_num_rows($query_run);
            
	if($query_num_rows==0){
		echo '<span style="color: #ff0000;font-family: sans-serif;font-size: 13px;">LOGOUT PLEASE</span>';
		exit();
	} 
	else if ($query_num_rows==1) {
		$rows = mysqli_fetch_array($query_run);
        $serverCode = $rows['code'];
		
		if ($code == $serverCode){
			
			$sql = "UPDATE `users` SET `validated`='1' WHERE `id`='".mysqli_real_escape_string($connection, $_SESSION['user_id'])."'";
		
			if (mysqli_query($connection, $sql)) {
				echo 'Activated';
				exit();
			}else{
				echo '<span style="color: #ff0000;font-family: sans-serif;font-size: 14px;"> Could not Activate </span>';
				exit();
			}
		} else{
			echo '<span style="color: #ff0000;font-family: sans-serif;font-size: 14px;">Wrong Code</span>';
			exit();
		}
	}
}