<!DOCTYPE html>
<?php
include "ImageShare.php";
error_reporting(E_ALL);
ini_set('display_errors', 'On');
header('Content-Type: text/html');

session_start(); /* Store session on a cookie */

if (isset($_GET['logout']) and $_GET['logout'] == 1) {
	unset($_POST);
	unset($_GET_);
	unset($_SESSION);
	unset($content1_session);
	session_destroy();
	header("Location: http://web.engr.oregonstate.edu/~rademace/assignment4-part1/src/ImageShareLogin.html", true);
	die();
}
	
if (session_status() == PHP_SESSION_ACTIVE
	and 
	(isset($_POST['username']) and strlen($_POST['username']) != 0)
	or isset($_SESSION['loggedIn'])) {
	
	if (isset($_POST['username']))
		$_SESSION['name'] = $_POST['username'];
	
	if (!isset($_SESSION['loggedIn']))
		$_SESSION['loggedIn'] = true;
	
	$_visits = 'visits_' . $_SESSION['name'];
	
	if (!isset($_SESSION[$_visits]))
		$_SESSION[$_visits] = -1;
	
	$_SESSION[$_visits]++;
	
	$content1_session = array();
	$content1_session = $_SESSION;
	
	echo "Hello $_SESSION[name], you have visited this page $_SESSION[$_visits] times before.  <br>";
	echo "Click <a href='http://web.engr.oregonstate.edu/~rademace/assignment4-part1/src/UserAccountHandler.php?logout=1'>here</a> to logout.<br>";
	
}

else if (!isset($_POST['username'])
	or strlen($_POST['username']) == 0) {
		
	echo 'A username must be entered.<br>
		Click <a href="http://web.engr.oregonstate.edu/~rademace/assignment4-part1/src/ImageShareLogin.php">here</a>
		to return to the login screen.<br>';
}



?>