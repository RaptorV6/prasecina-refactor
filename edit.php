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
		$output = array('error' => false);
        try {
            $dbCor->checkConnection("Database connection to pgadmin error");
            
	if ($insert = $dbCor->executeQuery('UPDATE "ZADANKA_POLOZKY" SET "NAZEV"=:nazev, "MJ"=:mj, "MNOZSTVI"=:mnozstvi, "CENA"=:cena, "CELKEM"=:celkem WHERE "ID_POLOZKA" =:id_polozka '
	,[  'nazev' => CommonFunc::safePOST("nazev"),
		'mj' => CommonFunc::safePOST("mj"),
		'mnozstvi' => CommonFunc::safePOST("mnozstvi"),
		'cena' => CommonFunc::safePOST("cena"),
		'celkem' =>  CommonFunc::safePOST("celkem"),
		'id_polozka' => CommonFunc::safePOST("id")	
	]
	
	)) {
		$output['message'] = 'edited';
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