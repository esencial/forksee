<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include ("header.php");
include("assets/php/functions.php");
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body><?php
    
        error_reporting(E_ALL ^ E_NOTICE);
		
        ini_set('display_errors', 1);      
        
        ob_start();
    
        $show = 'emailForm'; //which form step to show by default
        if ($_SESSION['lockout'] == true && (mktime() > $_SESSION['lastTime'] + 900))
            {
            echo 'entra por el if';
            $_SESSION['lockout'] = false;
            $_SESSION['badCount'] = 0;
            }
        if (isset($_POST['subStep']) &&!isset($_GET['a']) && $_SESSION['lockout'] != true)
            {
            switch($_POST['subStep'])
            {
        case 1:
        //we just submitted an email or username for verification
            echo 'caso1';
            $result = checkUNEmail($_POST['uname'], $_POST['email']);
            if ($result['status'] == false )
            {
            $error = true;
            $show = 'userNotFound';
            } else {
            $error = false;
            $show = 'securityForm';
            $securityUser = $result['userID'];
            }
        break;
        case 2:
            echo 'caso2';
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
            }
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
    
        

        include ("footer.php");    
        ?>
        </body>
</html>
