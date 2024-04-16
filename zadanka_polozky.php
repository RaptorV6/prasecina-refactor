<?php
namespace ScriptsSC;
ini_set("default_charset","UTF-8");
use mysqli;

use function Composer\Autoload\includeFile;

require __DIR__ . '/scripts_sdilene/bootstrap.php';

error_reporting(E_ALL);

class LPSZ {
    
    public function run() {
        $posledni = null;
        // připojení k databázi berounské mKarty
        $dbCor = DatabaseConnector::getOpenPgSQLPDOConnector('10.40.20.201', '5432', 'vpov', 'vpov_user', 'heslo123456');
		$dbCor2 = DatabaseConnector::getOpenPgSQLPDOConnector('10.80.1.21', '5432', 'mcallsnb', 'vydejka_prevodka', 'vyprOV4.93');
        try {
            $dbCor->checkConnection("Database connection to pgadmin error");
            
			$dbCor2->checkConnection("Database connection to pgadmin error");
        
       
            $Uzivatel=substr(strtolower($_SERVER['REMOTE_USER']),4);
           
            $dbCor2->checkConnection("Database connection to pgadmin error");

            $uziv = $dbCor2->executeQuery("SELECT zu.username, ohs.name AS name FROM mkarta_zamestnanci_username_v AS zu
            JOIN LATERAL (SELECT name FROM org_hierarchy_employee AS ohe
                 JOIN org_hierarchy AS oh ON ohe.org_hierarchy_id = oh.id
                 JOIN org_hierarchy_employee_type AS ohet ON ohe.relation_type_id = ohet.type_id
                 LEFT JOIN mkarta_uvazky AS u ON ohe.uvazek_id = u.id
                 WHERE ohe.mkarta_zamestnanci_id = zu.id
                 ORDER BY ohet.workplace DESC, u.uvazek DESC NULLS LAST LIMIT 1) AS ohs ON true
            WHERE zu.id IN
            (SELECT zamestnanec_id FROM mkarta_pracovni_pomer AS pp
                 WHERE pp.zamestnanec_id = zu.id AND (pp.od IS NULL OR pp.od <= NOW()::date) AND (pp.do IS NULL OR pp.do >= NOW()::date) AND pp.active)
             AND zu.domain_login = :login", ['login' => $Uzivatel ]);
       

    /*          $uziv = $dbCor2->executeQuery("SELECT * FROM mkarta_zamestnanci_hlavniprac_hier_v AS hph
             JOIN mkarta_zamestnanci_username_v AS userm 
             ON hph.mkarta_zamestnanci_id = userm.id 
             JOIN org_hierarchy AS hie 
             ON hie.id = hph.org_hierarchy_id
             WHERE userm.domain_login = :login", ['login' => $Uzivatel ]); */


			    if(!$uziv){
            echo "Uzivatel error";
            }else{
            $uzi = $uziv[0];
            } 
		
			$login = $uzi['username'];
			$oddeleni = $uzi['name'];
		

		$login = preg_replace(array('/[0-9]+/','/\(|\)/'), '', $login);
   
   if (isset($_POST['send'])) {
         $insert = $dbCor->executeQuery('INSERT INTO "ZADANKA" ("ODEB","VYDAV","PRIJEMCE","DATUM","STATUS", "UNIQ", "UZIVATEL", "PRIJAL", "ZPUSOB") VALUES (:odeb, :vydav, :prijemce, :datum,:status, :uniq, :uzivatel, :prijal, :zpusob)',
         ['odeb' => CommonFunc::safePOST("odeb"),
         'vydav' => CommonFunc::safePOST("vydav"),
         'prijemce' => CommonFunc::safePOST("email"),
         'datum' => CommonFunc::safePOST("datum"),
         'status' => CommonFunc::safePOST("status"),
         'uniq' => CommonFunc::safePOST("neco"),
		 'uzivatel' => CommonFunc::safePOST("uzivatel"),
         'prijal' => CommonFunc::safePOST("prijal"),
         'zpusob' => CommonFunc::safePOST("zpusob")
         ]);
                         
         $posledni = $dbCor->lastInsertId(); 
         header("location: mail.php?id=".$posledni);
            }
			
			

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
    <link rel="stylesheet" type="text/css" href="css/style.css">
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

                            <div style="display: block;position: absolute;top: -71px;right: 0px; font-size:16px;">
                              
                                Přihlášen/a: <?= $login ;  ?>
                               
                            </div> 

                            <div class="col-sm-6 noprint" style="margin-bottom: 10px;margin-top: -14%;">

                                <a onclick="document.location='index.php'" class="btn" id="gobackbutton"
                                    data-toggle="modal" title="Zpět na předchozí stránku">
                                    <span style="font-size: 20px;">
                                        <span class="material-icons" style="position: relative;top: 5px;">
                                            arrow_back
                                        </span>
                                    </span>
                                </a>

                            </div>

                        </div>

                        <br>


                        <input type="hidden" class="uniform" name="uniq" value="<?=abs(crc32(uniqid() ) ); ?>"
                            id="uniqtest">

                        <script>
                        $('#addnew').ready(function() {

                            var source = $('#uniqtest').val();
                            $('#uniq').val(source);
                        });

                        $('#addform').ready(function() {

                            var source = $('#uniqtest').val();
                            $('#uniq').val(source);
                        });

                      
                        </script>




                        <div class="animate__animated animate__fadeInLeft">

                            <div class="row rowo">

                                <div class="col-sm-8 col-sm-offset-2">

                                    <form onsubmit="myFunction()" id="form" method="post">

                                        <table id="myTable" class="table table-bordered table-striped"
                                            style="font-size: 20px;margin-top: 70px;font-size: 20px; text-align:center">
                                            <thead>
                                                <th style=" text-align: center; display:none; ">#</th>
                                                <th style=" text-align: center;">Název</th>
                                                <th style=" text-align: center;">MJ</th>
                                                <th style=" text-align: center;">Množství</th>
                                                <th style=" text-align: center;">Cena</th>
                                                <th style=" text-align: center;"> Celkem</th>
                                            </thead>
                                            <tbody id="tbody">

                                            </tbody>

                                            <tr>
                                                <td colspan="7" class="clickit" id="addnew"><a><i id="addrow"
                                                            class="material-icons">add</i></a></td>
                                            </tr>

                                            <tr class="total">
                                                <td><span><b>Suma:</b></span></td>
                                                <td style="color: white; background-color:#004b87;"><b><span
                                                            class="total_price"></span></b></td>
                                                <td> <b>,-</b></td>
                                            </tr>

                                            <td class="hidden"><span class="total_price2"></span></td>
                                            <input type="hidden" name="suma" id="suma">

                                            <script>
                                            // This function gets called once the user submits the form
                                            function myFunction() {

                                                // First get the value from the cronMDMtimer-span
                                                suma = $('.total_price2').html();

                                                // Then store the extracted timerValue in a hidden form field
                                                $("#suma").val(suma);

                                                // submit the form using it's ID "my-form"
                                                $("#form").submit();
                                            }
                                            </script>

                                        </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="position: static;" class="wrapper"></div>
                    <style>
                    td {
                        background-color: white;
                    }
                    </style>

                    <div class="animate__animated animate__fadeInRight">
                  
						<input type="hidden" name="uzivatel" value="<?= $login ?>" />
                        <input type="hidden" name="status" value="Čeká na schválení">
                        <input type="hidden" name="prijal" value=" - ">
                        <input type="hidden" name="datum" value="<?= date("d.m.Y") ?>">

                        <input type="hidden" name="neco" class="uniq" >

                        <div class="form-group input one">
                            <label>Odebírající útvar</label>
                            <input type="text" id="odeb" name="odeb" class="form-control" value="<?= $oddeleni ?>" />
                        </div>

                        <div class="form-group input two">
                            <label>Vydávající útvar</label>
                            <input type="text" id="vydav" name="vydav"  class="form-control" required/>
                        </div>

                        <div class="list-group input right">
                            <label style="position: relative;right: 156%;">Zvolit příjemce</label>
                            <select style="position: relative;left: -90%;
" type="text" id="email" name="email" class="form-control submit">
                                <option name="first_name" value="natasa@multiscan.cz">Ředitelka</option>
                                <option value="povolny@nember.cz">Náměstek pro LPP</option>
                                <option value="kupkova@nember.cz">Hlavní sestra</option>
								<option value="dobry@nemocnice-horovice.cz">Bc. Jan Dobrý</option>
                                <option value="smid@nember.cz">Ing. Petr Šmíd</option>
							
                            </select>
                        </div>
						
						   					
						                        <div class="list-group input right">
                            <label style="position: relative;right: 141%;">Způsob</label>
                            <select style="position: relative;left: -71%;
" type="text" id="zpusob" name="zpusob" class="form-control submit">
                                     <option value="vincalkova@nember.cz">Dobírka</option>
                                <option value="uctarna@nember.cz">Faktura</option>
							
                            </select>
                        </div>
						

						                     <script>
											 $('.total_price2').on('DOMSubtreeModified',function(){
                                              var a = $('.total_price2').text();
                                              var b = $('input[name=odeb]').val();
                                            if(a <= 5000  && b == "Oddělení informatiky" ){
                                                $('#email option[value="dobry@nemocnice-horovice.cz"]').attr("selected", "selected");
                                                }else{
                                                    $('#email option[value="natasa@multiscan.cz"]').attr("selected", "selected");
                                                }
                                                })
											</script>

                        <button style="
    position: relative;
    left: 20%;
" type="submit"  class="btn btn-primary noprint  right" id="submitthelist" name="send"><span
                                id="text" href="mail.php?id=<?=  $posledni;   ?>">Odeslat
                                ke schválení</span></button>

                        </form>

                    </div>

                    <!-- Modals -->
                    <?php include('modal.html'); ?>
                    <script src="jquery.min.js"></script>
                    <script src="bootstrap/js/bootstrap.min.js"></script>
                    <script src="app.js"></script>
</body>

</html>

<?PHP
} catch (\Exception $e) {
    CommonFunc::processException($e, 'Chyba' . $e->getMessage());
}
}

}

(new LPSZ())->run();
?>