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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset(
    $_POST['car_title'],
    $_POST['car_description'],
    $_POST['car_model'],
    $_POST['plate_number'],
    $_POST['car_color'],
    $_POST['car_brand'],
    $_POST['gas_type'],
    $_POST['seat_capacity'],
    $_POST['car_type'],
    $_POST['amount'],
    $_FILES['orcr'],
    $_FILES['car_image'],
  )) {
    try {
      $car_title = $_POST['car_title'];
      $car_description = $_POST['car_description'];
      $car_model = $_POST['car_model'];
      $plate_number = $_POST['plate_number'];
      $car_color = $_POST['car_color'];
      $gas_type = $_POST['gas_type'];
      $car_brand = $_POST['car_brand'];
      $seat_capacity = $_POST['seat_capacity'];
      $car_type = $_POST['car_type'];
      $amount = $_POST['amount'];
      $orcr = $_FILES['orcr'];
      $car_image = $_FILES['car_image'];

      $documents = [
        'orcr' => 'ORCR',
        'car_image' => 'Car Image',
      ];

      if (isset($_FILES['payment_proof'])) {
        $documents['payment_proof'] = 'Payment Proof';
        $payment_proof = $_FILES['payment_proof'];
      }

      $sql = "INSERT INTO Car (car_id, car_title, car_description, car_model, plate_number, car_color, car_brand, availability_status, status, gas_type, seat_capacity, car_type, amount, owner_id, payment_status) VALUES (car_seq.NEXTVAL, :car_title, :car_description, :car_model, :plate_number, :car_color, :car_brand, :availability_status, :status, :gas_type, :seat_capacity, :car_type, :amount, :owner_id, :payment_status) RETURNING car_id INTO :new_car_id";

      $data = [
        ':car_title' => $car_title,
        ':car_description' => $car_description,
        ':car_model' => $car_model,
        ':plate_number' => $plate_number,
        ':car_color' => $car_color,
        ':car_brand' => $car_brand,
        ':seat_capacity' => $seat_capacity,
        ':gas_type' => $gas_type,
        ':car_type' => $car_type,
        ':amount' => $amount,
        ':availability_status' => 0,
        ':status' => 0,
        ':owner_id' => $owner_id,
        ':payment_status' => isset($_FILES['payment_proof']) ? 1 : 4
      ];

      $stid = $db->prepareStatement($sql);
      foreach ($data as $key => $val) {
        if (!oci_bind_by_name($stid, $key, $data[$key])) {
          $e = oci_error($stid);
          throw new Exception('Bind Error: ' . $e['message']);
        }
      }

      $new_car_id = 0;
      oci_bind_by_name($stid, ":new_car_id", $new_car_id, -1, OCI_B_INT);
      if (!oci_execute($stid)) {
        $e = oci_error($stid);
        throw new Exception('Execute Error: ' . $e['message']);
      }

      $allFilesProvided = true;
      foreach ($documents as $inputName => $docType) {
        if (!isset($_FILES[$inputName]) || $_FILES[$inputName]['error'] == UPLOAD_ERR_NO_FILE) {
          $allFilesProvided = false;
        }
      }
      if ($allFilesProvided) {
        foreach ($documents as $inputName => $documentName) {
          uploadCarDocuments($_FILES[$inputName], $new_car_id, $inputName, $documentName, $db);
        }
      }

      removeUserTrial($owner_id, $db);
      http_response_code(200);
      echo json_encode(['message', "Success"]);
      exit;
    } catch (Exception $e) {
      http_response_code(500);
      echo json_encode(["error" => $e->getMessage()]);
      exit;
    }
  }
}
