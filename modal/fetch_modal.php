<?php
namespace ScriptsSC;
ini_set("default_charset","UTF-8");
use mysqli;
use ValueError;

use function Composer\Autoload\includeFile;

require __DIR__ . '/../scripts_sdilene/bootstrap.php';

error_reporting(E_ALL);

class LPSZ {
    
    public function run() {
    
        // připojení k databázi berounské mKarty
        $dbCor = DatabaseConnector::getOpenPgSQLPDOConnector('10.40.20.201', '5432', 'vpov', 'vpov_user', 'heslo123456');

        try {
            $dbCor->checkConnection("Database connection to pgadmin error");
            $rows = $dbCor->executeQuery('SELECT * FROM "ZADANKA_POLOZKY"
            JOIN "ZADANKA" 
            ON "ZADANKA"."UNIQ" = "ZADANKA_POLOZKY"."UNIQ"   
            WHERE "ZADANKA"."ID_ZADANKA" = :id_zadanka  ',['id_zadanka' => CommonFunc::safePOST("id")]);

$info = $dbCor->executeQuery('SELECT * FROM "ZADANKA" WHERE "ID_ZADANKA" = :id_zadanka ',['id_zadanka' => CommonFunc::safePOST("id")]);


if(!$info){
    echo "Uzivatel error";
    }else{
    $inf = $info[0];
    } 

        foreach ($rows as $row) {
            ?>
       

       
<tr style="background-color: white;">
  
    <td ><?php echo $row["NAZEV"]; ?></td>
    <td class="rowdata"><?php echo $row["MJ"]; ?></td>
    <td class="rowdata"><?php echo $row["MNOZSTVI"]; ?></td>
    <td class="rowdata"><?php echo $row["CENA"] . " ,-" ; ?></td>
    <td class="rowdata precio"><?php echo $row["CELKEM"] . "  ,-"; ?></td>
</tr>

<?php }?>
<td style="display: none;" id="wowo"> <?= $inf['UZIVATEL'] ?></td>
<td style="display: none;" id="id_z"> <?= $inf['ID_ZADANKA'] ?></td>
<script type="text/javascript" language="javascript">
$('.total_price2').each(function() {
    var sum = 0;
    $(this).parents('form').find('.precio').each(function() {
        var floted = parseFloat($(this).text());
        if (!isNaN(floted)) sum += floted;
    });

    $(this).html(sum);
});

</script>

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


<?php

        } catch (\Exception $e) {
    CommonFunc::processException($e, 'Chyba' . $e->getMessage());
}
}

}

(new LPSZ())->run();

	
?>