<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();// Starting Session
include ("../config/settings.php");
include ("../config/system.php");
include ("../config/requires.php");

// Storing Session
if (isset($_SESSION['login_user'])){
	$user_check=$_SESSION['login_user'];
	
}else{
	header('Location: login.php');
    exit();
} 
    // SQL Query To Fetch Complete Information Of User
    $query="SELECT identification_number FROM ".table('participants')." WHERE identification_number='$user_check'";
    $result = orsee_query($query);

    if (!is_null($result)) {
        mysql_close($connection); // Closing Connection
        header('Location: index.php'); // Redirecting To Home Page
    }
    
?>
