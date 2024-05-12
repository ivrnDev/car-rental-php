<?php
header('Content-Type: application/json');
require_once "../utils/OracleDb.php";
$db = new OracleDB();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['status'], $_POST['car_id'], $_POST['availability'], $_POST['payment_status'])) {
  $status = (int)$_POST['status'];
  $car_id = (int)$_POST['car_id'];
  $availability = (int)$_POST['availability'];
  $payment_status = (int)$_POST['payment_status'];

  try {
    $sql = "UPDATE Car set status = :status, availability_status = :availability, payment_status = :payment_status WHERE car_id = :car_id";
    $data = [
      ':status' => $status,
      ':car_id' => $car_id,
      ':availability' => $availability,
      ':payment_status' => $payment_status,
    ];
    $stid = $db->executeQuery($sql, $data);

    switch ($status) {
    case 0:
        $responseHeader = "Restored";
        $responseBody = "Car No. " . $car_id . " has been restored.";
        break;
    case 1:
        $responseHeader = "Approved";
        $responseBody = "Car No. " . $car_id . " has been approved.";
        break;
    case 2:
        $responseHeader = "Rejected";
        $responseBody = "Car No. " . $car_id . " has been rejected.";
        break;
    case 3: // Assuming status 3 means cancelled
        $responseHeader = "Cancelled";
        $responseBody = "Car No. " . $car_id . " has been cancelled.";
        break;
    default:
        $responseHeader = "Unknown Status";
        $responseBody = "Car No. " . $car_id . " has an unknown status.";
        break;
}

    echo json_encode(["header" => $responseHeader, "body" => $responseBody, 'status' => $status]);
    exit;
  } catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
    exit;
  }
}
