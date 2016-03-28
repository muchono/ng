<?php
/**
 * Mail
  */
Yii::setPathOfAlias('Zend',Yii::getPathOfAlias('application.vendors.Zend'));

use Zend\Mail;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class CMail extends CComponent
{
    function send($htmlBody, $textBody, $subject, $from, $to, $attachment = array())
    {
        $htmlPart = new MimePart($htmlBody);
        $htmlPart->type = "text/html";

        $textPart = new MimePart($textBody);
        $textPart->type = "text/plain";

        $body = new MimeMessage();
        $parts = array($textPart, $htmlPart);
        foreach($attachment as $a){
            $tmp = new MimePart(fopen($a['path'], 'r'));
            $tmp->type = $a['mime'].'; name="'.$a['name'].'"';
            $tmp->encoding    = Zend\Mime\Mime::ENCODING_BASE64;
            $tmp->disposition = Zend\Mime\Mime::DISPOSITION_ATTACHMENT;
            $parts[] = $tmp;
        }
        $body->setParts($parts);

        $message = new MailMessage();
        $message->setFrom($from);
        $message->addTo($to);
        $message->setSubject($subject);

        $message->setEncoding("UTF-8");
        $message->setBody($body);
        $message->getHeaders()->get('content-type')->setType('multipart/alternative');

        $transport = new Mail\Transport\Sendmail();
        $transport->send($message);
    }
}