<?php
header('Access-Control-Allow-Origin: *');

require_once "core.inc.php";
require 'connect.inc.php';
error_reporting(E_ALL);
global $connection;


if(isset($_POST["emailcheck"])){
	$email = $_POST['emailcheck'];
    $sql = "SELECT * FROM `users` WHERE `email`='$email'";
    if ($query = mysqli_query($connection, $sql)){
    	$email_check = mysqli_num_rows($query);
	
    	if ($email_check === 1) {
	    	echo '<strong style="color:#009900;font-family: sans-serif;margin-left: 15px;font-size: 15px;">Email is Good</strong>';
	    	exit();
		} else {
			echo '<span style="color: #ff0000;font-family: sans-serif;font-size: 13px;">'.$email.' is registed. Please login</span>';
			exit();
		}
	}
}

if(isset($_POST["n"])){
    // GATHER THE POSTED DATA INTO LOCAL VARIABLES
	$n = preg_replace('#[^a-z0-9]#', '', $_POST['n']);
    $s = preg_replace('#[^a-z0-9]#', '', $_POST['s']);
    $phone = preg_replace('#[^a-z0-9]#i', '', $_POST['p']);
	$e = mysqli_real_escape_string($connection, $_POST['e']);
    $p = $_POST['pass'];
    $p = md5($p);
	$c = $_POST['c'];
	
    // GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	
	
    // -------------------------------------------
    // DUPLICATE DATA CHECKS FOR EMAIL
	$sql = "SELECT `id` FROM `users` WHERE `email`='$e' LIMIT 1";
    $query = mysqli_query($connection, $sql); 
	$e_check = mysqli_num_rows($query);
	
    // FORM DATA ERROR HANDLING
	if($n == "" || $s == "" || $e == "" || $phone == "" ||  $p == ""){
		echo '<span style="color:#ff0000;">The form submission is missing values.</span>';
        exit();
	} else if ($e_check > 0){ 
        echo "That email address is already in the system";
        exit();
	} else {
	// END FORM DATA ERROR HANDLING
	    // Begin Insertion of data into the database

		
        // Add user info into the database table for the main site table
		$sql = "INSERT INTO `users` VALUES 
                    ('', 
                    '$n', 
                    '$s', 
                    '$phone', 
                    '$e', 
                    '$p', 
                    '0', 
                    '$c'
                    )";
		if ($query = mysqli_query($connection, $sql)){
            
			$user_id = mysqli_insert_id($connection);
			$_SESSION['user_id'] = $user_id;
			?>
			<script>
				localStorage.setItem("phoneNumber", "<?php echo $phone;?>");
				localStorage.setItem("password", "<?php echo $p;?>");
			</script> 
			<?php
        // Email the user their activation link
        
            
            
		$to = "$e";							 
		$from = "no-reply@laisa.co.za";
		$subject = 'laisa Account Activation';
		$message = '
        
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="UTF-8">
                <title>yoursitename Message</title>
            </head>
        
            <body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;">
                
                <div style="padding:10px; background:#333; font-size:24px; color:#CCC;">
                    <a href="http://www.yoursitename.com">
                        <img src="http://www.yoursitename.com/images/logo.png" width="36" height="30" alt="yoursitename" style="border:none; float:left;">
                    </a>

                    yoursitename Account Activation
                </div>

                <div style="padding:24px; font-size:17px;">
                    Hello '.$n.',
                    <br />
                    <br />
                    Click the link below to activate your account when ready:
                    <br />
                    <br />

                    <a href="http://www.laisa.com/register/activation.php?id='.$user_id.'&e='.$e.'&p='.$p.'">
                        Click here to activate your account now
                    </a>

                    <br />
                    <br />
                    Login after successful activation using your:
                    <br />
                    * E-mail Address: <b>'.$e.'
                    </b>
                </div>
            </body>
        </html>';
		$headers = "From: $from\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
		//echo '<strong style="color:#009900;">signup_success</strong>';
		echo 'signup_success';
        
		/*if (mail($to, $subject, $message, $headers)){
            echo '<strong style="color:#009900;font-size:16px">Activation email has been sent to '.$e.'</strong>';
        }
        else{
            echo '<strong style="color:#ff0000;"> Activation email could not be sent</strong>';
        }*/

		exit();
	   }
        else {
            echo '<strong style="color:#ff0000;">Signup Failure</strong>';
		exit();
        }
	exit();
}
}
