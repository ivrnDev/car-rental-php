<!-- <?php

require_once 'database/OracleDB.php'; 

try {
    $db = new OracleDB();

    if (!$db->isConnected()) {
        die("Database connection failed");
    }

    $sql = "SELECT * FROM employees WHERE department_id = :dept_id";

    $stid = $db->executeQuery($sql);
    
    $deptId = 30; 
    oci_bind_by_name($stid, ':dept_id', $deptId);

    if (!oci_execute($stid)) {
        $e = oci_error($stid);
        throw new Exception('Query failed: ' . htmlentities($e['message'], ENT_QUOTES));
    }

    $rows = $db->fetchAll($stid);

    foreach ($rows as $row) {
        echo $row['FIRST_NAME'] . " " . $row['LAST_NAME'] . "<br>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?> -->
