<?php
require_once "../utils/OracleDb.php";
require_once "../utils/upload.php";
$db = new OracleDB();

if (!$db->isConnected()) {
  die("Database connection failed");
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rent_id'], $_POST['new_status'])) {
  $rent_id = $_POST['rent_id'];
  $new_status = $_POST['new_status'];
  try {
    $rent_id = (int)  $_POST['rent_id'];
    $new_status = (int)  $_POST['new_status'];
    echo $rent_id;

    $sql = "UPDATE rent SET status = :new_status WHERE rent_id = :rent_id";
    $data = [
      ':new_status' => $new_status,
      ':rent_id' => $rent_id,
    ];
    $db->executeQuery($sql, $data);
    echo "Update Successfully";
    // header("Location: /drivesation/lease-car.php");
  } catch (Exception $e) {
    throw new Exception("ERROR", $e->getMessage());
  }
} else {
  http_response_code(400);
  echo "Invalid request. Required fields are missing.";
}
