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
                $query="SELECT identification_number FROM or_participants WHERE identification_number = '".$id."'";
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
                    return array('status'=>true,'userID'=>$id);
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
        
    $query="SELECT * FROM or_participate_at INNER JOIN or_experiments ON or_participate_at.experiment_id = or_experiments.experiment_id WHERE or_participate_at.participant_id = ".$_SESSION['participant_id']." AND or_experiments.excluding = 'y' AND or_experiments.experiment_finished = 'n'";
    //SGC -- ACABAR. HAY QUE AJUSTAR MÁS LOS CRITERIOS.
    $SQL=orsee_query($query);
	if ($SQL)
	{
		echo "Estás realizando un experimento excluyente con el resto. Cuando termines el experimento, podrás volver a apuntarte a otros.";
		die();
	}
    //echo $query;
}

/*function getSecurityQuestion($userID)
{
	global $mySQL;
	$questions = array();
	$questions[0] = "What is your mother's maiden name?";
	$questions[1] = "What city were you born in?";
	$questions[2] = "What is your favorite color?";
	$questions[3] = "What year did you graduate from High School?";
	$questions[4] = "What was the name of your first boyfriend/girlfriend?";
	$questions[5] = "What is your favorite model of car?";
        $query="SELECT secQ FROM or_participants WHERE identification_number = '".$id."'";
        $SQL=orsee_query($query);
	if ($SQL)
	{
		$SQL->bind_param('i',$userID);
		$SQL->execute();
		$SQL->store_result();
		$SQL->bind_result($secQ);
		$SQL->fetch();
		$SQL->close();
		return $questions[$secQ];
	} else {
		return false;
	}
}*/

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
	global $mySQL;
        
        $query="SELECT identification_number, email, password FROM ".table(participants)." WHERE identification_number = '".$id."'";
        $SQL=orsee_query($query);
	if ($SQL)
	{            
		/*$SQL->bind_param('i',$userID);
		$SQL->execute();
		$SQL->store_result();
		$SQL->bind_result($uname,$email,$pword);
		$SQL->fetch();
		$SQL->close();*/
                $email = $SQL['email'];
		$expFormat = mktime(date("H"), date("i"), date("s"), date("m")  , date("d")+3, date("Y"));
		$expDate = date("Y-m-d H:i:s",$expFormat);
		$key = md5($uname . '_' . $email . rand(0,10000) .$expDate . PW_SALT);
                
                $query="INSERT INTO or_recoveryemails_enc (UserID, KeyUser, expDate) VALUES (".$id.", '".$key."', '".$expDate."')";
                
                $done=mysqli_query($GLOBALS['mysqli'],$query) or die("Database error: " . mysqli_error($GLOBALS['mysqli']));
        
		if ($done)
		{
			/*$SQL->bind_param('iss',$userID,$key,$expDate);
			$SQL->execute();
			$SQL->close();*/
			$passwordLink = "<a href=http://$settings__server_url/participant_forgot_pass.php?a=recover&email=" . $key . "&u=" . urlencode(base64_encode($userID)) . "\">http://$settings__server_url/participant_forgot_pass.php?a=recover&email=" . $key . "&u=" . urlencode(base64_encode($userID)) . "</a>";
			$message = "Dear $uname,<br>";
			$message .= "Please visit the following link to reset your password:<br>";
			$message .= "-----------------------<br>";
			$message .= "$passwordLink<br>";
			$message .= "-----------------------<br>";
			$message .= "Please be sure to copy the entire link into your browser. The link will expire after 3 days for security reasons.<br>";
			$message .= "If you did not request this forgotten password email, no action is needed, your password will not be reset as long as the link above is not visited. However, you may want to log into your account and change your security password and answer, as someone may have guessed it.<br>";
			$message .= "Thanks,<br>";
			$message .= "-- Our site team";
			$headers = array();
			$headers[] = "From: Orsee <".$site__mail_account.">";
			$headers[] = "To-Sender: $email";
			$headers[] = 'X-Mailer: PHP/'. phpversion(); // mailer
			$headers[] = "Reply-To: ".$site__mail_account; // Reply address
			$headers[] = "Return-Path: ".$site__mail_account; //Return Path for errors
			$headers[] = "Content-Type: text/html; charset=iso-8859-1"; //Enc-type
			$subject = "Your Lost Password";
			mail($email,$subject,$message,$headers);
			return "enviado a ".$email;
			//return str_replace("\r\n","<br/ >",$message);
		}
	}
}

function checkEmailKey($key,$userID)
{
	global $mySQL;
	$curDate = date("Y-m-d H:i:s");
	if ($SQL = $mySQL->prepare("SELECT `UserID` FROM `recoveryemails_enc` WHERE `Key` = ? AND `UserID` = ? AND `expDate` >= ?"))
	{
		$SQL->bind_param('sis',$key,$userID,$curDate);
		$SQL->execute();
		$SQL->execute();
		$SQL->store_result();
		$numRows = $SQL->num_rows();
		$SQL->bind_result($userID);
		$SQL->fetch();
		$SQL->close();
		if ($numRows > 0 && $userID != '')
		{
			return array('status'=>true,'userID'=>$userID);
		}
	}
	return false;
}

function updateUserPassword($userID,$password,$key)
{
	global $mySQL;
	if (checkEmailKey($key,$userID) === false) return false;
	if ($SQL = $mySQL->prepare("UPDATE `users_enc` SET `Password` = ? WHERE `ID` = ?"))
	{
		$password = md5(trim($password) . PW_SALT);
		$SQL->bind_param('si',$password,$userID);
		$SQL->execute();
		$SQL->close();
		$SQL = $mySQL->prepare("DELETE FROM `recoveryemails_enc` WHERE `Key` = ?");
		$SQL->bind_param('s',$key);
		$SQL->execute();
	}
}

function getUserName($userID)
{
	global $mySQL;
	if ($SQL = $mySQL->prepare("SELECT `Username` FROM `users_enc` WHERE `ID` = ?"))
	{
		$SQL->bind_param('i',$userID);
		$SQL->execute();
		$SQL->store_result();
		$SQL->bind_result($uname);
		$SQL->fetch();
		$SQL->close();
	}
	return $uname;
}
