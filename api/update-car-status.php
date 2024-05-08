<?php
header('Content-Type: application/json');
require_once "../utils/OracleDb.php";
$db = new OracleDB();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['status'], $_POST['car_id'], $_POST['availability'])) {
  $status = (int)$_POST['status'];
  $car_id = (int)$_POST['car_id'];
  $availability = (int)$_POST['availability'];
  try {
    $sql = "UPDATE Car set status = :status, availability_status = :availability WHERE car_id = :car_id";
    $data = [':status' => $status, ':car_id' => $car_id, ':availability' => $availability];
    $stid = $db->executeQuery($sql, $data);

    $responseHeader = $status == 1 ? "Approved" : ($status == 2 ? "Rejected" : "Cancelled");
    $responseBody = $status == 1 ? "Car No. " . $car_id . " has been approved." : ($status == 2 ? "Car No. " . $car_id . " has been rejected." : "Car No. " . $car_id . " has been cancelled.");
    echo json_encode(["header" => $responseHeader, "body" => $responseBody, 'status' => $status]);
    exit;
  } catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
    exit;
  }
}
