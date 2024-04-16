<?php
namespace ScriptsSC;

require_once 'connector/PgSQLConnector.php';
require_once 'connector/PgSQLPDOConnector.php';
require_once 'connector/MSSQLConnector.php';
require_once 'connector/MSSQLPDOConnector.php';
require_once 'connector/MySQLConnector.php';
require_once 'connector/FbSQLConnector.php';

class CustomDatabaseConnector {
    
    public static function getOpenPgSQLConnector($server, $port, $dbName, $dbUser, $dbPassword) {
        $pgSqlConnector = new PgSQLConnector();
        $pgSqlConnector->connect($server, $port, $dbName, $dbUser, $dbPassword);
        return $pgSqlConnector; 
    }
    
    public static function getOpenPgSQLPDOConnector($server, $port, $dbName, $dbUser, $dbPassword) {
        $pgSqlPdoConnector = new PgSQLPDOConnector();
        $pgSqlPdoConnector->connect($server, $port, $dbName, $dbUser, $dbPassword);
        return $pgSqlPdoConnector; 
    }
    
    public static function getOpenMSSQLConnector($server, $dbName, $dbUser, $dbPassword) {
        $msSqlConnector = new MSSQLConnector();
        $msSqlConnector->connect($server, $dbName, $dbUser, $dbPassword);
        return $msSqlConnector; 
    }
    
    public static function getOpenMSSQLPDOConnector($server, $dbName, $dbUser, $dbPassword) {
        $msSqlPdoConnector = new MSSQLPDOConnector();
        $msSqlPdoConnector->connect($server, $dbName, $dbUser, $dbPassword);
        return $msSqlPdoConnector; 
    }
    
    public static function getOpenMySQLConnector($server, $dbName, $dbUser, $dbPassword) {
        $mySqlConnector = new MySQLConnector();
        $mySqlConnector->connect($server, $dbName, $dbUser, $dbPassword);
        return $mySqlConnector; 
    }
    
    public static function getOpenFbSQLConnector($server, $port, $dbName, $dbUser, $dbPassword) {
        $fbSqlConnector = new FbSQLConnector();
        $fbSqlConnector->connect($server, $port, $dbName, $dbUser, $dbPassword);
        return $fbSqlConnector; 
    }
    
}
