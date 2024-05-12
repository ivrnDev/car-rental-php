<?php
function getProfilePicture($user_id, $db)
{
  try {
    $sql = "SELECT file_link FROM \"DOCUMENT\" WHERE document_type = 'profile_picture' AND user_id = :user_id";
    $data = [':user_id' => $user_id];
    $stid = $db->executeQuery($sql, $data);
    $result = $db->fetchRow($stid);
    if ($result && count($result) > 0) {
      return $result['FILE_LINK'];
    }
    return [];
  } catch (Exception $e) {
    error_log($e->getMessage());
    return false;
  }
}

function getProfileInfo($user_id, $db)
{
  try {
    $sql = "SELECT  
    NVL(u.FIRST_NAME, '') || ' ' || NVL(u.MIDDLE_NAME, '') || ' ' || NVL(u.LAST_NAME, '') AS FULLNAME, u.USER_ID, u.ADDRESS, u.CONTACT_NUMBER, u.EMAIL_ADDRESS, u.BIRTHDATE, d.file_link 
    FROM \"DOCUMENT\" d
    JOIN \"USER\" u ON d.user_id = u.user_id
    WHERE u.user_id = :user_id AND d.document_type = 'profile_picture'";

    $data = [':user_id' => $user_id];
    $stid = $db->executeQuery($sql, $data);
    $result = $db->fetchRow($stid);
    if ($result && count($result) > 0) {
      return $result;
    }
    return [];
  } catch (Exception $e) {
    error_log($e->getMessage());
    return false;
  }
}

function getProfileRentHistory($user_id, $db)
{
  try {
    $sql = "SELECT r.*, u.user_id as owner_id, NVL(u.first_name, '') || ' ' || NVL(u.last_name, '') as full_name, u.contact_number, u.email_address FROM Rent r
    JOIN \"USER\" u ON r.owner_id = u.user_id
    WHERE r.user_id = :user_id
    ORDER BY r.rent_id ASC";
    $data = [':user_id' => $user_id];
    $stid = $db->executeQuery($sql, $data);
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
function getUserTrial($user_id, $db)
{
  try {
    $sql = "SELECT free_trial from \"USER\" WHERE user_id = :user_id";
    $data = [':user_id' => $user_id];
    $stid = $db->executeQuery($sql, $data);
    $result = $db->fetchRow($stid);
    if ($result && count($result) > 0) {
      return $result;
    }
    return [];
  } catch (Exception $e) {
    error_log($e->getMessage());
    return false;
  }
}

function removeUserTrial($user_id, $db)
{
  try {
    $sql = "UPDATE \"USER\" set free_trial = 0 WHERE user_id = :user_id";
    $data = [':user_id' => $user_id];
    $stid = $db->executeQuery($sql, $data);
    return true;
  } catch (Exception $e) {
    error_log($e->getMessage());
    return false;
  }
}
