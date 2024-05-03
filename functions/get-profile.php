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
}

function getProfileInfo($user_id, $db) {
    try{
    $sql = "SELECT  
    NVL(FIRST_NAME, '') || ' ' || NVL(MIDDLE_NAME, '') || ' ' || NVL(LAST_NAME, '') AS FULLNAME, USER_ID, ADDRESS, CONTACT_NUMBER, EMAIL_ADDRESS, BIRTHDATE FROM \"USER\" WHERE user_id = :user_id";
    $data = [':user_id' => $user_id];
    $stid = $db->executeQuery($sql, $data);
    $result = $db->fetchRow($stid);
    if($result && count($result) > 0) {
      return $result;
    }
    } catch(Exception $e) {
    error_log($e->getMessage()); 
    return false;
    }
}
?>