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

        try {
            $dbCor->checkConnection("Database connection to pgadmin error");
            $rows = $dbCor->executeQuery('SELECT * FROM "ZADANKA_POLOZKY"
            JOIN "ZADANKA" 
            ON "ZADANKA"."ID_ZADANKA" = "ZADANKA_POLOZKY"."ID_ZADANKA"
            WHERE "ZADANKA"."ID_ZADANKA" = :id_zadanka  ',['id_zadanka' => CommonFunc::safePOST("id")]);
	    
        foreach ($rows as $row) {
            ?>
       
<tr>
  
    <td class="rowdata"><?php echo $row["NAZEV"]; ?></td>
    <td class="rowdata"><?php echo $row["MJ"]; ?></td>
    <td class="rowdata"><?php echo $row["MNOZSTVI"]; ?></td>
    <td class="rowdata"><?php echo $row["CENA"] . " ,-" ; ?></td>
    <td class="rowdata precio"><?php echo $row["CELKEM"] . "  ,-"; ?></td>
</tr>

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
}
        } catch (\Exception $e) {
    CommonFunc::processException($e, 'Chyba' . $e->getMessage());
}
}

}

(new LPSZ())->run();

	
?>