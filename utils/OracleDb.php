<?php

class OracleDB {
    private $conn;
    private $host = 'localhost:1521/xepdb1';  
    private $username = 'drivesation';
    private $password = 'drivesation';

    public function __construct() {
        $this->connect();
    }

    public function __destruct() {
        $this->disconnect();
    }

    private function connect() {
        $this->conn = oci_connect($this->username, $this->password, $this->host);
        if (!$this->conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }
    private function disconnect() {
        if ($this->conn) {
            oci_close($this->conn);
        }
    }

    public function isConnected() {
        return is_resource($this->conn);
    }

    public function executeQuery($sql) {
        $stid = oci_parse($this->conn, $sql);
        if (!$stid) {
            $e = oci_error($this->conn);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        
        return $stid;
    }

    public function fetchAll($stid) {
        oci_fetch_all($stid, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($stid);
        return $res;
    }

    
}
?>