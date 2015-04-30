<?php
$servername = "localhost";
$username = "root";
$password = "beer4all";
$dbname = "rtravers_brews";

define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "brewer");

define("SECURE", FALSE);

//Create Connection
$connection = new MySQLi($servername, $username, $password, $dbname);

//Check Connection
if($connection->connect_error) {
	die("404 ERROR HERE Connection Failed: " . $connection->connect_error);
}
?>
