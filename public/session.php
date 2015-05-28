<?php
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
        header('Location: index.php'); // Redirecting To Home Page
    }
    
?>
