<?php
    // Especificar correctamente el path al archivo class.phpmailer.php
	error_reporting( E_ALL );
    require_once('phpmailer/PHPMailer_5.2.4/class.phpmailer.php');

    $mail             = new PHPMailer();

    $body             = "Prueba de envio"; // Cuerpo del mensaje
    $mail->IsSMTP(); // Usar SMTP para enviar
    $mail->SMTPDebug  = 0; // habilita información de depuración SMTP (para pruebas)
                           // 1 = errores y mensajes
                           // 2 = sólo mensajes
    $mail->SMTPAuth   = true; // habilitar autenticación SMTP
    $mail->Host       = "smtp.gmail.com"; // establece el servidor SMTP
    $mail->Port       = 465; // configura el puerto SMTP utilizado
    $mail->SMTPSecure = "ssl";
    $mail->Username   = "silviaesencial@gmail.com"; // nombre de usuario UGR
    $mail->Password   = "soys1lv1a"; // contraseña del usuario UGR
 
    $mail->SetFrom('usuario', 'Agora');
    $mail->Subject    = "Asunto del mensaje";
    $mail->MsgHTML($body); // Fija el cuerpo del mensaje

    $address = "silvia.suria@esencialsistemas.com"; // Dirección del destinatario
    $mail->AddAddress($address, "Silvia");

    if(!$mail->Send()) {
        echo "Error: " . $mail->ErrorInfo;
    }
    else {
        echo "¡Mensaje enviado!";
    }
?>
