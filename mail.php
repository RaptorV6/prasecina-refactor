<?php
namespace ScriptsSC;
ini_set("default_charset","UTF-8");
use mysqli;
use PHPMailer\PHPMailer\PHPMailer;

use function Composer\Autoload\includeFile;

require __DIR__ . '/scripts_sdilene/bootstrap.php';

error_reporting(E_ALL);

class LPSZ {
    
    public function run() {
       $zadost = null;
        $dbCor = DatabaseConnector::getOpenPgSQLPDOConnector('10.40.20.201', '5432', 'vpov', 'vpov_user', 'heslo123456');
        try {
            $dbCor->checkConnection("Database connection to pgadmin error");
            
            $rows = $dbCor->executeQuery('SELECT * FROM "ZADANKA" WHERE "ID_ZADANKA" = ?', CommonFunc::safeGET("id"));

            if(!$rows){
                echo " ";
                }else{
                $row = $rows[0];
                } 



$cislo = $row['UNIQ'];
$uzivatel = $row['UZIVATEL'];
$odeb = $row['ODEB'];
$prijemce = $row['PRIJEMCE'];
 
$zadost = $cislo;

echo $cislo;

$mess = 'Uživatel <b> '.$uzivatel.' </b> z <b> '.$odeb.'</b> založil/a žádanku č.<b>'. $cislo .'</b> 
<table width="100%" cellspacing="0" cellpadding="0">
  <tr>
      <td>
          <table cellspacing="0" cellpadding="0">
              <tr>
                  <td style="border-radius: 2px;" bgcolor="#004b87">
					  <a href="http://10.40.30.5/vpov/check.php?zadanka='. $zadost .'" style="padding: 8px 12px; border: 1px solid #004b87;border-radius: 2px;font-family: Helvetica, Arial, sans-serif;font-size: 16px; color: #ffffff; text-decoration: none; font-weight:bold;display: inline-block;">
					  Přejít ke schválení</a> 
                  </td>
              </tr>
          </table>
      </td>
  </tr>
</table>
 </br></br> '; 

 $zprava = "Nová žádanka byla úspěšně založena a čeká na schválení u příjemce" . $prijemce . "<br><br><br>";

require_once 'scripts_sdilene/PHPMailerWrapper.php'; 
$mailerWrapper = new \ScriptsSC\PHPMailerWrapper();



if ($uzivatel == "Bc. Michaela Vavřincová") {
	    $mailerWrapper->setRecipients($prijemce);
    $mailerWrapper->setFromMailerConfig('vpov@nember.cz','VPOV');
    $mailerWrapper->setContent('VÝDEJKA-PŘEVODKA-ODPIS-VÝMĚNA',$mess,$mess,$mess);
    $mailerWrapper->send();  
    $mail =  new \ScriptsSC\PHPMailerWrapper();
    $mail->getPHPMailer()->clearAllRecipients();
    $mail->getPHPMailer()->addAddress("vavrincova@nember.cz");
    $mail->setFromMailerConfig('vpov@nember.cz','VPOV');
    $mail->setContent('VPOV-LOG',$zprava,$zprava,$zprava);
    $mail->send(); 
}elseif($prijemce == $prijemce){
    $mailerWrapper->setRecipients($prijemce);
    $mailerWrapper->setFromMailerConfig('vpov@nember.cz','VPOV');
    $mailerWrapper->setContent('VÝDEJKA-PŘEVODKA-ODPIS-VÝMĚNA',$mess,$mess,$mess);
    $mailerWrapper->send();  
}

header("location: index.php");

}
      catch (\Exception $e) {
 CommonFunc::processException($e, 'Chyba' . $e->getMessage());
}
}

}

(new LPSZ())->run();

?>
