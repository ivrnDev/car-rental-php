<?php
header('Content-Type: application/json');
require_once "../utils/OracleDb.php";
$db = new OracleDB();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email_address'])) {
  $email_address = $_POST['email_address'];
  try {
    $sql = "SELECT user_id from \"USER\" WHERE email_address = :email_address";
    $data = [
      ':email_address' => $email_address,
    ];
    $stid = $db->executeQuery($sql, $data);
    $result = $db->fetchRow($stid);

    if (empty($result)) {
      http_response_code(200);
      echo json_encode(["isUnique" => 1]);
    } else {
      http_response_code(200);
      echo json_encode(["isUnique" => 0]);
    }
    exit;
  } catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
    exit;
  }
} else {
  echo json_encode(['error' => "Input Required Fields"]);
}
