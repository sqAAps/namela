<?php
header('Access-Control-Allow-Origin: *');

require_once "core.inc.php";
require 'connect.inc.php';
error_reporting(E_ALL);
global $connection;

$user_id = $_SESSION['user_id'];

if (isset($_POST["user_interface"])){

	$query = "SELECT * FROM `users` WHERE `id`='".mysqli_real_escape_string($connection, $_SESSION['user_id'])."' ";
	if ($query_run = mysqli_query($connection, $query)) {
		$query_num_rows = mysqli_num_rows($query_run);
			
		if ($query_num_rows == 1 ) {
			while($rows = mysqli_fetch_array($query_run)) {
				$firstName = $rows["firstName"];
				$surname = $rows["surname"];
			}	
		}
	}
	
	$query2 = "SELECT * FROM `user_details` WHERE `user_id`='".mysqli_real_escape_string($connection, $_SESSION['user_id'])."'";
	if ($query_run2 = mysqli_query($connection, $query2)) {
		$query_num_rows2 = mysqli_num_rows($query_run2);
			
		if ($query_num_rows2 == 1 ) {
			while($rows = mysqli_fetch_array($query_run2)) {
				$home_address = $rows["home_address"];
				$work_address = $rows["work_address"];
				
				$login = $rows["work_login_time"];
				$logout = $rows["work_logout_time"];
			}	
		}
	}
	?>
	<div id="user_container">
		<div id="profile_name">
			<div id="profile_pictures">
				<img id="profile_img" src="images/profile.png"/>
			</div>
		
			<div id="profile_fullname">
				<p id="fullNames">
					<?php echo $firstName.' '.$surname; ?>
				</p>
				<p id="edit" onclick="edit_info()">
					<img id="edit_img" href="../2.maps.html" src="images/edit-icon.png"/>
					<span id="edit_span">Edit info</span>
				</p>
			</div>
		</div>
				
		<div id="profile_location">
			<div class="user_places">
				<p class="location">
					<img class="location_img" src="images/home.png"/>
					Home
				</p>
				<p class="location_address">
					<?php echo $home_address; ?>
				</p>
			</div>
			
			<div class="user_places">
				<p class="location">
					<img class="location_img" src="images/building.png"/>
					Work
				</p>
				<p class="location_address">
					<?php echo $work_address; ?>
				</p>
			</div>
		</div>
				
		<div id="profile_location">
			<div class="user_places">
				<p class="location">
					<img class="location_img" src="images/in.png"/>
					Check-in
				</p>
				<p class="location_address">
					<?php echo $login; ?>
				</p>
			</div>
			
			<div class="user_places">
				<p class="location">
					<img class="location_img" src="images/out.png"/>
					Check-out
				</p>
				<p class="location_address">
					<?php echo $logout; ?>
				</p>
			</div>
		</div>
	</div>

	<div id="add_date" onclick="add_trip()">
		<img id="add_trip_img" src="images/add_trip.png"/>
		<span id="add_trip">Add Trip</span>
	</div>
	
	<?php
	$query2 = "SELECT * FROM `user_requests` WHERE `user_id`='".mysqli_real_escape_string($connection, $_SESSION['user_id'])."' ORDER BY `date`";
	if ($query_run2 = mysqli_query($connection, $query2)) {
		$query_num_rows2 = mysqli_num_rows($query_run2);
			
		if ($query_num_rows2 > 0 ) {
			while($rows = mysqli_fetch_array($query_run2)) {
				$type = $rows["type"];
				
				$date = $rows["date"];
				$dateArray = explode(".", $date);
				$month = intval($dateArray[1]);
				switch ($month) {
					case 0:
						$month="JAN";
						break;
					case 1:
						$month="FEB";
						break;
					case 2:
						$month="MAR";
						break;
					case 3:
						$month="APR";
						break;
					case 4:
						$month="MAY";
						break;
					case 5:
						$month="JUN";
						break;
					case 6:
						$month="JUL";
						break;
					case 7:
						$month="AUG";
						break;
					case 8:
						$month="SEP";
						break;
					case 9:
						$month="OCT";
						break;
					case 10:
						$month="NOV";
						break;
					case 11:
						$month="DEC";
						break;
					default:
						
						break;
				}
				$day = intval($dateArray[3]);

				//today date
				$today = getdate();
				$d = intval($today['mday']);
    			$m = intval($today['mon'] - 1);
				
				if ($m >= $month && $d <= $day ){
					?>
					<div class="ticket">
						<div class="ticket_details">

							<div>
								<div class="valid">
									<p class="valid_until">Valid on:</p>
									<p class="date">
										<?php echo $day."-".$month."-16"; ?>
									</p>
								</div>
								<div class="triptype">
									<p class="triptype_p">Type:</p>
									<p class="triptype_icon">
										<?php echo $type; ?>
									</p>
								</div>
							</div>

							<div class="arrangements">
								<div class="drivedetails">
									<p class="valid_until">
										<img id="pickupHome" src="images/home.png"/>Pickup:
									</p>
									<p class="date">
										06:30
									</p>
								</div>

								<div class="drivedetails">
									<p class="valid_until">
										<img id="pickupHome" src="images/work.png"/>Pickup:
									</p>
									<p class="date">
										16:30
									</p>
								</div>

								<div class="drivedetails">
									<p class="valid_until">
										Price:
									</p>
									<p class="date">
										R 42.00
									</p>
								</div>
							</div>

						</div>
					</div>
					<?php
				}
			}	
		}
	}
}