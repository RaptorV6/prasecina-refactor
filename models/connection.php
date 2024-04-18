<?php

$database = "mysql";

if ($database == "mysql") {
    $dbconn = mysql_connect("localhost", "root", "") or die("cannot connect");
    mysql_select_db("db_name", $dbcon) or die("cannot select db");
}
?>