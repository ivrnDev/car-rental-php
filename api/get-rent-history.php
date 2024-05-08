<?php
header('Content-Type: application/json');
require_once "../utils/OracleDb.php";
$db = new OracleDB();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rent_id'])) {
  $rent_history = (int)$_POST['rent_history'];
  try {
    $profileSql = "SELECT  
    NVL(FIRST_NAME, '') || ' ' || NVL(MIDDLE_NAME, '') || ' ' || NVL(LAST_NAME, '') AS FULLNAME, rent_history, ADDRESS, CONTACT_NUMBER, EMAIL_ADDRESS, BIRTHDATE FROM \"USER\"
    WHERE rent_history = :rent_history";

    $documentSql = "SELECT * FROM Rent WHERE rent_history = :rent_history";

    $data = [':rent_history' => $rent_history];
    $profileStid = $db->executeQuery($profileSql, $data);
    $documentStid = $db->executeQuery($documentSql, $data);

    $profile = $db->fetchRow($profileStid);
    $document = $db->fetchAll($documentStid);

    http_response_code(200);
    echo json_encode(array($profile, $document));
    exit;
  } catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
    exit;
  }
}
