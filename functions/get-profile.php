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
    NVL(FIRST_NAME, '') || ' ' || NVL(MIDDLE_NAME, '') || ' ' || NVL(LAST_NAME, '') AS FULLNAME, USER_ID, ADDRESS, CONTACT_NUMBER, EMAIL_ADDRESS, BIRTHDATE FROM \"USER\" WHERE user_id = :user_id";
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

function getProfileCarLists($userId, $db)
{
  try {
    $sql = "SELECT 
    c.CAR_ID,    
    c.CAR_MODEL,             
    c.CAR_COLOR,             
    c.CAR_BRAND,             
    c.PLATE_NUMBER,          
    c.SEAT_CAPACITY,         
    c.GAS_TYPE,              
    c.AVAILABILITY_STATUS,   
    c.STATUS,                
    c.OWNER_ID,              
    c.AMOUNT,                
    c.CAR_TYPE,              
    c.CAR_TITLE,             
    c.CAR_DESCRIPTION,
    LISTAGG(d.file_link, ', ') WITHIN GROUP (ORDER BY d.file_link) AS file_links
FROM Car c
JOIN \"DOCUMENT\" d ON d.car_id = c.CAR_ID
WHERE c.owner_id = :user_id
GROUP BY 
    c.CAR_ID,    
    c.CAR_MODEL,             
    c.CAR_COLOR,             
    c.CAR_BRAND,             
    c.PLATE_NUMBER,          
    c.SEAT_CAPACITY,         
    c.GAS_TYPE,              
    c.AVAILABILITY_STATUS,   
    c.STATUS,                
    c.OWNER_ID,              
    c.AMOUNT,                
    c.CAR_TYPE,              
    c.CAR_TITLE,             
    c.CAR_DESCRIPTION";
    $data = [':user_id' => $userId];
    $stid = $db->executeQuery($sql, $data);
    $carResult = $db->fetchAll($stid);
    if ($carResult && count($carResult) > 0) {
      return $carResult;
    }
    return [];
  } catch (Exception $e) {
    error_log($e->getMessage());
    return false;
  }
}
