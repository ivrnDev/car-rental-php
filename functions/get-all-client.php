<?php

function getAllApplicants($db)
{
  try {
    $sql = "SELECT u.*, d.file_link FROM \"DOCUMENT\" d
    JOIN \"USER\" u ON d.user_id = u.user_id 
    WHERE u.status = 0 AND u.user_role = 0 AND d.document_type = 'profile_picture'";
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
function getAllClients($db)
{
  try {
    $sql = "SELECT u.*, d.file_link FROM \"DOCUMENT\" d
    JOIN \"USER\" u ON d.user_id = u.user_id 
    WHERE d.document_type = 'profile_picture' AND u.status = 1
    ORDER BY u.user_id ASC";
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
