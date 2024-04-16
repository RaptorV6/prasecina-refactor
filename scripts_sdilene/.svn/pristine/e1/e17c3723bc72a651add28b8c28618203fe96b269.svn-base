<?php
namespace ScriptsSC;

/**
 * IDBConnector - interface pro správu databázového spojení
 */
interface IDBConnector {
    
	/**
     * Vrátí databázové spojení s databází
     * @return databázové spojení
     */
    public function getConnection();
    
    /**
     * Vrátí informaci, zda existuje připojení k databázi
     * @return boolean
     */
    public function hasConnection();
    
    public function checkConnection($exceptionMessage);
    
    public function closeConnection();
    
    public function executeQuery($query, $parameters = null);
    
    public function beginTransaction();
    
    /**
     *  Commit transaction
     *  @return boolean, true on success or false on failure
     */
    public function commitTransaction();
    
    /**
     *  Rollback of transaction
     *  @return boolean, true on success or false on failure
     */
    public function rollbackTransaction();
    
}

?>
