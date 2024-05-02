<?php
function getProfilePicture($user_id, $db) {
   if (!$db) {
    $error = oci_error($db);
      throw new Exception("Database connection is not established.", $error['message']);
      return null;
    }

    $sql = "SELECT file_link FROM \"DOCUMENT\" WHERE document_type = 'profile_picture' AND user_id = :user_id";
     $data = [':user_id' => $user_id];
    $stid = $db->executeQuery($sql, $data);
    $result = $db->fetchRow($stid);
    echo "<pre>";
    print_r($result);
    echo "</pre>";
}

?>