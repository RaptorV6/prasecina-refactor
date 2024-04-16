<?php
namespace ScriptsSC;

require_once 'APDOConnector.php';

/**
 * MSSQLPDOConnector - správa databázového MS SQL spojení přes PDO
 * 
 * @author voparilv
 * Vychází z https://github.com/wickyaswal/indieteq-php-my-sql-pdo-database-class/blob/master/Db.class.php
 */
class MSSQLPDOConnector extends APDOConnector {
    
    const SQLSRV_CONNECT = 'sqlsrv_connect';
    
    /**
     * Vytvoří a vrátí databázové spojení s MS SQL databází
     * @return databázové spojení
     */
    public function connect($server, $dbName, $user, $password) {
        if(function_exists(self::SQLSRV_CONNECT)) {
            $dsn = 'sqlsrv:server=' . $server . ';database=' . $dbName;
        } else {
            $dsn = 'dblib:host=' . $server . ';dbname=' . $dbName;
        }
        
        try {
            $this->pdo = new \PDO($dsn, $user, $password);
            
            # Disable emulation of prepared statements, use REAL prepared statements instead.
            $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
            
            return $this->pdo;
        }
        catch (\PDOException $e) {
            throw new \Exception('Nepodařilo se vytvořit spojení s databází! ' . $e->getMessage());
        }
    }
    
}

?>
