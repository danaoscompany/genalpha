<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'mailer/src/Exception.php';
require 'mailer/src/PHPMailer.php';
require 'mailer/src/SMTP.php';

class MailSender extends CI_Controller {
	
	public static function sendMail($to, $subject, $content) {
		$mail = new PHPMailer(true);
		/*try {
    		$mail->isSMTP();
    		$mail->Host = 'smtp.hostinger.co.id';
    		$mail->SMTPAuth = true;
			$mail->SMTPDebug = 2;
    		$mail->Username = 'admin@localhost';
    		$mail->Password = '8gP5PcAUtRD*';
    		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    		$mail->Port = 587;
    		$mail->setFrom('admin@localhost', 'Gen Alpha');
    		$mail->addAddress($to, '');
    		$mail->isHTML(true);
    		$mail->Subject = $subject;
    		$mail->Body = $content;
    		if (!$mail->send()) {
    			echo $mail->ErrorInfo;
			}
		} catch (Exception $e) {
		}*/
		try {
			$mail->isSMTP();
			$mail->Host = 'smtp.gmail.com';
			$mail->SMTPAuth = true;
			$mail->SMTPDebug = 2;
			$mail->Username = 'localhost@gmail.com';
			$mail->Password = 'GenAlpha123';
			$mail->SMTPSecure = 'ssl';
			$mail->Port = 465;
			$mail->setFrom('danaoscompany2@gmail.com', 'DanaOS Company');
			$mail->addAddress($to, '');
			$mail->isHTML(true);
			$mail->Subject = $subject;
			$mail->Body = $content;
			if (!$mail->send()) {
				echo $mail->ErrorInfo;
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}
