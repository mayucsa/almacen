<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


	class EnvioSMTP{
		// $correos es un array
		public static function correo($title, $Subject, $Body, $correos, $archivo = '', $archivo2 = ''){
			include_once "PHPMailer/Exception.php";
			include_once "PHPMailer/PHPMailer.php";
			include_once "PHPMailer/SMTP.php";
			$mail = new PHPMailer(true);

			try {
			    //Server settings
			    $mail->SMTPDebug = 0;//Enable verbose debug output
			    $mail->isSMTP();//Send using SMTP
			    $mail->Host       = 'smtp.gmail.com';//Set the SMTP server to send through
			    $mail->SMTPAuth   = true;//Enable SMTP authentication
			    $mail->Username   = 'soportemayamat@gmail.com';//SMTP username
			    $mail->Password   = 'vevxrgfrzdwknkqp';//SMTP password
			    $mail->SMTPSecure = 'tls';//Enable implicit TLS encryption
			    $mail->Port       = 587; 
			
			    $mail->CharSet = 'UTF-8';
			    $mail->setFrom('soportemayamat@gmail.com', 'Sistema Almacen Mayucsa (SAM)');
				$mail->FromName = $title;
				for ($i=0; $i < count($correos); $i++) { 
					$mail->AddAddress($correos[$i]->correo);
				}
				$mail->WordWrap = 50;
				$mail->IsHTML(true);
				$mail->Subject = $Subject;
				$mail->Body = $Body;
				if ($archivo != '') {
					$mail->AddAttachment($archivo, $archivo);
				}
				if ($archivo2 != '') {
					$mail->AddAttachment($archivo2, $archivo2);
				}
				$mail->Send();
				return true;
			}catch (Exception $e){
				return false;
			}
		}
	}

?>