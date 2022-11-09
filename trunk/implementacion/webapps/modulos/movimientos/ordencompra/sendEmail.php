<?php 
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	include_once "PHPMailer/Exception.php";
	include_once "PHPMailer/PHPMailer.php";
	include_once "PHPMailer/SMTP.php";

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'soportemayamat@gmail.com';                     //SMTP username
    $mail->Password   = 'vevxrgfrzdwknkqp';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('soportemayamat@gmail.com', 'Sistema Almacen Mayucsa');
    $mail->addAddress('r.ciau@mayucsa.com.mx', 'Rogelio Ciau');     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('j.chin@mayucsa.com.mx', 'Jose Chin');
    $mail->addBCC('a.chan@mayucsa.com.mx');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Orden de compra - Mayucsa';
    $mail->Body    = 'Buen d&iacute;a, se ha generado una Orden de compra con folio #0000';
    $mail->AddAttachment("../../../includes/imagenes/Mayucsa.png", "Mayucsa.png");
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Mensaje Enviado Correctamente';
} catch (Exception $e) {
    echo "No se pudo enviar el mensaje. Mailer Error: {$mail->ErrorInfo}";
}
 ?>