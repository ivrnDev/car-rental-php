<?php

function getRentersLists($user_id, $db)
{
  try {
    $sql = "SELECT r.*, NVL(u.first_name, '') || ' ' || NVL(u.last_name, '') as full_name, u.contact_number, u.email_address FROM Rent r
    JOIN \"USER\" u ON r.user_id = u.user_id
    JOIN Car c on r.car_id = c.car_id
    WHERE r.owner_id = :user_id AND c.is_deleted = 0
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
