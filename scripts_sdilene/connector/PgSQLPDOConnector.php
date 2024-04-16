<?php
namespace ScriptsSC;

require_once 'APDOConnector.php';

/**
 * PgSQLPDOConnector - správa databázového PostgreSQL spojení přes PDO
 * 
 * @author voparilv
 * Vychází z https://github.com/wickyaswal/indieteq-php-my-sql-pdo-database-class/blob/master/Db.class.php
 */
class PgSQLPDOConnector extends APDOConnector {
    
	/**
     * Vytvoří a vrátí databázové spojení s PostgreSQL databází
     * @return databázové spojení
     */
    public function connect($server, $port, $dbName, $user, $password) {
        $dsn = 'pgsql:host=' . $server . ($port ? ';port=' . $port : '') . ';dbname=' . $dbName;
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
