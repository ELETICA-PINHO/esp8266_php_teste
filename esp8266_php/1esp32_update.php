<?php
$servername = "localhost";
$dBUsername = "servidor";
$dBPassword = "servidor";
$dBName = "esp32";
$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);
if (!$conn) {
	die("Connection failed: ".mysqli_connect_error());
}

//Read the database
if (isset($_POST['check_led_status'])) {
	$led_id = $_POST['check_led_status'];	
	$sql = "SELECT * FROM led_status WHERE id = '$led_id';";
	$result   = mysqli_query($conn, $sql);
	$row  = mysqli_fetch_assoc($result);
	if($row['status'] == 0){
		echo "led_is_off";
	}
	else{
		echo "led_is_on";
	}	
}	

//Update the database
if (isset($_POST['toggle_LED'])) {
	$led_id = $_POST['toggle_LED'];	
	$sql = "SELECT * FROM led_status WHERE id = '$led_id';";
	$result   = mysqli_query($conn, $sql);
	$row  = mysqli_fetch_assoc($result);
	if($row['status'] == 0){
		$update = mysqli_query($conn, "UPDATE led_status SET status = 1 WHERE id = 1;");
		echo "led_is_on";
	}
	else{
		$update = mysqli_query($conn, "UPDATE led_status SET status = 0 WHERE id = 1;");
		echo "led_is_off";
	}	
}	
?>