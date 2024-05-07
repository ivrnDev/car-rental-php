<?php
header('Content-Type: application/json');
require_once "../utils/OracleDb.php";
$db = new OracleDB();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['status'], $_POST['user_id'])) {
  $status = (int)$_POST['status'];
  $user_id = (int)$_POST['user_id'];
  try {
    $sql = "UPDATE \"USER\" set status  = :status WHERE user_id = :user_id";
    $data = [':status' => $status, ':user_id' => $user_id];
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
