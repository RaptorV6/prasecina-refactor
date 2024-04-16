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
            
        

            $dbCor2->checkConnection("Database connection to pgadmin error");
        
       
            $Uzivatel=substr(strtolower($_SERVER['REMOTE_USER']),4);
           
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
			$odd = $uzi['name'];
	
$rows = $dbCor->executeQuery('SELECT * FROM "ZADANKA" WHERE "ODEB" = :odd ORDER BY "ID_ZADANKA" DESC', ['odd' => $odd] );
		$login = preg_replace(array('/[0-9]+/','/\(|\)/'), '', $login);	
		
        ?>

<html>

<head>
    <title>VPOV</title>
	<link rel="shortcut icon" href="title.ico" />
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="bootstrap/js/data-table.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="js/data.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
</head>

<body style=" margin-top: 6%;">
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
                        </div>
                    </div>
                     <div style="display: block;position: absolute;top: -71px;right: 0px; font-size:16px;">
                   
                        Přihlášen/a: <span id="uzi"><?=	$login  ?></span> 
                    </div>

                    <!--------------------------------------------------------------------->
                    <style>
                    th {
                        text-align: center;
                    }

                    td {
                     
                        border: 1px solid #ddd;
                    }
                    </style>

				

                    <a onclick="document.location='zadanka_polozky.php'" class="btn button" id="addnew" data-toggle="modal"
                        title="Přidat nový záznam">
                        <span style="font-size: 20px;">
                            <span class="material-icons" style="position: relative;font-size:27px;">
                                add
                            </span>
                        </span>
                    </a>

                    <br />

                    <div class="animate__animated animate__fadeInUp  ">
                        <div style="width: 100%;">
                            <div class="col-lg-30 mx-auto">
                                <div class="card  ">
                                    <div class="card-body bg-white">
                                        <div class="table-responsive">
                                            <table id="example" style="width:100%"
                                                class="table table-hover  table-bordered">
                                                <thead>
                                                    <tr>
                                                    <th>#</th>
                                                        <th>Oddělení</th>
                                                        <th>Vydávající útvar</th>
                                                        <th>Datum</th>
														<th style="white-space:nowrap">Schválil / zamítl</th>
                                                        <th>Status</th>
                                                        <!--th>Přehled</th-->
                                                    </tr>
                                                </thead>
                                                <tbody class="table-striped">

                                                    <?php foreach($rows as $x){ ?>

                                                    <tr href="" id="test"  class="edit" data-toggle="modal" data-id="<?= $x['ID_ZADANKA']?>" >
                                                    <td><?= $x['ID_ZADANKA']; ?></td>    
                                                    <td><?= $x['ODEB']; ?></td>
                                                        <td class="hov"><?= $x['VYDAV']; ?></td>
                                                        <td class="hov"><?= date("d.m.Y",strtotime($x['DATUM']));?></td>
														<td><?= $x['PRIJAL']; ?></td>
                                                        <td class="hov"><?php 
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


                                                    
                                                    </tr>

                                                    <?php } ?>

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br />
                        <br />
                        <br />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(function() {
        $(document).ready(function() {
            $('#example').DataTable();
        });
    });

    $('#example').dataTable({
    order: [
        [0, 'desc']
    ]
});
    </script>


    <?php include('modal/modal_table.php'); ?>

    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="modal/modal.js"></script>
	
	<?php
}
         catch (\Exception $e) {
    CommonFunc::processException($e, 'Chyba' . $e->getMessage());
}
}

}

(new LPSZ())->run();


?>

</body>

</html>


