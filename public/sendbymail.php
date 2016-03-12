<?php
// part of orsee. see orsee.org
ob_start();
$menu__area="contact";
include ("header.php");


if(isset($_POST['email'])) {

// Dirección de destino y asunto del correo a enviar
$email_to = "silvia.suria@esencialsistemas.com"; //+++++++++++++CAMBIAR+++++++++++++++
$email_subject = "Formulario de contacto enviado desde el sitio web";

// Aquí se deberían validar los datos ingresados por el usuario
if(!isset($_POST['nombre']) ||
!isset($_POST['email']) ||
!isset($_POST['subject']) ||
!isset($_POST['message'])) {
    
    
echo "<b>El formulario no ha sido enviado.</b><br />";
echo "Rellene por favor todos los campos.<br />";
die();
}

$email_message = "Detalles del formulario de contacto:\n\n";
$email_message .= "Nombre: " . $_POST['nombre'] . "\n";
$email_message .= "<BR><BR>E-mail: " . $_POST['email'] . "\n";
$email_message .= "<BR><BR>Asunto: " . $_POST['subject'] . "\n";
$email_message .= "<BR><BR>Mensaje: " . $_POST['message'] . "\n\n";


// Ahora se envía el e-mail usando la función mail() de PHP
/*$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();*/
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; ; charset=UTF-8" . "\r\n";
$headers .= "From: sergio.gonzalez@esencialsistemas.com" . "\r\n" .
"Reply-To: prueba@gmail.com" . "\r\n" .
"Return-Path: prueba@gmail.com" . "\r\n";
"X-Mailer: PHP/" . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);

echo "Formulario enviado con éxito.";

}
?>