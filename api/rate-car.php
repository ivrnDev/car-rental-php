<?php
header('Content-Type: application/json');
require_once "../utils/OracleDb.php";
$db = new OracleDB();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rating'], $_POST['opinion'], $_POST['car_id'], $_POST['user_id'])) {
  $rate_count = (int)$_POST['rating'];
  $rate_comment = $_POST['opinion'];
  $car_id = (int)$_POST['car_id'];
  $user_id = (int)$_POST['user_id'];

  try {
    $sql = "INSERT INTO Rate (rate_id, user_id, car_id, rate_count, rate_comment, rate_time) VALUES (rate_seq.NEXTVAL, :user_id, :car_id, :rate_count, :rate_comment, SYSTIMESTAMP)";
    $data = [
      ':user_id' => $user_id,
      ':car_id' => $car_id,
      ':rate_count' => $rate_count,
      ':rate_comment' => $rate_comment,
    ];
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
