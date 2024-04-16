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
	
	$rows = $dbCor->executeQuery('SELECT * FROM "ZADANKA"  
    JOIN "ZADANKA_POLOZKY"
    ON "ZADANKA"."UNIQ" = "ZADANKA_POLOZKY"."UNIQ" WHERE "ID_ZADANKA" = ?' , CommonFunc::safeGET("id"));
		if(!$rows){
			echo "Nebylo nalezeno ID";
		}else{
			$row = $rows[0];
		} 

        $datum = date("d.m.Y",strtotime($row['DATUM']));
        $cislo = $row['UNIQ'];
        $odeb = $row['ODEB'];
        $vydav = $row['VYDAV'];
        $uzivatel = $row['UZIVATEL'];
        $status = $row['STATUS'];
        $prijal = $row['PRIJAL'];
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css" />

    <link rel="shortcut icon" href="title.ico" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>

<style>
@media only screen {
    body {
        background-color: transparent;
    }
    #filtr {
        filter: invert(1) !important;
    }

    page[size="A4"] {
    width: 21cm;
    height: 29.7cm;

    
}


@media print{
    #filtr {
        filter: invert(1) !important;
    }

}

#filtr {
        filter: invert(1) !important;
    }

page {
    background: white;
    display: block;
    margin: 0 auto;
    margin-bottom: 0.5cm;
    box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
}

#filtr {
        filter: invert(1) !important;
    }
.table {
    
        font-size: 20px;
        margin: auto;
        width: 100% !important;
    }
	
	@media all and (min-width: 500px) and (max-width: 1920px) {
    html {
   
		zoom:76%;	


    }
    #filtr {
        filter: invert(1) !important;
    }
}


.total {
        position: fixed;
        left: 34%;
        top: 75%;
        transform: scale(1);
    }

    table th {
        background-color: #004b87;
        color: white;
    }

    table th {
        text-align: center;
    }

    .center {
           margin: auto;
		width: 90%;
    }

    #logo {
        width: 10%;
        margin-bottom: -13px;
    }

      .total {
        position: absolute;
        left: 45%;
        top: 1080px;
        transform: scale(1);
    }
    .hid { border: 1px solid Transparent!important; } 


    #filtr {
        filter: invert(1) !important;
    }
}

.wrp{
    white-space: nowrap;
}


#smaller{
    font-size: 12px;
    position: absolute;
}
</style>

<body>

    <div class="page-header" style="text-align: center">
        <div style="text-align: center;">
            <img id="logo" src="logo.jpg">
        </div>
        <h2>VÝDEJKA-PŘEVODKA-ODPIS-VÝMĚNA</h2>

    </div>

    <page class="page" size="A4">

    <div class="center">

<table>

    <thead>
        <tr>
            <td>
                <!--place holder for the fixed-position header-->
                <div class="page-header-space"></div>
            </td>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>
                <!--*** CONTENT GOES HERE ***-->
                <div class="page">
                    <br><br><br><br>

																								
																								
																								
																									
						<table  class="table table-bordered table-striped table-responsive text-center">																			
					<tr></tr>
                        <th>Odebírající útvar: </th>
                        <td colspan="4"><?= $odeb ?></td>
                        <tr></tr>
                        <th>Vydávající útvar:</th>
                        <td colspan="4"> <?= $vydav ?> </td>
                        <tr > </td> 
                   
                    </tr>
						   </table>																			
																									
																									
																								
																								

                    <table  class="table table-bordered table-striped table-responsive text-center">
                        <thead>
                            <th>Číslo</th>
                            <th>Založil/a</th>
                           
                            <th>Datum</th>
                            <th class="wrp">Schválil / Zamítl</th>
							 <th>Status</th>

                        </thead>
                        <td><?= $cislo?></td>
                        <td><?= $uzivatel ?></td>
                     
                        <td><?= $datum ?></td>
                        <td class="wrp"><?php 
                        if($prijal == "Ing. Petr Šmíd  ") {
                            echo  '<img id="filtr" src="sign_ps.png"  width="100" height="50" > <br>' . "<small id='smaller'>Ing. Petr Šmíd</small>";
                        }elseif($prijal == "Bc. Jan Dobrý  "){
							 echo  '<img id="filtr" src="sign_dj.png"  width="50" height="50" > <br>' . "<small id='smaller'>Bc. Jan Dobrý</small>";
						}
                        else{
                            echo $prijal;
                        }
                        
                        
                     ?></td>
						   <td><?= $status ?></td>
              
             
                        <tr >
                      
                            <td colspan="2" class="tdr" style=" text-align: right;
    background-color: white;
    "><span><b>Suma:</b></span></td>
                            <td style="color: white; background-color:#004b87;"><b><span class="total_price"></span></b></td>
                            <td colspan="2" style="text-align:left; background-color:white;">  <b>,-</b></td>
                         
                             </tr>
                    </table>

      




                    <br><br>

                    <table id="myTable" class="table table-bordered table-striped text-center">
                        <thead>
                            <th>Název</th>
                            <th>MJ</th>
                            <th>Množství</th>
                            <th>Cena</th>
                            <th>Celkem</th>
                        </thead>
                        <tbody>
                            <?php
                        foreach ($rows as $row) {
                           ?>

                            <tr style="background-color: white;">
                                <td><?php echo $row["NAZEV"]; ?></td>
                                <td class="rowdata"><?php echo $row["MJ"]; ?></td>
                                <td class="rowdata"><?php echo $row["MNOZSTVI"]; ?></td>
                                <td class="rowdata"><?php echo $row["CENA"] . " ,-" ; ?></td>
                                <td class="rowdata precio"><?php echo $row["CELKEM"] . "  ,-"; ?></td>
                            </tr>

                            <?php }?>
                        </tbody>

                </div>
    </tbody>


 

    <script type="text/javascript" language="javascript">
    $('.total_price').each(function() {
        var sum = 0;
        $(this).parents('table').find('.precio').each(function() {
            var floted = parseFloat($(this).text());
            if (!isNaN(floted)) sum += floted;
        });

        $(this).html(sum.toLocaleString());
    });
    </script>


</table>

</table>


</div>


</page>

<div class="page-footer">


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Datum výtisku: <?= date("d.m.Y") ?>
</div>

   
</body>
<script>



 jQuery(document).ready(function() {
setTimeout(function() {		  
    window.focus();
    window.print();
    window.close();
	
},1000);
}); 

</script>

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