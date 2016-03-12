<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
$menu__area="public_register";
include_once ("header.php");
//include_once ('session.php');

include("assets/functions.php");


       
    //    ob_start();
    
        $show = 'emailForm'; //which form step to show by default
        
        if (isset($_POST['subStep']) &&!isset($_GET['a']) && $_SESSION['lockout'] != true)
            {
            switch($_POST['subStep'])
            {
        case 1:
        //we just submitted an email or username for verification
            $result = checkUNEmail($_POST['idnumber']);
            if ($result['status'] == false )
            {
                $error = true;
                $show = 'userNotFound';
            } else {
                $error = false;
                //$show = 'securityForm';
                $show = 'successPage';                
                //$securityUser = $result['userID'];
                $passwordMessage = sendPasswordEmail($result['id']);
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
            if ($_POST['userID'] == '') header("location: login.php");
            if (strcmp($_POST['pw0'], $_POST['pw1']) != 0 || trim($_POST['pw0']) == '')
            {
            $error = true;
            $show = 'recoverForm';
            } else {
            $error = false;
            $show = 'recoverSuccess';
            updateUserPassword($_POST['userID'], $_POST['pw0']);
            }
        break;
            }            
        }
        elseif (isset($_GET['a']) && $_GET['a'] == 'recover' && $_GET['email'] != "") {
            $show = 'invalidKey';
            $result = checkEmailKey($_GET['email'],urldecode(base64_decode($_GET['u'])));
            if ($result == false)
            {
                $error = true;
                $show = 'invalidKey';
            } elseif ($result['status'] == true) {
                $error = false;
                $show = 'recoverForm';
               /******el userid no lo carga bien****/
                $securityUser = $result["userID"];
                
            }
        }
        /*if ($_SESSION['badCount'] >= 3)
        {
            $show = 'speedLimit';
            $_SESSION['lockout'] = true;
            $_SESSION['lastTime'] = '' ? mktime() : $_SESSION['lastTime'];
        }*/
    
          
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
<?php 
switch($show) {
    
    case 'emailForm': ?>
    
	<h2><?php echo $lang['pass_recovery']; ?></h2>
    <p><?php echo $lang['explanation_pass_recovery']; ?></p>
    <?php if ($error == true) { ?><span class="error"><?php echo $lang['error_pass_recover'];?></span><?php } ?>
    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="fieldGroup"><div class="field"><input type="text" name="idnumber" id="idnumber" value="" maxlength="220"></div></div>
        <input type="hidden" name="subStep" value="1" />
        <div class="btn btn-block  btn-lg" style="width:30%"><input  type="submit" value="<?php echo $lang['submit'];?>"></div>
        <div class="clear"></div>
    </form>
    <?php break;
    
   /* case 'securityForm': ?>
    
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

	 <?php break; */
         
    case 'userNotFound': ?>

        <h2><?php $lang['Password_Recovery']; ?></h2>
        <p><?php $lang['username_not_found']; ?><br /><br /><a href="participant_forgot_pass.php"><?php $lang['clic'];?></a> <?php $lang['try'];?></p>
    <?php break; 
    case 'successPage': ?>
        <?php echo $lang['msg_recovery_pass'];  ?>
    <?php break; 
    case 'recoverForm': ?>
        <h2><?php $lang['Password_Recovery']; ?></h2>
        <?php $user = urldecode(base64_decode($_GET['u'])); ?>
        <p><?php $lang['hello']; ?> <? //echo getUserName($securityUser); ?>.</p>
        <p><?php $lang['enter_new_pass']; ?></p>
        <?php if ($error == true) { ?><span class="error"><?php $lang['new_pass_match']; ?></span><?php } ?>
        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="fieldGroup"><label for="pw0"><?php $lang['new_pass']; ?></label><div class="field"><input type="password" class="input" name="pw0" id="pw0" value="" maxlength="20"></div></div>
            <div class="fieldGroup"><label for="pw1"><?php $lang['confirm_new_pass']; ?></label><div class="field"><input type="password" class="input" name="pw1" id="pw1" value="" maxlength="20"></div></div>
            <input type="hidden" name="subStep" value="3" />
            <input type="hidden" name="userID" value="<?php echo $user; ?>" />
          <!--  <input type="hidden" name="key" value="<?= $_GET['email']=='' ? $_POST['key'] : $_GET['email']; ?>" />-->
            <br><br>
            <div class="fieldGroup"><input type="submit" value="Aceptar" /></div>
            <div class="clear"></div>
        </form>
    <?php break; case 'invalidKey': ?>
    <h2>Invalid Key</h2>
    <p>The key that you entered was invalid. Either you did not copy the entire key from the email, you are trying to use the key after it has expired (3 days after request), or you have already used the key in which case it is deactivated.<br /><br /><a href="login.php">Return</a> to the login page. </p>
    <?php break; case 'recoverSuccess': ?>
    <h2><?php $lang['Password_Recovery']; ?></h2>
    <p><?php $lang['congrats']; ?> </p>
    <?php break; case 'speedLimit': ?>
    <h2>Warning</h2>
    <p>You have answered the security question wrong too many times. You will be locked out for 15 minutes, after which you can try again.</p><br /><br /><a href="login.php">Return</a> to the login page. </p>
    <?php break; }
	ob_flush();
?>
</div>
</body>
</html>

