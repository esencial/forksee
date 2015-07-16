<?php
ob_start();
$error=''; // Variable To Store Error Message
//if (isset($_POST['submit'])) {
include('common.php');	

	
if ((is_null($_POST['username'])) or (is_null($_POST['password']))) {

    header("location: participant_login.php");
        
}
else
{
    
	// Define $username and $password
	$username=$_POST['username'];
	$password=$_POST['password'];
	// Establishing Connection 
	// To protect MySQL injection for Security purpose
	$username = stripslashes($username);
	$password = stripslashes($password);
        
	//$username = mysql_real_escape_string($username);
        
        
	//$password = md5(mysql_real_escape_string($password));
        $password = md5($password);
        
        
	$query1 = "SELECT * FROM ".table('participants')." WHERE password='$password' AND identification_number='$username'";
	$result=orsee_query($query1);
	
	if (!is_null($result)) {
            
            //[SGA] Comprobamos si está baneado
            
            if($result['banned']=='1')
            {
                
                //[SGA] Este sería el primer tipo de ban, un ban por fecha
                $banStartDate = $result['ban_start_day']."-".$result['ban_start_month']."-".$result['ban_start_year'];  //COncatenacion de valores
                $ts_BSD=strtotime($banStartDate);       //pasamos a timestamp
                $banStartDate=date("d-m-Y",$ts_BSD);    //damos formato

                $banEndDate = $result['ban_end_day']."-".$result['ban_end_month']."-".$result['ban_end_year'];  
                $ts_BED=strtotime($banEndDate);       
                $banEndDate=date("d-m-Y",$ts_BED);    

                if($banStartDate<=date("d-m-Y") && $banEndDate>=date("d-m-Y")){ //Si la fecha actual es mayor que el banstart y menor que el ban end... u are fucked.
                    header("location: participant_login.php?error=2");
                    die();  //Necesario aqui para evitar continuar la ejecucion. 
                }    
                //End [SGA]
                
                
                
                //[SGA] Zona reservada para el ban de la fase 2: ban por experimento
                
                //End [SGA]
            }
            
            
            $_SESSION['login_user']=$username; // Initializing Session
            $_SESSION['participant_id']=$result['participant_id'];
            header("location: participant_edit.php"); // Redirecting To Other Page

                
        }else {
	
		header("location: participant_login.php?error=1");
	}
	
}
//}
?>
