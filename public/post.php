<?php 
// if the url field is empty 
//if(isset($_POST['url']) && $_POST['url'] == ''){
     // then send the form to your email
  //        mail( 'silvia.suria@esencialsistemas.com', 'Contact Form', print_r($_POST,true) ); 
//} 
// otherwise, let the spammer think that they got their message through
?>
<!--
<h1>Thanks</h1>

We'll get back to you as soon as possible

-->
<?php
ob_start();
$menu__area="contact";
include ("header.php");

global $lang;
$title=$lang['mail_title'];

if(isset($_POST['email'])) {

// Dirección de destino y asunto del correo a enviar
$email_to = $site__mail_account;
$email_subject = $title;

// Aquí se deberían validar los datos ingresados por el usuario
if(!isset($_POST['email']) ||
!isset($_POST['subject']) ||
!isset($_POST['message'])) {
    
echo $lang['error_mail'];    
//echo "<b>El formulario no ha sido enviado.</b><br />";
//echo "Rellene por favor todos los campos.<br />";
die();
}
require_once('../phpmailer/PHPMailer_5.2.4/class.phpmailer.php');
$mail = new PHPMailer();
$mail->IsSMTP(); // Usar SMTP para enviar
$mail->SMTPDebug  = 0; // habilita información de depuración SMTP (para pruebas)
                           // 1 = errores y mensajes
                           // 2 = sólo mensajes
$mail->SMTPAuth   = true; // habilitar autenticación SMTP
$mail->Host = "smtp.gmail.com";
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->Username = "agora.experimentos@gmail.com"; // SMTP username  
$mail->Password = "Ninguna1@"; // SMTP password
$mail->IsHTML(true);
$email_message = "Detalles del formulario de contacto:\n\n";
$email_message .= "Nombre: " . $_POST['nombre'] . "\n";
$email_message .= "<BR><BR>E-mail: " . $_POST['email'] . "\n";
$email_message .= "<BR><BR>Asunto: " . $_POST['subject'] . "\n";
$email_message .= "<BR><BR>Mensaje: " . $_POST['message'] . "\n\n";

$mail->SetFrom('agora.experimentos@gmail.com', 'Agora');
$mail->Subject    = $lang['subject_mail'];
$mail->MsgHTML($email_message); // Fija el cuerpo del mensaje

$address = $site__mail_account; // Dirección del destinatario
$mail->AddAddress($address, "PEP-UGR");

    if(!$mail->Send()) {
        echo "Error: " . $mail->ErrorInfo;
    }
    else {
        echo "¡Mensaje enviado!";
    }


// Ahora se envía el e-mail usando la función mail() de PHP
/*$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();*/

/*$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; ; charset=UTF-8" . "\r\n";
$headers .= "From: agora@ugr.es" . "\r\n" .
"Reply-To: noreply@ugr.es" . "\r\n" .
"Return-Path: agora@ugr.es" . "\r\n";
"X-Mailer: PHP/" . phpversion();
if (!@mail($email_to, $email_subject, $email_message, $headers)){
	echo "error";
} else {

echo "Formulario enviado con éxito.";
}*/

}
