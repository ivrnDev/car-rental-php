<?php
header('Content-Type: application/json');
require_once "../utils/OracleDb.php";
$db = new OracleDB();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['car_id'])) {
  $car_id = (int)$_POST['car_id'];
  try {
    $carSql = "SELECT * FROM car WHERE car_id = :car_id";
    $ownerSql = "SELECT c.car_id,
    NVL(u.FIRST_NAME, '') || ' ' || NVL(u.MIDDLE_NAME, '') || ' ' || NVL(u.LAST_NAME, '') AS FULL_NAME, u.USER_ID, u.ADDRESS, u.CONTACT_NUMBER, u.EMAIL_ADDRESS 
    FROM car c
    JOIN \"USER\" u ON c.owner_id = u.user_id
    WHERE c.car_id = :car_id";
    $carDocumentSql = "SELECT document_type, file_link FROM \"DOCUMENT\" WHERE car_id = :car_id";
    $data = [':car_id' => $car_id];
    $carStid = $db->executeQuery($carSql, $data);
    $ownerStid = $db->executeQuery($ownerSql, $data);
    $carDocumentStid = $db->executeQuery($carDocumentSql, $data);
    
    $carData = $db->fetchRow($carStid);
    $ownerProfile = $db->fetchRow($ownerStid);
    $carDocument = $db->fetchAll($carDocumentStid);
    http_response_code(200);

    echo json_encode(array("carData" => $carData, "carDocument" => $carDocument, "profileData" => $ownerProfile));
    exit;
  } catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
    exit;
  }
}
