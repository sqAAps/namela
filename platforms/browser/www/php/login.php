<?php
header('Access-Control-Allow-Origin: *');

require_once "core.inc.php";
require 'connect.inc.php';
error_reporting(E_ALL);
global $connection;

if(isset($_POST["pass"])){
	$identifier = $_POST['p'];
	
	$password = mysqli_real_escape_string($connection, $_POST['pass']);
	$password = md5($password);
	$query = "SELECT * FROM `users` WHERE `phoneNumber`='$identifier' AND `password`='$password'";
	//echo $identifier." ".$password;
	$query_run = mysqli_query($connection, $query);
	if ($query_run = mysqli_query($connection, $query)) {
		$query_num_rows = mysqli_num_rows($query_run);
		
		if($query_num_rows == 0){
			$sql = "SELECT * FROM `users` WHERE `email`='$identifier' AND `password`='$password'";

			if ($sql_run = mysqli_query($connection, $sql)) {
				$sql_num_rows = mysqli_num_rows($sql_run);

				if($sql_num_rows == 0){
					echo '<span style="color: #ff0000;font-family: sans-serif;font-size: 13px;">Wrong Inputs.</span>';
					exit();
				} else if($sql_num_rows == 1){
					$rows = mysqli_fetch_array($sql_run);
					$user_id = $rows['id'];
					$_SESSION['user_id'] = $user_id;
					echo 'Login';
					exit();
				}
			}
			
		} else if ($query_num_rows == 1) {
			$rows = mysqli_fetch_array($query_run);
			$user_id = $rows['id'];
			$_SESSION['user_id'] = $user_id;
			echo 'Login';
			exit();
		}
	}
}

if(isset($_POST["phoneNumber"]) && isset($_POST["password"])){
	$identifier = mysqli_real_escape_string($connection, $_POST['phoneNumber']);
	
	$password = mysqli_real_escape_string($connection, $_POST['password']);
	$password = md5($password);
	
	$query = "SELECT * FROM `users` WHERE `phoneNumber`='$identifier' AND `password`='$password'";
	
	if ($query_run = mysqli_query($connection, $query)) {
		$query_num_rows = mysqli_num_rows($query_run);
		
		if($sql_num_rows == 0){
			exit();
		} else if($sql_num_rows == 1){
			$rows = mysqli_fetch_array($sql_run);
			$user_id = $rows['id'];
			$_SESSION['user_id'] = $user_id;
			echo 'autologin_successful';
			exit();
		}	
	}
}

if(isset($_POST["logout"])){
	require_once '../core.inc.php';
	session_destroy();
	header('Location: ../index.html');
}