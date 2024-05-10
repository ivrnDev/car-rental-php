<?php
require_once "../utils/OracleDb.php";
$db = new OracleDB();
if (!$db->isConnected()) {
  die("Database connection failed");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset(
    $_POST['pick_up_time'],
    $_POST['rent_date_from'],
    $_POST['rent_date_to'],
    $_POST['owner_id'],
    $_POST['user_id'],
    $_POST['car_id'],

  )) {
    try {
      $pick_up_time = $_POST['pick_up_time'];
      $rent_date_from = $_POST['rent_date_from'];
      $rent_date_to = $_POST['rent_date_to'];
      $user_id = $_POST['user_id'];
      $car_id = $_POST['car_id'];
      $owner_id = $_POST['owner_id'];

      $sql = "INSERT INTO Rent (rent_id, user_id, owner_id, car_id, pick_up_time, rent_date_from, rent_date_to, status, transaction_date) VALUES (rent_seq.NEXTVAL, :user_id, :owner_id, :car_id, :pick_up_time, TO_DATE(:rent_date_from, 'YYYY-MM-DD'), TO_DATE(:rent_date_to, 'YYYY-MM-DD'), 0, SYSTIMESTAMP)";

      $data = [
        ':user_id' => $user_id,
        ':owner_id' => $owner_id,
        ':car_id' => $car_id,
        ':pick_up_time' => $pick_up_time,
        ':rent_date_from' => $rent_date_from,
        ':rent_date_to' => $rent_date_to,
      ];

      $db->executeQuery($sql, $data);

      http_response_code(200);
      echo json_encode(['message', "Order Success"]);
      exit;
    } catch (Exception $e) {
      http_response_code(500);
      echo json_encode(["error" => $e->getMessage()]);
      exit;
    }
  }
}
