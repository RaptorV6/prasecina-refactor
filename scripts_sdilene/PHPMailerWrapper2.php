<?php
namespace ScriptsSC;

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/Cfg.php';
require_once __DIR__ . '/../scripts_local/CfgPw.php';
    
use \PHPMailer\PHPMailer\PHPMailer;

class PHPMailerWrapper2 extends PHPMailerWrapper {

    

    
  
    
    /**
     * Nastaví obsah zprávy
     * @param string $subject The Subject of the message.
     * @param string $body An HTML or plain text message body. If HTML then call isHTML(true).
     * @param string $altBody The plain-text message body. This body can be read by mail clients that do not have HTML email capability such as mutt & Eudora. Clients that can read HTML will view the normal Body.
     */
    public function setContent2($subject, $body, $altBody, $img) {
        $this->phpMailer->Subject = $subject;
        $this->phpMailer->Body = $body;
        $this->phpMailer->AltBody = $altBody;
        $this->phpMailer->addEmbeddedImage(dirname(__FILE__) . '/../qrcodes/QR.png', 'QR' );
    }
    
    /**
     * Vrátí PHPMailer
     * @return PHPMailer
     */
   

}
?>