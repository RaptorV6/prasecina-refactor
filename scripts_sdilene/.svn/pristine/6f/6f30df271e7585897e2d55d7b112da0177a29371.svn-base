<?php
namespace ScriptsSC;

require_once 'IDBConnector.php';

class MSSQLConnector implements IDBConnector {
    protected $msSqlConnection;
    
    const SQLSRV_CONNECT = 'sqlsrv_connect';
    
    public function connect($server, $dbName, $user, $password, $characterSet = "UTF-8") {
        if(function_exists(self::SQLSRV_CONNECT)) {
            $this->msSqlConnection = sqlsrv_connect($server, array('Database' => $dbName, 'UID' => $user, 'PWD' => $password, "CharacterSet" => $characterSet));
        } else {
            $this->msSqlConnection = mssql_connect($server, $user, $password);
            mssql_select_db($dbName, $this->msSqlConnection);
        }
        
        return $this->msSqlConnection;
    }

    public function getConnection() {
        return $this->msSqlConnection;
    }
    
    /**
     * @deprecated
     */
    public function getMsSQLConnection() {
        return $this->getConnection();
    }
    
    public function hasConnection() {
        return ($this->msSqlConnection) ? true : false;
    }
    
    public function checkConnection($exceptionMessage) {
        if(!$this->msSqlConnection) {
            throw new \Exception($exceptionMessage);
        }
    }
    
    public function executeQuery($query, $parameters = null) {
        if(function_exists(self::SQLSRV_CONNECT)) {
            return sqlsrv_query($this->msSqlConnection, $query, $parameters);
        } else {
            if($parameters) {
                throw new \Exception("Chyba - parametry v query nejsou podporovány, je použito rozšíření mssql!");
            }
            return mssql_query($query, $this->msSqlConnection);
        }
    }
    
    /**
     * @deprecated
     */
    public function query($query, $parameters = null) {
        return $this->executeQuery($query, $parameters);
    }
    
    public function fetchArray($result) {
        if(function_exists(self::SQLSRV_CONNECT)) {
            return sqlsrv_fetch_array($result);
        } else {
            return mssql_fetch_array($result);
        }
    }
    
    public function closeConnection() {
        if($this->msSqlConnection) {
            if(function_exists(self::SQLSRV_CONNECT)) {
                sqlsrv_close($this->msSqlConnection);
            } else {
                mssql_close($this->msSqlConnection);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @deprecated
     */
    public function close() {
        $this->closeConnection();
    }

    public function beginTransaction() {
        if(function_exists(self::SQLSRV_CONNECT)) {
            return sqlsrv_begin_transaction($this->msSqlConnection);
        } else {
            throw new \Exception("Chyba - transakce nejsou podporovány, je použito rozšíření mssql!");
        }
    }

    public function commitTransaction() {
        if(function_exists(self::SQLSRV_CONNECT)) {
            return sqlsrv_commit($this->msSqlConnection);
        } else {
            throw new \Exception("Chyba - transakce nejsou podporovány, je použito rozšíření mssql!");
        }
    }

    public function rollbackTransaction() {
        if(function_exists(self::SQLSRV_CONNECT)) {
            return sqlsrv_rollback($this->msSqlConnection);
        } else {
            throw new \Exception("Chyba - transakce nejsou podporovány, je použito rozšíření mssql!");
        }
    }

}
