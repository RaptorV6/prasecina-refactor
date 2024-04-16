<?php
namespace ScriptsSC;
ini_set("default_charset","UTF-8");
use mysqli;

use function Composer\Autoload\includeFile;

require __DIR__ . '/scripts_sdilene/bootstrap.php';

error_reporting(E_ALL);

class LPSZ {
    
    public function run() {
        // připojení k databázi berounské mKarty
        $dbCor = DatabaseConnector::getOpenPgSQLPDOConnector('10.40.20.201', '5432', 'vpov', 'vpov_user', 'heslo123456');
	        try {
            $dbCor->checkConnection("Database connection to pgadmin error");
            	
            if (isset($_POST['schvalit'])) {
				$check= $dbCor->executeQuery('UPDATE "ZADANKA" SET "STATUS" = :status, "PRIJAL" = :prijal WHERE "UNIQ" = '. $_POST['zadanka'] .'',
				['status' => "Schváleno",
				'prijal' => CommonFunc::safePOST("prijala")
			]);
//poslání mailu

		
			$prijal = CommonFunc::safePOST("prijala");
			$id = CommonFunc::safePOST("id");
			$zpusob = CommonFunc::safePOST("zpusob");
			
			$zprava1 = "Žádanka(". $id .") byla <b> schválena </b>  příjemcem " . $prijal . "<br><br>" . "Vytiskněte si jej zde " . 
			'<table width="100%" cellspacing="0" cellpadding="0">
  <tr>
      <td>
          <table cellspacing="0" cellpadding="0">
              <tr>
                  <td style="border-radius: 2px;" bgcolor="#004b87">
					  <a href="http://nb-printserver/vpov/print.php?id='. $id .'" style="padding: 8px 12px; border: 1px solid #004b87;border-radius: 2px;font-family: Helvetica, Arial, sans-serif;font-size: 16px; color: #ffffff; text-decoration: none; font-weight:bold;display: inline-block;">
					  Přejít na tisk</a> 
                  </td>
              </tr>
          </table>
      </td>
  </tr>
</table>';
			require_once 'scripts_sdilene/PHPMailerWrapper.php'; 
			$mailerWrapper = new \ScriptsSC\PHPMailerWrapper();
			$mailerWrapper->setRecipients($zpusob);
			$mailerWrapper->setFromMailerConfig('vpov@nember.cz','VPOV');
			$mailerWrapper->setContent('VPOV-TISK',$zprava1,$zprava1);
			$mailerWrapper->send(); 

				header('Location:index.php');
			}

			if (isset($_POST['zamitnout'])) {
				$check= $dbCor->executeQuery('UPDATE "ZADANKA" SET "STATUS" = :status, "PRIJAL" = :prijal WHERE "UNIQ" = '. $_POST['zadanka'] .' ',
				['status' => "Zamítnuto",
				'prijal' => CommonFunc::safePOST("prijala")
			]);

//poslání mailu2			
		
			$prijal = CommonFunc::safePOST("prijala");
			$id = CommonFunc::safePOST("id");
			$zprava2 = "Žádanka(". $id .") byla <b> zamítnuta </b>  příjemcem " . $prijal . "<br><br>";
			require_once 'scripts_sdilene/PHPMailerWrapper.php'; 
			$mailerWrapper = new \ScriptsSC\PHPMailerWrapper();
			$mailerWrapper->setRecipients('vavrincova@nember.cz');
			$mailerWrapper->setFromMailerConfig('vpov@nember.cz','VPOV');
			$mailerWrapper->setContent('VPOV-LOG',$zprava2,$zprava2);
			$mailerWrapper->send(); 
			}
			header('Location:index.php');
		}

	 catch (\Exception $e) {
		
		CommonFunc::processException($e, 'Chyba' . $e->getMessage());
		}

		}


		}
		
		(new LPSZ())->run();
		?>