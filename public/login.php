<?php
session_start();
$error=''; // Variable To Store Error Message
//if (isset($_POST['submit'])) {
if ((is_null($_POST['username'])) or (is_null($_POST['password']))) {
	header("location: participant_login.php");
}
else
{
	include ("header.php");

	// Define $username and $password
	$username=$_POST['username'];
	$password=$_POST['password'];
	// Establishing Connection 
	
	// To protect MySQL injection for Security purpose
	$username = stripslashes($username);
	$password = stripslashes($password);
	$username = mysql_real_escape_string($username);
	$password = md5(mysql_real_escape_string($password));

	$query1 = "SELECT * FROM ".table('participants')." WHERE password='$password' AND identification_number='$username'";
	$result=orsee_query($query1);
	
	
	if (!is_null($result)) {
		$_SESSION['login_user']=$username; // Initializing Session
		header("location: profile.php"); // Redirecting To Other Page
	} else {
	
		header("location: participant_login.php?error=1");
	}
	mysql_close($connection); // Closing Connection
}
//}
?>
