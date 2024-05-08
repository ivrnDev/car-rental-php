<?php
header('Content-Type: application/json');
require_once "../utils/OracleDb.php";
$db = new OracleDB();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
  $user_id = (int)$_POST['user_id'];
  try {
    $profileSql = "SELECT  
    NVL(FIRST_NAME, '') || ' ' || NVL(MIDDLE_NAME, '') || ' ' || NVL(LAST_NAME, '') AS FULLNAME, USER_ID, ADDRESS, CONTACT_NUMBER, EMAIL_ADDRESS, BIRTHDATE FROM \"USER\"
    WHERE user_id = :user_id";

    $documentSql = "SELECT document_type, file_link FROM \"DOCUMENT\" WHERE user_id = :user_id";

    $data = [':user_id' => $user_id];
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
