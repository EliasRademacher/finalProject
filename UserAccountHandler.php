<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
header('Content-Type: text/html');


function login($message) {
	echo "<a href='http://web.engr.oregonstate.edu/~rademace/ImageShare/UserAccountHandler.php?logout=1'
		>$message</a><br>";
	exit(0);
}

session_start(); /* Store session on a cookie */

if (isset($_GET['logout']) and $_GET['logout'] == 1) {
	unset($_POST);
	unset($_GET_);
	unset($_SESSION);
	unset($content1_session);
	session_destroy();
	header("Location: http://web.engr.oregonstate.edu/~rademace/ImageShare/ImageShareLogin.html", true);
	die();
}

echo '
	<!DOCTYPE html>
	<html>
	 <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<link rel="stylesheet" type="text/css" href="ImageShare.css">
	 </head>
	<body>';

	
	
/* Connect to database */
$mysqli = new mysqli("oniddb.cws.oregonstate.edu",
	"rademace-db", "8xYcLE6mhsNKxGMP", "rademace-db");
if (!$mysqli || $mysqli->connect_errno)
	echo "Connection error: " . $mysqli->connect_errno . " " . $mysqli->connect_error . "<br>";
// else
	// echo "<font color=green>Connected to onid database</font><br>";
	
	
/* Create table if it does not already exist */
$result = $mysqli->query("SHOW TABLES LIKE 'Users'");
if ($result === FALSE)
		echo "Query failed <br>";

else if ($result->num_rows < 1) {
	
	if ($mysqli->query("CREATE TABLE Users(
		id INT PRIMARY KEY AUTO_INCREMENT,
		username VARCHAR(255) UNIQUE,
		password VARCHAR(255)
		)") === TRUE) {
			echo "Table 'Users' created successfully<br>";
		}
		
	else
		echo "failed to create table (" . $mysqli->errno . ") " . $mysqli->error . "<br>"; 
}

	

$loggedIn = FALSE;
	
/* create new user account */	
if (isset($_POST['usernameInit']) 
	AND isset($_POST['passwordInit1'])
	AND isset($_POST['passwordInit2'])) {
		
	
	
	/* Add user to database */
	if(isset($_POST['usernameInit'])) {
			
		if (strlen($_POST['usernameInit']) == 0) {
			echo "<font color=red>username is a required field</font><br>";
			login("Return to login page");
		}
		
		if (!isset($_POST['passwordInit1']) OR strlen($_POST['passwordInit1']) == 0) {
			echo "<font color=red>You must enter a password</font><br>";
			login("Return to login page");
		}
		
		if (!isset($_POST['passwordInit2']) OR strlen($_POST['passwordInit2']) == 0) {
			echo "<font color=red>You must confirm your password</font><br>";
			login("Return to login page");
		}
		
		
		$usernameInit = $_POST['usernameInit'];
		$passwordInit1 = $_POST['passwordInit1'];
		$passwordInit2 = $_POST['passwordInit2'];
		
		if ($passwordInit1 == $passwordInit2) {
			$password = $passwordInit1;
		}
		
		else {
			echo "<font color=red>Passwords do not match.</font><br><br>";
			login("Return to login page");
		}
		
		
		if (!($statement = $mysqli->prepare("INSERT INTO Users(username, password) VALUES
			('$usernameInit', '$password')")))
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error . "<br>";

		if (!$statement->execute()) {
			
			if ($statement->errno == 1062) {
				echo "<font color=red>This username is taken</font><br>";
				login("Return to login page");
			}
		
			else
				echo "Execute failed: (" . $statement->errno . ") " . $statement->error . "<br>";
		}
		
		$statement->close();
		
		echo "<font color=blue>Your account has been created!</font><br>";
			
	}
	
}


/* Is user already logged in? */
else if (isset($_SESSION['loggedIn'])) {
	$loggedIn = TRUE;
	echo "<font color=green class=right-align>Logged in as $_POST[username]</font><br>";
}


/* check username password and log user in */
else if (session_status() == PHP_SESSION_ACTIVE
				AND isset($_POST['username'])
				AND isset($_POST['password'])) {
	
	if (strlen($_POST['username']) == 0) {
		echo "<font color=red>A username must be entered</font><br>";
		login("Return to login page");
	}
	
	if (strlen($_POST['password']) == 0) {
		echo "<font color=red>A password must be entered</font><br>";
		login("Return to login page");
	}
	
	
	/* Check database for username-password pair */
	if (!($statement = $mysqli->prepare("SELECT username, password FROM Users")))
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error . "<br>";

	$statement->bind_param("ss", $username, $password); 
	if (!$statement->execute()) {
		echo "Execute failed: (" . $statement->errno . ") " . $statement->error . "<br>";
	}
	$statement->bind_result($resultUsername, $resultPassword);
	
	while ($statement->fetch()) {
		if ($resultUsername == $_POST['username']) {
			if ($resultPassword == $_POST['password']) {
				$loggedIn = TRUE;
				echo "<font color=green class=right-align>Logged in as $_POST[username]</font><br>";
				break;
			}
			
			else {
				echo "<font color=red>Incorrect password</font><br>";
				login("Return to login page");
			}
		}
	}
	
	if (!$loggedIn) {
		echo "<font color=red>That username was not found in the database</font><br>";
		login("Return to login page");
	}

	$statement->close();
}





	


if ($loggedIn){
	
	$_SESSION['name'] = $_POST['username'];
	$_SESSION['loggedIn'] = true;
	$_visits = 'visits_' . $_SESSION['name'];
	
	if (!isset($_SESSION[$_visits]))
		$_SESSION[$_visits] = -1;
	
	$_SESSION[$_visits]++;
	
	$content1_session = array();
	$content1_session = $_SESSION;
	
	//echo "Hello $_SESSION[name], you have visited this page $_SESSION[$_visits] times before.  <br>";
	echo "<a href='http://web.engr.oregonstate.edu/~rademace/ImageShare/UserAccountHandler.php?logout=1'
		class=right-align>Logout</a><br>";
	
}





include "ImageShare.php";
?>

</body>
</html>