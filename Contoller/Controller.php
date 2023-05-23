<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Controller 
{

    /**
    * Send an email to the admin with the subject and content passed by parameter
    * returns a message with the result of the sending
    */  

    static function mail_to_admin ($asunto , $contenido) 
    {

        require './PHPMailer/src/Exception.php';
        require './PHPMailer/src/PHPMailer.php';
        require './PHPMailer/src/SMTP.php';

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        
        try 
        {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'your_mailserver';                  //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'you_mail_user';                     //SMTP username
            $mail->Password   = '}q11WLDDW;m{';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('you_mail_user', 'your_name');
            $mail->addAddress('you_mail_user');     //Add a recipient
        
            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body = "<h1>$asunto</h1>
                            <p>$contenido</p>";
            $mail->AltBody = $contenido;
        
            $mail->send();
            $result = 'Message has been sent';
            return $result;
        } 
        
        catch (Exception $e) 
        {
            $log_error = $mail->ErrorInfo;
            $result = "An error has occurred while sending mail.";
            return $result;
        }
    }
}
