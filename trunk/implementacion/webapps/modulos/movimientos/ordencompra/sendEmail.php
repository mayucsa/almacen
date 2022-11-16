<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once "PHPMailer/Exception.php";
include_once "PHPMailer/PHPMailer.php";
include_once "PHPMailer/SMTP.php";
include_once "../../../dbconexion/conn.php";
$dbcon  =   new MysqlConn;
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
    $mail->setFrom('soportemayamat@gmail.com', 'Sistema Almacen Mayucsa (SAM)');
    $mail->addAddress('r.ciau@mayucsa.com.mx', 'Rogelio Ciau');     //Add a recipient
    $mail->addAddress('o.tymonina@mayucsa.com.mx', 'Olena Tymonina');     //Add a recipient
    // Obtenemos el cve_odc de la requisición
    $cve_odc = $_REQUEST['cve_odc'];
    $sql = "SELECT catp.nombre_proveedor, conp.correo FROM orden_compra odc 
    INNER JOIN cat_proveedores catp ON catp.cve_proveedor = odc.cve_proveedor
    INNER JOIN contacto_proveedores conp ON conp.cve_proveedor = catp.cve_proveedor
    WHERE odc.cve_odc = ".$cve_odc;
    $proveedores = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
    foreach ($proveedores as $i => $val) {
        $mail->addAddress($val->correo, $val->nombre_proveedor);
    }
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('j.chin@mayucsa.com.mx', 'Jose Chin');
    $mail->addBCC('a.chan@mayucsa.com.mx');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Orden de compra '.$cve_odc.' - Mayucsa';
    $mail->Body    = 'Buen d&iacute;a, se ha generado una Orden de compra con n&uacute;mero de <b>folio '.$cve_odc.'</b> 
                        <br><br> Favor de presentar &eacute;sta Orden de Compra impresa para la recepci&oacute;n de los materiales en nuestro almac&eacute;n.
                        <br> Indispensable presentar &eacute;sta Orden de compra con factura y/o remisi&oacute;n sellada y firmada por almac&eacute;n para la revisi&oacute;n de facturas.
                        <br><br> Horarios de almac&eacute;n: lunes a viernes de 08:00 a 16:00 hrs y s&aacute;bados de 08:00 a 12:00 hrs.
                        <br> D&iacute;as de revisi&oacute;n y entrega de contra-recibos: martes y jueves de 09:00 a 12:00 hrs y de 14:00 a 16:00 hrs.
                        <br> D&iacute;as de pago lunes de 09:00 a 12:00 hrs y de 14:00 a 16:00 hrs.';
    $mail->AddAttachment("../../../includes/imagenes/Mayucsa.png", "Mayucsa.png");
    $sql = "SELECT * FROM orden_compra_archivos WHERE cve_odc = ".$cve_odc;
    $archivos = $dbcon->qBuilder($dbcon->conn(), 'all', $sql);
    foreach ($archivos as $i => $val) {
        $mail->AddAttachment($val->ruta.$val->nombre, $val->nombreOriginal);
    }
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Mensaje Enviado Correctamente';
} catch (Exception $e) {
    echo "No se pudo enviar el mensaje. Mailer Error: {$mail->ErrorInfo}";
}
 ?>