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
            
	if ($insert = $dbCor->executeQuery('INSERT INTO "ZADANKA_POLOZKY" ("NAZEV", "MJ", "MNOZSTVI", "CENA", "CELKEM", "UNIQ") VALUES (:nazev, :mj, :mnozstvi, :cena, :celkem, :uniq)',
	['nazev' => $_POST['nazev'],
	'mj' => $_POST['mj'],
	'mnozstvi' => $_POST['mnozstvi'],
	'cena' => $_POST['cena'],
	'celkem' => $_POST['celkem'],
	'uniq' =>$_POST['uniq']
	])) {
		$output['message'] = 'Úspěšně přidáno';
	}
	else {
		$output['error'] = true;
		$output['message'] = 'Chybně zapsaná položka';
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