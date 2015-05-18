<?php
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
ob_start();
session_start();// Starting Session
// Storing Session
$user_check=$_SESSION['login_user'];
// SQL Query To Fetch Complete Information Of User
$query="SELECT email FROM ".table('participants')." WHERE email='$username'";
$query = orsee_query($query,"");

$row = mysql_fetch_assoc($query);
$login_session =$row['email'];
if(!isset($login_session)){
mysql_close($connection); // Closing Connection
header('Location: index.php'); // Redirecting To Home Page
}
?>