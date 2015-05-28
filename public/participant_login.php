<?php
//include('login.php'); // Includes Login Script

if(isset($_SESSION['login_user'])){
    header("location: profile.php");
}
$error = '';
if ($_GET['error'] == 1) $error = "Username or Password is invalid";
include ("header.php");

?>
<!DOCTYPE html>
<html>
<head>
<title>Login form for participants</title>
<link rel="stylesheet" href="../style/bootstrap/css/style.css">
</head>
<body>
<div id="main">
<div id="login">
<form action="login.php" method="post">
<label>Id number:</label>
<input id="name" name="username" placeholder="username" type="text">
<label>Password:</label>
<input id="password" name="password" placeholder="**********" type="password">
<input name="submit" type="submit" value=" Login ">
<a href="participant_forgot_pass.php">Forgot your password?</a>
<span><?php echo $error; ?></span>
</form>
</div>
</div>
</body>
</html>
