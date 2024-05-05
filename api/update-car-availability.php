<?php
header('Content-Type: application/json');

require_once "../utils/OracleDb.php";
$db = new OracleDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!isset($_POST['car_id'], $_POST['new_status'])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid request. Required fields are missing."]);
    exit;
  }
  $car_id = (int)$_POST['car_id'];
  $new_status = (int)$_POST['new_status'];


  try {

    $sql = "UPDATE car SET availability_status = :new_status WHERE car_id = :car_id";
    $data = [':new_status' => $new_status, ':car_id' => $car_id];
    $db->executeQuery($sql, $data);


    http_response_code(200);
    echo json_encode(["message" => "Car status updated successfully.", "car_id" => $car_id, "new_status" => $new_status]);
    exit;
  } catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
    exit;
  }
} else {
  http_response_code(405);
  echo json_encode(["error" => "Invalid request method."]);
  exit;
}
