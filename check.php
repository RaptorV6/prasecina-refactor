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
		$dbCor2 = DatabaseConnector::getOpenPgSQLPDOConnector('10.80.1.21', '5432', 'mcallsnb', 'vydejka_prevodka', 'vyprOV4.93');
        try {
            $dbCor->checkConnection("Database connection to pgadmin error");
        
            $rows = $dbCor->executeQuery('SELECT * FROM "ZADANKA" WHERE "UNIQ" = :uniq  ORDER BY "ID_ZADANKA" DESC', ['uniq' => CommonFunc::safeGET("zadanka")]);
            if(!$rows){
                echo "Uzivatel error";
                }else{
                $row = $rows[0];
                }      
       
			$dbCor2->checkConnection("Database connection to pgadmin error");
        
       
               $Uzivatel=substr(strtolower($_SERVER['REMOTE_USER']),4);
           
			   $dbCor2->checkConnection("Database connection to pgadmin error");

                 foreach([$Uzivatel,'nb' . $Uzivatel] as $u){
            $uziv_res = $dbCor2->executeQuery("SELECT zu.username, ohs.name AS name FROM mkarta_zamestnanci_username_v AS zu
            JOIN LATERAL (SELECT name FROM org_hierarchy_employee AS ohe
                 JOIN org_hierarchy AS oh ON ohe.org_hierarchy_id = oh.id
                 JOIN org_hierarchy_employee_type AS ohet ON ohe.relation_type_id = ohet.type_id
                 LEFT JOIN mkarta_uvazky AS u ON ohe.uvazek_id = u.id
                 WHERE ohe.mkarta_zamestnanci_id = zu.id
                 ORDER BY ohet.workplace DESC, u.uvazek DESC NULLS LAST LIMIT 1) AS ohs ON true
            WHERE zu.id IN
            (SELECT zamestnanec_id FROM mkarta_pracovni_pomer AS pp
                 WHERE pp.zamestnanec_id = zu.id AND (pp.od IS NULL OR pp.od <= NOW()::date) AND (pp.do IS NULL OR pp.do >= NOW()::date) AND pp.active)
             AND zu.domain_login = :login", ['login' => $u ]);

                if($uziv_res){
					
                    break;
                }

            }
       


			    if(!$uziv_res){
            echo "Uzivatel error";
            }else{
            $uzi = $uziv_res[0];
            } 
		
			$login = $uzi['username'];
			$oddeleni = $uzi['name'];
		

		$login = preg_replace(array('/[0-9]+/','/\(|\)/'), '', $login);
		
	
        ?>

<!DOCTYPE html>
<html>

<head>
    <link rel="shortcut icon" href="title.ico" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VPOV</title>
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/check.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
</head>

<body id="size">
    <div id="wrapper">
        <div class="printarea">
            <div class="container-lg">
                <img src="logo.jpg" alt="Trulli" class="logo">
                <p id="success"></p>
                <div class="table-wrapper">
                    <div class="table-title">

                        <div class="row">
                            <div class="col-sm-6">
                                <h2 class="nadpis">VÝDEJKA-PŘEVODKA-ODPIS-VÝMĚNA </h2>
                            </div>

                            <div style="position: static;" class="wrapper"></div>
                            <br>

                            <style>
                            td {
                                background-color: white;
                            }
                            </style>


                            <div style="display: block;position: absolute;top: -71px;right: 0px; font-size:16px;">
   Přihlášen/a: <span id="uzi"><?=	$login  ?></span> 
                            </div>


                            <div class="col-sm-6 noprint" style="margin-bottom: 10px;margin-top: -14%;">

                            </div>

                        </div>

                        <br>
             
					
                        <div class="animate__animated animate__fadeInDown animate__delay-1s ">
                  
                            <div class="row rowo">
                            <center>Založil/a: <b><?= $row['UZIVATEL'];?></b> </center>
                            <center>Oddělení: <b><?= $row['ODEB'];?></b> </center>
                                <div class="col-sm-8 col-sm-offset-2">

                                    <table id="myTable" class="table table-bordered table-striped"
                                        style="font-size: 20px;margin-top: 15px;font-size: 20px; text-align:center">
                                        <thead>
                                            <th>Název</th>
                                            <th>MJ</th>
                                            <th>Množství</th>
                                            <th>Cena</th>
                                            <th>Celkem</th>
                                        </thead>
                                        <tbody id="tbody">

                                        </tbody>

                                        <tr class="total">
                                            <td><span><b>Suma:</b></span></td>
                                            <td style="color: white; background-color:#004b87;"><b><span
                                                        class="total_price"></span></b></td>
                                            <td> <b>,-</b></td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                        </div>
						
						     <!-- div id="loading" class="animate__animated animate__fadeOut animate__delay-1s">
								<img src="loading.gif" >
							</div --> 
                    </div>

                    <div style="position: static;" class="wrapper"></div>

                    <form action="insert.php" method="post">
                        <div id="levo" class="animate__animated animate__fadeInLeft">

                                <button type="submit" class="btn-primary  left" id="submitthelist"
                                    name="zamitnout"><span id="text">Zamítnout</span></button>

                        </div>

                        <input type="hidden" name="prijala" value="<?=$login?>">
						<input type="hidden" name="id" value="<?=$row['ID_ZADANKA']?>">
						  <input type="hidden" name="zpusob" value="<?= $row['ZPUSOB'] ?>">

                        <div class="animate__animated animate__fadeInRight">

                           

                                <button type="submit" class="btn-primary right" id="submitthelist" name="schvalit"><span
                                        id="text">Schválit</span></button>


                      
                        </div>


                        <input type="hidden" name="zadanka" class="zadanka" id=""
                                    value="<?= $_GET['zadanka'] ?>">
                    </form>

                </div>
            </div>



            <!-- Modals -->
            <script src="jquery.min.js"></script>
            <script src="bootstrap/js/bootstrap.min.js"></script>
            <script src="check.js"></script>
</body>

</html>

	<?php
}
         catch (\Exception $e) {
    CommonFunc::processException($e, 'Chyba' . $e->getMessage());
}
}

}

(new LPSZ())->run();


?>