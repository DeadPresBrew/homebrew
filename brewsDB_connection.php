<?php
$servername = "localhost";
$username = "root";
$password = "beer4a11";
$dbname = "rtravers_brews";

//Create Connection
$connection = new MySQLi($servername, $username, $password, $dbname);

//Check Connection
if($connection->connect_error) {
	die("404 ERROR HERE Connection Failed: " . $connection->connect_error);
}
?>