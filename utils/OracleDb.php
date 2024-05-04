<?php

class OracleDB
{
    private $conn;
    private static $host = 'localhost:1521/xepdb1';
    private static $username = 'drivesation';
    private static $password = 'drivesation';

    public function __construct()
    {
        $this->connect();
    }

    public function __destruct()
    {
        $this->disconnect();
    }

    private function connect()
    {
        $this->conn = oci_connect(self::$username, self::$password, self::$host);
        if (!$this->conn) {
            $error = oci_error();
            throw new Exception('Connection failed: ' . $error['message']);
        }
    }
    private function disconnect()
    {
        if ($this->conn) {
            oci_close($this->conn);
        }
    }

    public function isConnected()
    {
        return is_resource($this->conn);
    }

    public function prepareStatement($sql)
    {
        $stid = oci_parse($this->conn, $sql);
        if (!$stid) {
            $error = oci_error($this->conn);
            throw new Exception('SQL Parsing Error: ' . $error['message']);
        }
        return $stid;
    }

    public function executeQuery($sql, array $params = [])
    {

        $stid = oci_parse($this->conn, $sql);
        if (!$stid) {
            $error = oci_error($this->conn);
            throw new Exception('SQL Parsing Error: ' . $error['message']);
        }

        foreach ($params as $key => $value) {
            if (!oci_bind_by_name($stid, $key, $params[$key])) {
                $error = oci_error($stid);
                throw new Exception('Parameter Binding Error: ' . $error['message']);
            }
        }

        if (!oci_execute($stid)) {
            $error = oci_error($stid);
            oci_free_statement($stid);
            throw new Exception('SQL Execution Error: ' . $error['message']);
        }
        return $stid;
        oci_free_statement($stid);
    }

    public function fetchAll($stid)
    {
        oci_fetch_all($stid, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($stid);
        return $res;
    }

    public function fetchRow($stid)
    {
        $row = oci_fetch_assoc($stid);
        if (!$row) {
            oci_free_statement($stid);
        }
        return $row;
    }
}
