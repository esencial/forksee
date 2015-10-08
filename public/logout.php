<?php
ob_start();
$error=''; // Variable To Store Error Message
//if (isset($_POST['submit'])) {
include_once ("header.php");
include_once ('session.php');
unset($_SESSION['login_user']);
	
header("location: participant_login.php?error=1");
?>
