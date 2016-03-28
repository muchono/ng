<?php
/**
 * Mail
  */

/*
Yii::setPathOfAlias('Zend',Yii::getPathOfAlias('application.vendors.Zend'));

use Zend\Mail;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
*/

Yii::import('application.vendors.PHPMailer.PHPMailerAutoload', true);

class CMail extends CComponent
{
    public function init()
    {

    }
    
    function send($htmlBody, $textBody, $subject, $from, $to, $attachment = array())
    {
        $mail = new PHPMailer();

        $mail->isHTML(true);
        //$mail->CharSet = "text/html; charset=UTF-8;";

        $mail->From = $from;
        $mail->FromName = Yii::app()->params['emailNotif']['from_name'];
        $mail->addAddress($to);
        
        foreach($attachment as $a){
            $mail->addAttachment($a['path'], $a['name']);
        }
        
        $mail->Subject =  $subject;
        $mail->Body =  $htmlBody; 
        $mail->AltBody  =  $textBody;    # This automatically sets the email to multipart/alternative. This body can be read by mail clients that do not have HTML email capability such as mutt.

        if(!$mail->Send())
        {
          throw new Exception("Mailer Error: " . $mail->ErrorInfo);
        }    
    }
    
    function send22($htmlBody, $textBody, $subject, $from, $to, $attachment = array())
    {
        $parts = array();
        
        $textPart = new MimePart($textBody);
        $textPart->type = "text/plain";
        $parts[] = $textPart;
        
        $htmlPart = new MimePart($htmlBody);
        $htmlPart->type = "text/html";
        $parts[] = $htmlPart;
        
        $body = new MimeMessage();
        foreach($attachment as $a){
            $tmp = new MimePart(fopen($a['path'], 'r'));
            $tmp->type = $a['mime'].'; name="'.$a['name'].'"';
            $tmp->encoding    = Zend\Mime\Mime::ENCODING_BASE64;
            $tmp->disposition = Zend\Mime\Mime::DISPOSITION_ATTACHMENT;
            $parts[] = $tmp;
        }
        $body->setParts($parts);

        $message = new Zend\Mail\Message();
        $message->setFrom($from);
        $message->addTo($to);
        $message->setSubject($subject);

        //$message->setEncoding("UTF-8");
        $message->setBody($body);
        $message->getHeaders()->get('content-type')->setType('multipart/alternative');

        $transport = new Mail\Transport\Sendmail();
        $transport->send($message);
    }
}