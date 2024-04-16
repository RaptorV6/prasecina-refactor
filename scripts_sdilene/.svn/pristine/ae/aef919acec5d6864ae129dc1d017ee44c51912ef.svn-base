<?php
namespace ScriptsSC;

require_once 'IDBConnector.php';

class FbSQLConnector implements IDBConnector {
    protected $fbSqlConnection;
    protected $fbTransaction;
    
    public function connect($server, $port, $dbName, $user, $password) {
        $this->fbSqlConnection = ibase_connect($server . '/' . $port . ':' . $dbName, $user, $password);
        
        return $this->fbSqlConnection;
    }
    
    public function getConnection() {
        return $this->fbSqlConnection;
    }
    
    /**
     * @deprecated
     */
    public function getFbSQLConnection() {
        return $this->getConnection();
    }
    
    public function hasConnection() {
        return ($this->fbSqlConnection) ? true : false;
    }
    
    public function checkConnection($exceptionMessage) {
        if(!$this->fbSqlConnection) {
            throw new \Exception($exceptionMessage);
        }
    }
    
    public function query($query) {
        if(!$this->fbTransaction) {
            return ibase_query($this->fbSqlConnection, $query);
        } else {
            return ibase_query($this->fbTransaction, $query);
        }
    }
    
    public function prepare($stmt) {
        if(!$this->fbTransaction) {
            return ibase_prepare($this->fbSqlConnection, $stmt);
        } else {
            return ibase_prepare($this->fbTransaction, $stmt);
        }
    }
    
    public function executeQuery($query, $parameters = null) {
        if (!is_array($parameters)) {
            return ibase_execute($query, $parameters);
        } else {
            array_unshift($parameters, $query);
            return call_user_func_array('ibase_execute', $parameters);
        }
    }
    
    /**
     * @deprecated
     */
    public function execute($query, $parameters) {
        return $this->executeQuery($query, $parameters);
    }
    
    public function closeConnection() {
        if($this->fbSqlConnection) {
            ibase_close($this->fbSqlConnection);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @deprecated
     */
    public function close() {
        return $this->closeConnection();
    }
    
    public function beginTransaction() {
        $this->fbTransaction = ibase_trans();
    }
    
    public function commitTransaction() {
        ibase_commit($this->fbTransaction);
        $this->fbTransaction = null;
    }
    
    public function rollbackTransaction() {
        ibase_rollback($this->fbTransaction);
        $this->fbTransaction = null;
    }

}
