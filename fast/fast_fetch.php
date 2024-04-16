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
		$dbCor2 = DatabaseConnector::getOpenPgSQLPDOConnector('10.80.1.21', '5432', 'mcallsnb', 'vydejka_prevodka', 'vyprOV4.93');
        try {
            $dbCor->checkConnection("Database connection to pgadmin error");
            $rows = $dbCor->executeQuery('SELECT * FROM "ZADANKA" ORDER BY "ID_ZADANKA" DESC');
        

            $dbCor2->checkConnection("Database connection to pgadmin error");
        
       
           $Uzivatel=substr(strtolower($_SERVER['REMOTE_USER']),4);
           
           $dbCor2->checkConnection("Database connection to pgadmin error");
             $uziv = $dbCor2->executeQuery("SELECT * FROM mkarta_zamestnanci_hlavniprac_hier_v AS hph
             JOIN mkarta_zamestnanci_username_v AS userm 
             ON hph.mkarta_zamestnanci_id = userm.id 
             JOIN org_hierarchy AS hie 
             ON hie.id = hph.org_hierarchy_id 
			 WHERE userm.domain_login = :login AND hie.name = 'Oddělení informatiky' ", ['login' => $Uzivatel ]);


			   if(!$uziv){
            echo "Uzivatel error";
            }else{
            $uzi = $uziv[0];
           } 
		
			$login = $uzi['username'];
		

		$login = preg_replace(array('/[0-9]+/','/\(|\)/'), '', $login);

		
		
      ?>

                   
                                                    <?php foreach($rows as $x){ ?>

                                                    <tr href=""   >
                                                    <td class="edit" data-toggle="modal" data-id="<?= $x['ID_ZADANKA']?>"><?= $x['ID_ZADANKA']; ?></td>    
                                                    <td class="edit" data-toggle="modal" data-id="<?= $x['ID_ZADANKA']?>"><?= $x['ODEB']; ?></td>
                                                        <td class="edit" data-toggle="modal" data-id="<?= $x['ID_ZADANKA']?>" class="hov"><?= $x['VYDAV']; ?></td>
                                                        <td  class="edit" data-toggle="modal" data-id="<?= $x['ID_ZADANKA']?>" class="hov"><?= date("d.m.Y",strtotime($x['DATUM']));?></td>
                                                        <td class="edit" data-toggle="modal" data-id="<?= $x['ID_ZADANKA']?>" class="hov"><?php 
                                                                    $status = $x['STATUS'];
                                                                    if($status == "Schváleno"){
                                                                    echo $status = '<span style="color:green;"><b>Schváleno</b></span>';
                                                                    }
                                                                    elseif($status == "Zamítnuto"){
                                                                    echo $status = '<span style="color:red;"><b>Zamítnuto</b></span>';
                                                                    }
                                                                    else{
                                                                    echo  $status = 'Čeká na schválení';
                                                                    } 
                                                            ?></td>
                                                             <td style="display: none;"><input type="hidden" name="uniq" class="uniq" value="<?= $x['UNIQ']; ?>"></td>
                                                            <td ><button  data-id="<?= $x['ID_ZADANKA']; ?>" type="button" class="btn btn-success yes">Schválit</button> <button  data-id="<?= $x['ID_ZADANKA']; ?>" type="button" class="btn btn-danger no">Zamítnout</button></td>
                                                  
                                                        </tr>

                                                    <?php } ?>

                                               


	<?php
}
         catch (\Exception $e) {
    CommonFunc::processException($e, 'Chyba' . $e->getMessage());
}
}

}

(new LPSZ())->run();


?>



                                                