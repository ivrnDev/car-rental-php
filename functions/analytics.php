<?php
function getAnalytics($db)
{
  try {
    $sql = "SELECT
    (SELECT COUNT(*) FROM \"USER\" WHERE user_role != 1 AND status = 1) as total_users,
    (SELECT COUNT(*) FROM \"USER\" WHERE status = 0) as pending_applicants,
    (SELECT COUNT(*) FROM Car) as total_cars,
    (SELECT COUNT(*) FROM Car WHERE status = 0) as pending_cars, 
    (SELECT COUNT(*) FROM rent WHERE status = 5) as completed_rentals, 
    (SELECT COUNT(*) FROM rent WHERE status = 0) as pending_rentals, 
    (SELECT COUNT(*) FROM Car WHERE status = 1) as available_cars
    FROM dual";

    $stid = $db->executeQuery($sql);
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
