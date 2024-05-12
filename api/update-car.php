<?php
require_once "../utils/OracleDb.php";
require_once "../utils/upload.php";
require_once "../functions/get-profile.php";

header('Content-Type: application/json');
$db = new OracleDB();
if (!$db->isConnected()) {
  die("Database connection failed");
}

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

$owner_id = $_SESSION['user_id'];



if (isset(
  $_POST['car_id'],
  $_POST['car_title'],
  $_POST['car_description'],
  $_POST['car_color'],
  $_POST['seat_capacity'],
  $_POST['amount'],
)) {
  try {
    $car_id = $_POST['car_id'];
    $car_title = $_POST['car_title'];
    $car_description = $_POST['car_description'];
    $car_color = $_POST['car_color'];
    $seat_capacity = $_POST['seat_capacity'];
    $amount = $_POST['amount'];

    // $documents = [
    //   'orcr' => 'ORCR',
    //   'car_image' => 'Car Image',
    // ];


    $sql = "UPDATE Car 
            SET car_title = :car_title,
                car_description = :car_description,
                car_color = :car_color,
                seat_capacity = :seat_capacity,
                amount = :amount,
                status = :status,
                availability_status = :availability_status,
                payment_status = :payment_status
            WHERE car_id = :car_id";

    $data = [
      ':car_id' => $car_id,
      ':car_title' => $car_title,
      ':car_description' => $car_description,
      ':car_color' => $car_color,
      ':seat_capacity' => $seat_capacity,
      ':amount' => $amount,
      ':availability_status' => 0,
      ':status' => 0,
      ':payment_status' => isset($_FILES['payment_proof']) ? 1 : 4
    ];

    $updateStid = $db->executeQuery($sql, $data);
    if (!$updateStid) {
      throw new Exception("Failed to update car details.");
    }

    $documentFields = ['orcr', 'car_image', 'payment_proof'];
    foreach ($documentFields as $fieldName) {
      if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] == UPLOAD_ERR_OK) {
        updateCarDocuments($_FILES[$fieldName], $car_id, $fieldName, $db);
      }
    }

    http_response_code(200);
    echo json_encode(['message' => "Success"]);
    exit;
  } catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
    exit;
  }
}
