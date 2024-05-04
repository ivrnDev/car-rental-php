<?php
function getAllCars($db)
{
  try {
    $sql = "SELECT c.car_id, c.car_title, c.car_type, c.seat_capacity, c.amount, d.file_link from Car c JOIN \"DOCUMENT\" d ON c.car_Id = d.car_id WHERE d.document_type = 'car_image' AND c.availability_status=1 AND c.status=1";
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

function getCarDetails($carId, $db)
{
  try {
    $sql = "SELECT c.*, NVL(u.first_name, '') || ' ' || NVL(u.last_name, '') as owner_name, u.contact_number, u.email_address, d.file_link from Car c
    JOIN \"DOCUMENT\" d ON c.car_Id = d.car_id
    JOIN \"USER\" u ON c.owner_id = u.user_id
    WHERE d.document_type = 'car_image' AND c.car_id = :car_id";

    $data = [":car_id" => $carId];

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

function getUserCarList($userId, $db)
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
