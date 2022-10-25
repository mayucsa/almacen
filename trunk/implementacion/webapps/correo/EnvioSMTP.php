<?php

	class EnvioSMTP{
		// public static function conectar(){
		public static function correo($title, $Subject, $Body, $archivo = '', $archivo2 = ''){
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->Host = "smtp.gmail.com";
		    $mail->SMTPAuth = true;
		    $mail->Username = "soportemayamat@gmail.com";
		    $mail->Password = "teconologias3";
		    $mail->CharSet = 'UTF-8';
		    $mail->From = "soportemayamat@gmail.com";
			$mail->FromName = $title;
			$mail->AddAddress('lcdevelopersmx@gmail.com');
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

			if(!$mail->Send()){
				echo 'mail a contador no enviado';
			 }
		}
	}

?>