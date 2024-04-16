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
            $rows = $dbCor->executeQuery('SELECT * FROM "ZADANKA_POLOZKY" WHERE "UNIQ" = :uniq ', 
            ['uniq' => CommonFunc::safePOST("uniq")]
        
        );
	    
        foreach ($rows as $row) {
            ?>
<tr>
    <td style="display: none;"><?php echo $row["ID_POLOZKA"]; ?></td>
    <td><?php echo $row["NAZEV"]; ?></td>
    <td><?php echo $row["MJ"]; ?></td>
    <td><?php echo $row["MNOZSTVI"]; ?></td>
    <td><?php echo $row["CENA"] . " ,-" ; ?></td>
    <td class="precio"><?php echo $row["CELKEM"] . "  ,-"; ?></td>

    <td>
        <a href="" class="edit" data-id="<?php echo $row['ID_POLOZKA']; ?>" data-toggle="modal">
            <i class="material-icons update" data-toggle="tooltip" title="Upravit"></i>
        </a>

        <a href="" class="delete" data-id="<?php echo $row["ID_POLOZKA"]; ?>" data-toggle="modal"><i
                class="material-icons" data-toggle="tooltip" title="Delete"></i></a>
    </td>
    
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