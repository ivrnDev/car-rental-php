<?php
function getProfilePicture($user_id, $db) {
    try{
    $sql = "SELECT file_link FROM \"DOCUMENT\" WHERE document_type = 'profile_picture' AND user_id = :user_id";
    $data = [':user_id' => $user_id];
    $stid = $db->executeQuery($sql, $data);
    $result = $db->fetchRow($stid);
    if($result && count($result) > 0) {
      return $result['FILE_LINK'];
    }
    } catch(Exception $e) {
    error_log($e->getMessage()); 
    return false;
    }
}?>