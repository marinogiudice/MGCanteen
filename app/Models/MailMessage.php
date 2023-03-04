<?php

namespace App\Models;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailMessage extends PHPMailer {

    function __construct($name, $from, $to, $subject, $body) {
        parent::__construct(false);
        $this->isSMTP();
        $this->Host = 'yourhost';
        $this->SMTPAuth   = true;                             
        $this->Username   = 'yourUsername';                 
        $this->Password   = 'yourPassword';                        
        $this->SMTPSecure = 'ssl';                              
        $this->Port       = 465;  
        $this->setFrom('setFromAddress', $name);           
        $this->isHTML(false);
        $this->addAddress($to, 'setToAddress');
        $this->addReplyTo($from, $name);                             
        $this->Subject = $name.' - '.$subject;
        $message = nl2br("sender: ".$from."\r\n\r\n".$body);
        $this->Body    = $message;
        $this->AltBody = $message;
    }

    public function send() {
        if(parent::send()) {
            return true;
        }
        return false;
    }
}