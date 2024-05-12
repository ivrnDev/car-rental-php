<?php
header('Content-Type: application/json');
require_once "../utils/OracleDb.php";
$db = new OracleDB();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_status'], $_POST['car_id'])) {
  $delete_status = (int)$_POST['delete_status'];
  $car_id = (int)$_POST['car_id'];
  try {
    $sql = "UPDATE Car set is_deleted = :delete_status, payment_status = 0 WHERE car_id = :car_id";
    $data = [':delete_status' => $delete_status, ':car_id' => $car_id];
    $stid = $db->executeQuery($sql, $data);
    http_response_code(200);
    echo json_encode(["message" => "success"]);
    exit;
  } catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
    exit;
  }
}
