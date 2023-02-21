<?php
date_default_timezone_set('America/Sao_Paulo');
$data = date('d-m-Y');
$hora = date('H:i:s');

$servername = "localhost";
$dBUsername = "servidor";
$dBPassword = "servidor";
$dBName = "esp32";
$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);
if (!$conn) {
	die("Connection failed: ".mysqli_connect_error());
}



		if (isset($_POST['check_LED_status'])) {
			$led_id = $_POST['check_LED_status'];	
			$sql = "SELECT * FROM led_status WHERE id = '$led_id';";
			$result   = mysqli_query($conn, $sql);
			$row  = mysqli_fetch_assoc($result);
			if($row['status'] == 0){
				echo "LED_is_off";
			}
			else{
				echo "LED_is_on";
			}	
		}	






		if (isset($_POST['toggle_LED'])) {
			$led_id = $_POST['toggle_LED'];	
			$sql = "SELECT * FROM led_status WHERE id = '$led_id';";
			$result   = mysqli_query($conn, $sql);
			$row  = mysqli_fetch_assoc($result);
			if($row['status'] == 0){
				$update = mysqli_query($conn, "UPDATE led_status SET status = 1 WHERE id = 1;");
				$update = mysqli_query($conn, "INSERT INTO `logs` (`status`, `exe`, `hora`,`data`) VALUES ('1','PUL-LIG', '$hora','$data')");
				echo "LED_is_on";
			}
			else{
				$update = mysqli_query($conn, "UPDATE led_status SET status = 0 WHERE id = 1;");
				$update = mysqli_query($conn, "INSERT INTO `logs` (`status`, `exe`, `hora`,`data`) VALUES ('0','PUL-DES', '$hora','$data')");
				echo "LED_is_off";
			}	
		}		


		
				






	

?>