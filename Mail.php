<?php 

require("PHPMailer.php");
require("SMTP.php");
require("Exception.php");

class Mail{
    private $senderMailId; 
    private $senderPassword;
    private $senderName;

    public function sendText($receiver,$subject,$message){

        $mail = new PHPMailer\PHPMailer\PHPMailer();
    
        session_start();
    
        try { 
            $mail->SMTPDebug = 2;                                        
            $mail->isSMTP();                                             
            $mail->Host       = 'smtp.gmail.com';//To Change based on hosting                  
            $mail->SMTPAuth   = true;                              
            $mail->Username   = $this->senderMailId;                  
            $mail->Password   = $this->$senderPassword;                         
            $mail->SMTPSecure = 'tls';                               
            $mail->Port       = 587;   
          
            $mail->setFrom($this->senderMailId, $this->senderName);            
            $mail->addAddress($receiver);
               
            $mail->isHTML(true);                                   
            $mail->Subject = $subject; 
            $mail->Body    = $message; 
            if($mail->send()){
                $_SESSION['message']='Mail has been sent successfully';
                return true;
            }else{
                $_SESSION['message']='Sending mail failed';
                return false;
            }
        } catch (Exception $e) { 
            $_SESSION['message']='Sending mail failed';
            return false;
        } 
    }
    
    public function sendAttachment($subject,$message,$file){
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPDebug = 2;
        $mail->isSMTP();                                             
        $mail->Host       = 'smtp.gmail.com';//To Change based on hosting                      
        $mail->SMTPAuth   = true;                              
        $mail->Username   = $this->senderMailId;                  
        $mail->Password   = $this->senderPassword;                         
        $mail->SMTPSecure = 'tls';                               
        $mail->Port       = 587;
        // set subject
        $mail->setFrom($this->senderMailId,$this->senderName); 
        $mail->addAddress($this->senderMailId);
        $mail->addAttachment($file, '<<File Name>>');
    
        $mail->IsHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        if (!$mail->send()) {
            return false;
        } else {
            unlink($file);
            return true;
        }
    }
}

?>