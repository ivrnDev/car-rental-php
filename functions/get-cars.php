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



