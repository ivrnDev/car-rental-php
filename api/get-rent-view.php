<?php
header('Content-Type: application/json');
require_once "../utils/OracleDb.php";
$db = new OracleDB();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userId'], $_POST['carId'], $_POST['rentId'])) {
  $user_id = (int)$_POST['userId'];
  $car_id = (int)$_POST['carId'];
  $rent_id = (int)$_POST['rentId'];
  try {
    $profileSql = "SELECT r.rent_id,
    NVL(u.FIRST_NAME, '') || ' ' || NVL(u.MIDDLE_NAME, '') || ' ' || NVL(u.LAST_NAME, '') AS FULL_NAME, u.USER_ID, u.ADDRESS, u.CONTACT_NUMBER, u.EMAIL_ADDRESS 
    FROM rent r
    JOIN \"USER\" u ON r.user_id = u.user_id
    WHERE u.user_id = :user_id AND r.rent_id = :rent_id";

    $profileDocumentSql = "SELECT document_type, file_link from \"DOCUMENT\" WHERE user_id = :user_id";

    $carSql = "SELECT d.file_link, c.*
    FROM \"DOCUMENT\" d
    JOIN car c ON d.car_id = c.car_id
    WHERE c.car_id = :car_id AND d.document_type = 'car_image'";

    $profileData = [':user_id' => $user_id, ':rent_id' => $rent_id];
    $profileDocumentData = [':user_id' => $user_id];
    $carData = [':car_id' => $car_id];

    $profileStid = $db->executeQuery($profileSql, $profileData);
    $profileDocumentStid = $db->executeQuery($profileDocumentSql, $profileDocumentData);
    $carStid = $db->executeQuery($carSql, $carData);

    $profileResult = $db->fetchRow($profileStid);
    $profileDocumentResult = $db->fetchAll($profileDocumentStid);
    $carResult = $db->fetchRow($carStid);

    if (
      $carResult && count($carResult) > 0 &&
      $profileResult && count($profileResult) > 0
    ) {
      echo json_encode(array('profileResult' => $profileResult, 'profileDocumentResult' => $profileDocumentResult, 'carResult' => $carResult));
    } else {
      http_response_code(401);
      echo json_encode(["No available data"]);
    }

    exit;
  } catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
    exit;
  }
} else {
  http_response_code(400);
  echo json_encode(["error" => "Invalid request. Required Data is missing"]);
}
