<?php
header('Content-Type: application/json');

require_once "../utils/OracleDb.php";
$db = new OracleDB();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rent_id'], $_POST['new_status'],  $_POST['car_id'])) {
  $rent_id = (int)$_POST['rent_id'];
  $new_status = (int)$_POST['new_status'];
  $car_id = (int)$_POST['car_id'];

  try {
    $sql = "UPDATE rent SET status = :new_status WHERE rent_id = :rent_id";
    $data = [':new_status' => $new_status, ':rent_id' => $rent_id];
    $db->executeQuery($sql, $data);


    if ($new_status == 1) {
      $sql = "UPDATE rent SET status = 2 WHERE car_id = :car_id AND rent_id != :rent_id AND status = 0";
      $db->executeQuery($sql, [':car_id' => $car_id, ':rent_id' => $rent_id]);
    }



    $query = "SELECT status FROM rent WHERE rent_id = :rent_id";
    $stid = $db->executeQuery($query, [':rent_id' => $rent_id]);
    $updatedRow = $db->fetchRow($stid);

    echo json_encode($updatedRow);
    exit;
  } catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
    exit;
  }
} else {
  http_response_code(400);
  echo json_encode(["error" => "Invalid request. Required fields are missing."]);
}
