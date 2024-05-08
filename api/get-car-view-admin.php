<?php
header('Content-Type: application/json');
require_once "../utils/OracleDb.php";
require_once "../functions/get-profile.php";


$db = new OracleDB();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['car_id'], $_POST['owner_id'])) {
  $car_id = (int)$_POST['car_id'];
  $owner_id = (int)$_POST['owner_id'];

  try {
    $carSql = "SELECT * FROM car WHERE car_id = :car_id";
    $carDocumentSql = "SELECT document_type, file_link FROM \"DOCUMENT\" WHERE car_id = :car_id";
    $data = [':car_id' => $car_id];
    $carStid = $db->executeQuery($carSql, $data);
    $carDocumentStid = $db->executeQuery($carDocumentSql, $data);

    $carData = $db->fetchRow($carStid);
    $carDocument = $db->fetchAll($carDocumentStid);
    $profile = getProfileInfo($owner_id, $db);

    http_response_code(200);
    echo json_encode(array("carData" => $carData, "carDocument" => $carDocument, "profileInfo" => $profile));
    exit;
  } catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
    exit;
  }
}
