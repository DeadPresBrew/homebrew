<?php
include_once 'brewsDB_connection.php';

$error_msg = "";

if (isset($_POST['email'], $_POST['username'], $_POST['p'])) {
	//sanitize and validate data
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
	$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		//not a valid email
		$error_msg .= '<p>The email address is not valid</p>';	
	}
	
	$password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRONG);
	if (strlen($password) != 128) {
		//The hashed password should be 128 long
		//If not something weird happened
		$error_msg .= '<p>Invalid password config</p>';
	}
	
	//username and password validity have been checked
	
	$prep_stmt = "SELECT uid FROM brewers WHERE email = ? LIMIT 1";
	$stmt = $connection->prepare($prep_stmt);
	
	//check existing email
	if ($stmt) {
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->store_result();
		
		if ($stmt->num_rows == 1) {
			//a user with this email already exists
			$error_msg .= '<p>A user with this email already exists</p>';
			$stmt->close();
		}
		$stmt->close();
	} else {
		$error_msg .= '<p>Database error Line 39</p>';
		$stmt->close();
	}
	
	//check username
	$prep_stmt = "SELECT uid FROM brewers WHERE username = ? LIMIT 1";
	$stmt = $connection->prepare($prep_stmt);
	
	if ($stmt) {
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$stmt->store_result();
		
		if ($stmt->num_rows == 1) {
			//A user witht his username already exists
			$error_msg .= '<p>A user with this username already exists</p>';
			$stmt->close();
		}
		$stmt->close();
	} else {
		$error_msg .= '<p>Database error line 55</p>';
		$stmt->close();
	}
	
	//Also account for users who dont have rights to registration
	
	if(empty($error_msg)) {
		//Create salt
		//$random_salt = hash('sha512', openssl_random_pseudo_bytes(16), TRUE)); //did not work
		$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
		
		//create salted password
		$password = hash('sha512', $password . $random_salt);
		
		//Insert the new user into the database
		if ($insert_stmt = $connection->prepare("INSERT INTO brewers (username, email, password, salt) VALUES (?, ?, ?, ?)")) {
			$insert_stmt->bind_param('ssss', $username, $email, $password, $random_salt);
			//execute the query
			if (! $insert_stmt->execute()) {
				header('error.php');
			}
		}
		header('index.php');
	}
}