<?php
$servername = "localhost";
$dBUsername = "servidor";
$dBPassword = "servidor";
$dBName = "esp32";
$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);
if (!$conn) {
	die("Connection failed: ".mysqli_connect_error());
}


$esp = $_GET ['led'];


if($esp == "OF"){

    $update = mysqli_query($conn, "UPDATE led_status SET status = 0 WHERE id = 1;");

}


if($esp == "ON"){

    $update = mysqli_query($conn, "UPDATE led_status SET status = 1 WHERE id = 1;");

}



