<?php
define("PW_SALT",'(+3%_');

    //    error_reporting(E_ALL ^ E_NOTICE);
		
    //    ini_set('display_errors', 1); 

function checkUNEmail($id)
{
	//global $mySQL;
	$error = array('status'=>false,'userID'=>0);
	if (isset($id) && trim($id) != '') {
		//id was entered
                $query="SELECT participant_id FROM or_participants WHERE identification_name = '".($id)."'";

                $SQL=orsee_query($query);

		if ($SQL)
		{
			/*$SQL->bind_param('s',trim($email));
			$SQL->execute();
			$SQL->store_result();
			$numRows = $SQL->num_rows();
			$SQL->bind_result($userID);
			$SQL->fetch();
			$SQL->close();
			if ($numRows >= 1) */
			
                    return array('status'=>true,'id'=>$SQL['participant_id']);
		} else { return $error; }
	} /*elseif (isset($uname) && trim($uname) != '') {
		//username was entered
                $query="SELECT `ID` FROM `users_enc` WHERE Username = ? LIMIT 1";
                $SQL=orsee_query($query);
                
		if ($SQL)
		{
			$SQL->bind_param('s',trim($uname));
			$SQL->execute();
			$SQL->store_result();
			$numRows = $SQL->num_rows();
			$SQL->bind_result($userID);
			$SQL->fetch();
			$SQL->close();
			if ($numRows >= 1) return array('status'=>true,'userID'=>$userID);
		} else { return $error; }
	} */else {
		//nothing was entered;
		return $error;
	}
}

function softBan() {
        
    $query="SELECT * FROM ".table(participate_at)." INNER JOIN or_experiments ON or_participate_at.experiment_id = or_experiments.experiment_id WHERE or_participate_at.participant_id = ".$_SESSION['participant_id']." AND or_experiments.excluding = 'y' AND or_experiments.experiment_finished = 'n'";
    //SGC -- ACABAR. HAY QUE AJUSTAR MÁS LOS CRITERIOS.
    $SQL=orsee_query($query);
	if ($SQL)
	{
		echo "Estás realizando un experimento excluyente con el resto. Cuando termines el experimento, podrás volver a apuntarte a otros.";
		die();
	}
    //echo $query;
}



/*function checkSecAnswer($userID,$answer)
{
	global $mySQL;
	if ($SQL = $mySQL->prepare("SELECT `Username` FROM `users_enc` WHERE `ID` = ? AND LOWER(`secA`) = ? LIMIT 1"))
	{
		$answer = strtolower($answer);
		$SQL->bind_param('is',$userID,$answer);
		$SQL->execute();
		$SQL->store_result();
		$numRows = $SQL->num_rows();
		$SQL->close();
		if ($numRows >= 1) { return true; }
	} else {
		return false;
	}
}*/

