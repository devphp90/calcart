<?php

require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'class.phpmailer.php';

class yiiPhpMailer extends PHPMailer
{	
	public function Ready($subject, $message, $address, $attachFilePath = null)
	{
		$exito = false;
		$mailer = new PhpMailer;
		$mailer->IsSMTP();
		$mailer->Host = Yii::app()->params['mailHost'];
		$mailer->SMTPAuth = Yii::app()->params['mailSMTPAuth'];
		$mailer->Username = Yii::app()->params['mailUsername'];
		$mailer->Password = Yii::app()->params['mailPassword'];
		$mailer->From = Yii::app()->params['mailSenderEmail'];
		$mailer->FromName = Yii::app()->params['mailSenderName'];
		$mailer->CharSet = 'UTF-8';
		$mailer->AltBody = 'To view the message, please use an HTML compatible email viewer!';
		
		if (isset($address['email']) && isset($address['name']))
			$mailer->AddAddress($address['email'], $address['name']);
		else 
		{
			for ($i=0; $i<count($address); $i++) 
				$mailer->AddBCC(str_replace('"','',$address[$i]), str_replace('"','',$address[$i]));
		}
		
		$mailer->Subject = $subject;
		$mailer->Body = $message;
		
		if ($attachFilePath != null)
			$mailer->AddAttachment($attachFilePath);
		
		//$exito = $mailer->Send();
		$exito = false;

		if (!$exito) 
		{
			$cabeceras = 'From: ' . Yii::app()->params['mailSenderEmail'] . "\r\n" .
				'Reply-To: ' . Yii::app()->params['mailSenderEmail'] . "\r\n" .
				'X-Mailer: PHP/' . phpversion() . "\r\n";
			$cabeceras .= 'MIME-Version: 1.0' . "\r\n";
			$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$exito = mail($address['email'], $subject, $message, $cabeceras);
			
			/*if (isset($address['email']) && isset($address['name']))
				$exito = mail($address['email'], $subject, $message, $cabeceras);
			else 
			{
				for ($i=0; $i<count($address); $i++)
					$exito = mail(str_replace('"','',$address[$i]), $subject, $message, $cabeceras);
				$exito = true;
			}*/
		}
		
		$mailer->ClearAddresses();
		
		return $exito;
	}
}