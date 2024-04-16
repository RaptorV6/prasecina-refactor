<?php
namespace ScriptsSC;

class FileLog {
    
    public static function log($filePath, $message) { 
        $file = fopen($filePath, "a") or die("Nelze otevřít logovací soubor!");
        fwrite($file, $message);
        fclose($file);
    }
    
}
