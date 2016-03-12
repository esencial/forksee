<?php
// part of orsee. see orsee.org
ob_start();

include ("header.php");

?>
<?php
$query1 = "SELECT * FROM ".table('subjects').""; 
$result1 = orsee_query($query1,'S');
foreach($result1 as $row1) {
	$receptor = $row1['email'];
	$query2 = "SELECT * FROM ".table('subjects_participants')." WHERE sent = 0 and subject_id='".$row1['subject_id']."'";
	$result2=orsee_query($query2,'S');
	$tema_str = "Relación de créditos y alumnos para la asignatura " . $row1['subject_desc'] . "<br>";
	
	foreach($result2 as $row2) 
	{
		$str_subject = $row2['name']." - ". $row2['credits_spent']."<br>"; 
		$body_str = $body_str + $str_subject;
		
	}
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
    $mail->IsHTML(true);	
    $mail->SetFrom('Experimentos', 'Agora');
    $mail->Subject    = $receptor;
    $mail->MsgHTML($body_str); // Fija el cuerpo del mensaje
//    $mail->$body;
    $address = $email; // Dirección del destinatario
    $mail->AddAddress($address, "Psicología");
	if(!$mail->Send()) {
       $done = "Error: " . $mail->ErrorInfo;
    }
	$query3 = "update ".table('subjects_participants')." SET sent = 1 WHERE subject_id='".$row1['subject_id']."'";
	$result2=orsee_query($query3,'S');
    //else {
       //$done = "¡Mensaje enviado!";
    //}
	//return $email;
    header("Location:subject_main.php");
	
}
?>