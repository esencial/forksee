<?php
if(isset($_SESSION['login_user'])){

    header("location: profile.php");
}

$error = '';

if ($_GET['error'] == 1) $error = "Username or Password is invalid";
if ($_GET['error'] == 2) $error = "You are banned from the system";

include ("header.php");
?>
<div id="main">
    <div id="login">
        <form action="login.php" method="post">
        <label>Id number:</label>
<input id="username" name="username" placeholder="username" type="text">
<label>Password:</label>
<input id="password" name="password" placeholder="**********" type="password">
<input name="submit" type="submit" value=" Login ">
<a href="participant_forgot_pass.php">¿Olvidó su contraseña?</a>
<br><p>
<a href="participant_create.php?s=1.php">Registrarse en el sistema</a></p>
<span><?php echo $error; ?></span>
</form>
</div>
</div>
</body>
</html>
