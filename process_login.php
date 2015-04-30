<?php
include_once 'brewsDB_connection.php';
include_once 'functions.php';

sec_session_start(); //our custom secure way of starting a PHP session

if (isset($_POST['email'], $_POST['p'])) {
	$email = $_POST['email'];
	$password = $_POST['p']; // hashed password
	
	if (login($email, $password, $connection) == true) {
		//login success
		header('index.php');	
	} else {
		//login failed
		header('error.php');	
	}
} else {
	// The correct POST variables were not sent
	echo 'Invaid Request' . $connection->error;
}
?>