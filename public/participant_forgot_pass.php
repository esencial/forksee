<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
        
error_reporting(E_ALL ^ E_NOTICE);		
ini_set('display_errors', 1);    
        
include ("header.php");
include("assets/functions.php");


       
        ob_start();
    
        $show = 'emailForm'; //which form step to show by default
        
        echo 'subStep: '.$_POST['subStep'];
        
        if (isset($_POST['subStep']) &&!isset($_GET['a']) && $_SESSION['lockout'] != true)
            {
            switch($_POST['subStep'])
            {
        case 1:
        //we just submitted an email or username for verification
            echo 'caso1';
            $result = checkUNEmail($_POST['idnumber']);
            if ($result['status'] == false )
            {
                $error = true;
                $show = 'userNotFound';
            } else {
                $error = false;
                //$show = 'securityForm';
                $show = 'successPage';                
                $securityUser = $result['userID'];
            }
        break;
        case 2:
            echo 'caso2: pregunta de seguridad (descartado)';/*
            //we just submitted the security question for verification
            if ($_POST['userID'] != "" && $_POST['answer'] != "")
            {
            $result = checkSecAnswer($_POST['userID'], $_POST['answer']);
            if ($result == true)
            {
            //answer was right
            $error = false;
            $show = 'successPage';
            $passwordMessage = sendPasswordEmail($_POST['userID']);
            $_SESSION['badCount'] = 0;
            } else {
            //answer was wrong
            $error = true;
            $show = 'securityForm';
            $securityUser = $_POST['userID'];
            $_SESSION['badCount'] ++;
            }
            } else {
            $error = true;
            $show = 'securityForm';
            } */
        break;
        case 3:
            //we are submitting a new password (only for encrypted)
            echo 'caso3';
            if ($_POST['userID'] == '' || $_POST['key'] == '') header("location: login.php");
            if (strcmp($_POST['pw0'], $_POST['pw1']) != 0 || trim($_POST['pw0']) == '')
            {
            $error = true;
            $show = 'recoverForm';
            } else {
            $error = false;
            $show = 'recoverSuccess';
            updateUserPassword($_POST['userID'], $_POST['pw0'], $_POST['key']);
            }
        break;
            }            
        }
        elseif (isset($_GET['a']) && $_GET['a'] == 'recover' && $_GET['email'] != "") {
            echo 'entra por el elseif';
            $show = 'invalidKey';
            $result = checkEmailKey($_GET['email'],urldecode(base64_decode($_GET['u'])));
            if ($result == false)
            {
                $error = true;
                $show = 'invalidKey';
            } elseif ($result['status'] == true) {
                $error = false;
                $show = 'recoverForm';
                $securityUser = $result['userID'];
            }
        }
        if ($_SESSION['badCount'] >= 3)
        {
            $show = 'speedLimit';
            $_SESSION['lockout'] = true;
            $_SESSION['lastTime'] = '' ? mktime() : $_SESSION['lastTime'];
        }
    
          
        ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Password Recovery</title>
<link href="assets/css/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="header"></div>
<div id="page">
<?php switch($show) {
    
    case 'emailForm': ?>
    
	<h2>Password Recovery</h2>
    <p>You can use this form to recover your password if you have forgotten it. Because your password is securely encrypted in our database, it is impossible actually recover your password, but we will email you a link that will enable you to reset it securely. Enter either your username or your email address below to get started.</p>
    <?php if ($error == true) { ?><span class="error">You must enter either a username or password to continue.</span><?php } ?>
    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="fieldGroup"><label for="idnumber">Identification number</label><div class="field"><input type="text" name="idnumber" id="idnumber" value="" maxlength="20"></div></div>
        <input type="hidden" name="subStep" value="1" />
        <div class="fieldGroup"><input type="submit" value="Submit" style="margin-left: 150px;" /></div>
        <div class="clear"></div>
    </form>
    <?php break;
    
    case 'securityForm': ?>
    
    <h2>Password Recovery</h2>    
    <p>Please answer the security question below:</p>
    <?php if ($error == true) { ?><span class="error">You must answer the security question correctly to receive your lost password.</span><?php } ?>
    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="fieldGroup"><label>Question</label><div class="field"><?= getSecurityQuestion($securityUser); ?></div></div>
        <div class="fieldGroup"><label for="answer">Answer</label><div class="field"><input type="text" name="answer" id="answer" value="" maxlength="255"></div></div>
        <input type="hidden" name="subStep" value="2" />
        <input type="hidden" name="userID" value="<?= $securityUser; ?>" />
        <div class="fieldGroup"><input type="submit" value="Submit" style="margin-left: 150px;" /></div>
        <div class="clear"></div>
    </form>

	 <?php break; 
         
    case 'userNotFound': ?>
    
    <h2>Password Recovery</h2>
    <p>The username or email you entered was not found in our database.<br /><br /><a href="?">Click here</a> to try again.</p>
    <?php break; case 'successPage': ?>
    <h2>Password Recovery</h2>
    <p>An email has been sent to you with instructions on how to reset your password. <strong>(Mail will not send unless you have an smtp server running locally.)</strong><br /><br /><a href="login.php">Return</a> to the login page. </p>
    <p>This is the message that would appear in the email:</p>
    <div class="message"><?= $passwordMessage;?></div>
    <?php break; case 'recoverForm': ?>
    <h2>Password Recovery</h2>
    <p>Welcome back, <?= getUserName($securityUser=='' ? $_POST['userID'] : $securityUser); ?>.</p>
    <p>In the fields below, enter your new password.</p>
    <?php if ($error == true) { ?><span class="error">The new passwords must match and must not be empty.</span><?php } ?>
    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="fieldGroup"><label for="pw0">New Password</label><div class="field"><input type="password" class="input" name="pw0" id="pw0" value="" maxlength="20"></div></div>
        <div class="fieldGroup"><label for="pw1">Confirm Password</label><div class="field"><input type="password" class="input" name="pw1" id="pw1" value="" maxlength="20"></div></div>
        <input type="hidden" name="subStep" value="3" />
        <input type="hidden" name="userID" value="<?= $securityUser=='' ? $_POST['userID'] : $securityUser; ?>" />
        <input type="hidden" name="key" value="<?= $_GET['email']=='' ? $_POST['key'] : $_GET['email']; ?>" />
        <div class="fieldGroup"><input type="submit" value="Submit" style="margin-left: 150px;" /></div>
        <div class="clear"></div>
    </form>
    <?php break; case 'invalidKey': ?>
    <h2>Invalid Key</h2>
    <p>The key that you entered was invalid. Either you did not copy the entire key from the email, you are trying to use the key after it has expired (3 days after request), or you have already used the key in which case it is deactivated.<br /><br /><a href="login.php">Return</a> to the login page. </p>
    <?php break; case 'recoverSuccess': ?>
    <h2>Password Reset</h2>
    <p>Congratulations! your password has been reset successfully.</p><br /><br /><a href="login.php">Return</a> to the login page. </p>
    <?php break; case 'speedLimit': ?>
    <h2>Warning</h2>
    <p>You have answered the security question wrong too many times. You will be locked out for 15 minutes, after which you can try again.</p><br /><br /><a href="login.php">Return</a> to the login page. </p>
    <?php break; }
	ob_flush();
?>
</div>
</body>
</html>

