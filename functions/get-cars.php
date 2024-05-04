<?php
function getAllCars($db)
{
  try {
    $sql = "SELECT * FROM Car";
    $stid = $db->executeQuery($sql);
    $result = $db->fetchAll($stid);
    if ($result && count($result) > 0) {
      return $result;
    }
    return [];
  } catch (Exception $e) {
    error_log($e->getMessage());
    return false;
  }
}

