<?php
namespace ScriptsSC;

require_once 'Cfg.php';
require_once 'PHPMailerWrapper.php';

class CommonFunc {
    
    const DATETIME_YMD = 'Y-m-d';
    const DATETIME_YMDHIS = 'Y-m-d H:i:s';

    public static function getCurrentYmdDate() {
        return static::getCurrentTime(self::DATETIME_YMD);
    }
    
    public static function getCurrentYmdHisTime() {
        return static::getCurrentTime(self::DATETIME_YMDHIS);
    }
    
    public static function getCurrentTime($format) {
        return (new \DateTime())->format($format);
    }
    
    /**
     * Vrátí oescapovaný GET parametr
     * @param object $param název parametru
     * @return object oescapovaná hodnota
     */
    public static function safeGET($param) {
        return filter_input(INPUT_GET, $param, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    /**
     * Vrátí oescapovaný POST parametr
     * @param object $param název parametru
     * @return object oescapovaná hodnota
     */
    public static function safePOST($param) {
        return filter_input(INPUT_POST, $param, FILTER_SANITIZE_SPECIAL_CHARS);
    }
    
    /**
     * Vrátí oescapovaný POST parametr, nebo v případě, že tento není nastaven, vrátí oescapovaný GET parametr
     * @param object $param název parametru
     * @return object oescapovaná hodnota
     */
    public static function safePOSTorGET($param) {
        return self::safePOST($param) ? self::safePOST($param) : self::safeGET($param);
    }

    public static function escapeString($string) {
        return addslashes($string);
    }
    
    /**
     * Vrátí zadaný longopt z getopt funkce, s vyžadovanou zadanou hodnotou
     * @param string $option název longopt
     * @return string hodnota longopt
     */
    public static function getLongOpt($option) {
        $options = getopt(null, array($option . ':'));
        return ($options) ? $options[$option] : false;
    }
    
    public static function processException($exception, $title, $isRethrow = true) {
        $message = $exception->getMessage();
        
        echo $message;

        $mailerWrapper = new PHPMailerWrapper();

        $mailerWrapper->setRecipients(Cfg::PHPMAILER_EXCEPTION_RECIPIENTS);
        $mailerWrapper->setContent($title, $message, $message);
        $mailerWrapper->send();

        if($isRethrow) {
            throw $exception;
        }
    }
    
}
