<?php
namespace ScriptsSC;
ini_set("default_charset","UTF-8");
use mysqli;

use function Composer\Autoload\includeFile;

require __DIR__ . '/../scripts_sdilene/bootstrap.php';

error_reporting(E_ALL);

class LPSZ {
    
    public function run() {
     
        // připojení k databázi berounské mKarty
        $dbCor = DatabaseConnector::getOpenPgSQLPDOConnector('10.40.20.201', '5432', 'vpov', 'vpov_user', 'heslo123456');
		$output = array('error' => false);
        try {
            $dbCor->checkConnection("Database connection to pgadmin error");
            
	if ($insert = $dbCor->executeQuery('UPDATE "ZADANKA" SET "STATUS" = :status, "PRIJAL" = :prijal WHERE "ID_ZADANKA" = '. $_POST['id'] .'',
	['status' => "Schváleno",
	'prijal' => CommonFunc::safePOST("loginos")
				
			])) {
					$prijal = CommonFunc::safePOST("loginos");
			$id = CommonFunc::safePOST("id");
			$zprava1 = "Žádanaka(". $id .") byla <b> schválena </b>  příjemcem " . $prijal . "<br><br>";
			require_once '/../scripts_sdilene/PHPMailerWrapper.php'; 
			$mailerWrapper = new \ScriptsSC\PHPMailerWrapper();
			$mailerWrapper->setRecipients('vavrincova@nember.cz');
			$mailerWrapper->setFromMailerConfig('vpov@nember.cz','VPOV');
			$mailerWrapper->setContent('VPOV-LOG',$zprava1,$zprava1);
			$mailerWrapper->send(); 
		$output['message'] = 'Úspěšně přidáno';
	}
	else {
		$output['error'] = true;
		$output['message'] = 'Něco je špatně';
	}	
		

 
		} catch (\Exception $e) {
			$output['error'] = true;
			$output['message'] = CommonFunc::processException($e, 'Chyba' . $e->getMessage());
		}
		echo json_encode($output);
		}


		}
		
		(new LPSZ())->run();
		?>