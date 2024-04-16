<?php
namespace ScriptsSC;
ini_set("default_charset","UTF-8");
use mysqli;

require __DIR__ . '/scripts_sdilene/bootstrap.php';

error_reporting(E_ERROR);

class LPSZ {
    
    public function run() {

        $dbCor = DatabaseConnector::getOpenPgSQLPDOConnector('10.40.20.201', '5432', 'vpov', 'vpov_user', 'heslo123456');
        
        try {
            $dbCor->checkConnection("Database connection to Akord error");
            
        
            $dbCor->executeQuery('DELETE FROM "ZADANKA" AS ZA
			USING "ZADANKA_POLOZKY" AS ZP
			WHERE  ZA."ID_ZADANKA" = :id',
            [ 
                'id' => CommonFunc::safeGET("id")
            ]);

            
			header("Location: index.php");


} catch (\Exception $e) {
    CommonFunc::processException($e, 'Chyba' . $e->getMessage());
}
}

}

(new LPSZ())->run();
?>