function sendPasswordEmail($id)
{
	global $mySQL;global $settings;global $settings__server_url;
	$query="SELECT identification_name, email, password FROM ".table(participants)." WHERE participant_id = '".$id."'";
    $SQL=orsee_query($query);
	if ($SQL)
	{            
		$email = $SQL['email'];
		$uname = $SQL['identification_name'];
		$expFormat = mktime(date("H"), date("i"), date("s"), date("m")  , date("d")+3, date("Y"));
		$expDate = date("Y-m-d H:i:s",$expFormat);
		$key = md5($uname . '_' . $email . rand(0,10000) .$expDate . PW_SALT);
                
        $query="INSERT INTO ".table(recoveryemails_enc)." (UserID, KeyUser, expDate) VALUES (".$id.", '".$key."', '".$expDate."')";
                
        $done=mysqli_query($GLOBALS['mysqli'],$query) or die("Database error: " . mysqli_error($GLOBALS['mysqli']));
        
		if ($done)
		{
			$queryb = "select ".$settings['public_standard_language']." from ".table('lang')." where content_name='body_lost_passwd'";
			$SQLb=orsee_query($queryb);
			$querys = "select ".$settings['public_standard_language']." from ".table('lang')." where  content_name='subject_lost_passwd'";
			$SQLs=orsee_query($querys);
		//	echo $queryb."<br>".$querys;
			$passwordLink = "<a href=http://".$settings__server_url."/experimentos/public/participant_forgot_pass.php?a=recover&email=" . $key . "&u=" . urlencode(base64_encode($id)).">http://".$settings__server_url."/experimentos/public/participant_forgot_pass.php?a=recover&email=" . $key . "&u=" . urlencode(base64_encode($id)) . "</a>";
			
			$messageTemp = $SQLb[$settings['public_standard_language']];
			$subject = $SQLs[$settings['public_standard_language']];
			
			$message = str_replace("passwordLink", $passwordLink,$messageTemp);
			$message = str_replace("uname", $uname,$message);
			
			require_once('../phpmailer/PHPMailer_5.2.4/class.phpmailer.php');

			    $mail             = new PHPMailer();
			    $mail->CharSet = "text/plain; charset=UTF-8;";

			    $mail->IsSMTP(); // Usar SMTP para enviar
			    $mail->SMTPDebug  = 0; // habilita información de depuración SMTP (para pruebas)
			                           // 1 = errores y mensajes
			                           // 2 = sólo mensajes
			    $mail->SMTPAuth   = true; // habilitar autenticación SMTP
			    $mail->Host       = "smtp.gmail.com"; // establece el servidor SMTP
			    $mail->Port       = 587; // configura el puerto SMTP utilizado
			    $mail->SMTPSecure = "tls";
			    $mail->Username   = "agora.experimentos@gmail.com"; // nombre de usuario UGR
			    $mail->Password   = "Ninguna1@"; // contraseña del usuario UGR
			    $mail->IsHTML(false);	
			    $mail->SetFrom('Experimentos', 'Agora');
			    $mail->Subject    = $subject;
			    $mail->MsgHTML($message); // Fija el cuerpo del mensaje
			//    $mail->$body;
			    $address = $email; // Dirección del destinatario
			    $mail->AddAddress($address, "Psicología");
				if(!$mail->Send()) {
			       $done = "Error: " . $mail->ErrorInfo;
			    }
			    else {
			       //$done = "¡Mensaje enviado!";
			    }
				return $email;

				}
			
			//return str_replace("\r\n","<br/ >",$message);
		}
	}


function checkEmailKey($key,$userID)
{
	global $mySQL;global $settings;
	$curDate = date("Y-m-d H:i:s");
	$query = "SELECT `UserID` FROM ".table(recoveryemails_enc)." WHERE `KeyUser` = '".$key."' AND `UserID` = '".$userID."' AND `expDate` >= '".$curDate."'";
	$SQL=orsee_query($query);
	if ($SQL)
	{
	//	$SQL->bind_param('sis',$key,$userID,$curDate);
	//	$SQL->execute();
	//	$SQL->store_result();
	//	$numRows = $SQL->num_rows();
	//	$SQL->bind_result($userID);
	//	$SQL->fetch();
	//	$SQL->close();
	
		{
			return array('status'=>true,'userID'=>$SQL["UserID"]);
		}
	}
	return false;
}

function updateUserPassword($userID,$password)
{
	global $mySQL;global $settings;
	//if (checkEmailKey($key,$userID) === false) return false;
	echo "UPDATE `".table(participants)."` SET `password` = '".md5($password)."' WHERE `participant_id` = ".$userID;die();
	if ($SQL = orsee_query("UPDATE `".table(participants)."` SET `password` = '".md5($password)."' WHERE `participant_id` = ".$userID))
	{
		
		$SQL = orsee_query("DELETE FROM `".table(recoveryemails_enc)."` WHERE `Key` = ".$key);
		
	}
}

function getUserName($userID)
{
	global $mySQL;global $settings;

	$query ="SELECT `identification_name` FROM ".table(participants)." WHERE `participant_id` = ".$userID;
	
	$SQL=orsee_query($query);
	if ($SQL)
	{

		return $uname;
		}
}
