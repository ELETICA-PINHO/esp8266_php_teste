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


		$update = mysqli_query($conn, "UPDATE led_status SET status = 1 WHERE id = 1;");	
		$update = mysqli_query($conn, "INSERT INTO `logs` (`status`, `exe`, `hora`,`data`) VALUES ('1','cron', '$hora','$data')");


