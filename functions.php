<?php
include_once 'brewsDB_connection.php';

function sec_session_start() {
	$session_name = 'sec_session_id'; //set custom session name
	$secure = 'SECURE';
	
	$httponly = true;
	
	if (ini_set('session.use_only_cookies', 1) === FALSE) {
		header("error.php");
		exit();	
	}
	$cookieParams = session_get_cookie_params();
	session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
	session_name($session_name);
}

function login($email, $password, $connection) {
	//using prepent statement mwans that SQL injection is not possible
	if ($stmt = $connection->prepare("SELECT uid, username, password, salt FROM brewers WHERE email = ? LIMIT 1")) {
		$stmt->bind_params('s', $email); //bind "$email" to parameter.
		$stmt->execute(); //Execute prepared query
		$stmt->store_result();
		
		//get vaiables from result
		$stmt->bind_result($user_id, $username, $db_password, $salt);
		$stmt->fetch();
		
		//hash the password with unique salt
		$password = hash('sha512', $password . $salt);
		if ($stmt->num_rows == 1) {
			//if user exists we check if account locked
			//Send an email to user
			return false;
		} else {
			//check if password matches
			if ($db_password == $password) {
				//correct, get teh user-agent string of user
				$user_browser = $_SERVER['HTTP_USER_AGENT'];
				//XSS protection as value may be printed
				$user_id = preg_replace("/[^0-9]+/", "", $user_id);
				$_SESSION['user_id'] = $user_id;
				//XSS protection as value may be printed
				$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
				$_SESSION['username'] = $username;
				$_SESSION['login_string'] = hash('sha512', $password . $user_browser);
				//login successful
				return true;
			} else {
				// Password is not correct
				$now = time();
				$connection->query("INSERT INTO login_attempts(user_id, time) VALUES ('$user_id', '$now')");
				return false;
			}
		}
	} else {
		// no user exists
		return false;
	}
}

function checkbrute($user_id, $connection) {
	//get timestamp
	$now = time();
	
	//All login attempts are counted
	$valid_attempts = $now - (2 * 60 * 60);
	
	if ($stmt = $connection->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time > '$valid_attempts'")) {
		$stmt->bind_param('i', $user_id);
		
		//execute prepared query
		$stmt->execute();
		$stmt->store_result();
		
		//if mroe than 5 failed attempts
		if ($stmt->num_rows > 5) {
			return true;	
		} else {
			return false;	
		}
	}
}

function login_check ($connection) {
	//check if all session variables are set
	if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
		$user_id = $_SESSION['user_id'];
		$login_string = $_SESSION['login_string'];
		$username = $_SESSION['username'];
		
		//get user-agent string of user
		$user_browser = $_SERVER['HTTP_USER_AGENT'];
		if ($stmt = $connection->prepare("SELECT password FROM members WHERE id = ? LIMIT 1")) {
			$stmt->bind_param('i', $user_id);
			$stmt->execute();
			$stmt->store_result();
			
			if ($stmt->num_rows == 1) {
				//if user exists get variables from result
				$stmt->bind_result($password);
				$stmt->fetch();
				$login_check = hash('sha512', $password . $user_browser);
				
				if ($login_check == $login_string) {
					//logged in
					return true;	
				} else {
					//not logged in
					return false;
				}
			} else {
				// not logged in
				return false;	
			}
		} else {
			//not logged in
			return false;	
		}
	} else {
		//not logged in
		return false;	
	}
}

function esc_url($url) {
	if ('' == $url) {
		return $url;	
	}
	
	$url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
	
	$strip = array('%0d', '%0a', '%0D', '%0A');
	$url = (string) $url;
	
	$count = 1;
	while ($count) {
		$url = str_replace($strip, '', $url, $count);	
	}
	
	$url = str_replace(';//', '://', $url);
	
	$url = htmlentities($url);
	
	$url = str_replace('&amp;', '&#038;', $url);
	$url = str_replace("'", '&#039;', $url);
	
	if ($url[0] !== '/') {
		//only interested in relative links from $_SERVER['PHP_SELF']
		return '';	
	} else {
		return $url;	
	}
}
?>