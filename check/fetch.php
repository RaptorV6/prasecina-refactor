<?php
	
Class Connection{
 
	private $server = "pgsql:host=10.40.20.201;port=5432;dbname=vpov";
	private $username = "vpov_user";
	private $password = "heslo123456";
	private $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,);
	protected $conn;
 	
	public function open(){
 		try{
 			$this->conn = new PDO($this->server, $this->username, $this->password, $this->options);
 			return $this->conn;
 		}
 		catch (PDOException $e){
 			echo "There is some problem in connection: " . $e->getMessage();
 		}
 
    }
 
	public function close(){
   		$this->conn = null;
 	}
 
}


	$database = new Connection();
	$db = $database->open();
	try{	
	    $sql = 'SELECT * FROM "ZADANKA_POLOZKY" WHERE "UNIQ" = '. $_POST['zadanka'] . ' ';
		

ini_set("default_charset","UTF-8");
	    foreach ($db->query($sql) as $row) {
	    	?>
<tr>

    <td><?php echo $row["NAZEV"]; ?></td>
    <td><?php echo $row["MJ"]; ?></td>
    <td><?php echo $row["MNOZSTVI"]; ?></td>
    <td><?php echo $row["CENA"] . " ,-" ;?></td>
    <td class="precio"><?php echo $row["CELKEM"] . "  ,-"; ?></td>

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
	}
	catch(PDOException $e){
		echo "There is some problem in connection: " . $e->getMessage();
	}

	//close connection
	$database->close();
	
?>