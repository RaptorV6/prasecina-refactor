<?php

class BaseModel {
    protected $db;
    public function __construct($dbConn) {
        $this->db = $dbConn;
    }
    public function query($sql) {
        return $this->db->query($sql);
    }
    public function fetchAll($sql) {
        return $this->db->query($sql)->fetch_all(PDO_FETCH_ASSOC);
    }
}

?>