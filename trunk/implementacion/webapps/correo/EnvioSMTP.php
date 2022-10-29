<?php

	class EnvioSMTP{
		// $correos es un array
		public static function correo($title, $Subject, $Body, $correos, $archivo = '', $archivo2 = ''){
			require("PHPMailer_5.2.0/class.phpmailer.php");
			try{
				$mail = new PHPMailer();
				$mail->IsSMTP();
				$mail->Host = "smtp.gmail.com";
			    $mail->SMTPAuth = true;
			    $mail->Username = "soportemayamat@gmail.com";
			    $mail->Password = "vevxrgfrzdwknkqp";
			    $mail->Port = 587;
			    $mail->CharSet = 'UTF-8';
			    $mail->From = "soportemayamat@gmail.com";
				$mail->FromName = $title;
				for ($i=0; $i < count($correos); $i++) { 
					$mail->AddAddress($correos[$i]);
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
				echo false;
			}catch (Exception $e){
				echo true;
			}
		}
	}

?>