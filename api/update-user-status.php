<?php
$approvalHtml = <<<HTML
<html>
<head>
  <style>
    body { font-family: Arial, sans-serif; }
    .header { color: #4CAF50; font-size: 18px; font-weight: bold; }
    .content { margin-top: 20px; }
  </style>
</head>
<body>
  <div class="header">Application Approved</div>
  <div class="content">
    <p>Hello [User's Name],</p>
    <p>We are pleased to inform you that your application to become a user at Drivesation has been approved! We're excited to have you on board and look forward to seeing you take full advantage of our services.</p>
    <p>Please log in to your new account using the credentials you provided during registration and start exploring your new possibilities.</p>
    <p>If you have any questions or need assistance, feel free to contact our support team.</p>
    <p>Thank you for choosing Drivesation!</p>
    <p>Best Regards,<br>Drivesation Team</p>
  </div>
</body>
</html>
HTML;

$rejectionHtml = <<<HTML
<html>
<head>
  <style>
    body { font-family: Arial, sans-serif; }
    .header { color: #D32F2F; font-size: 18px; font-weight: bold;}
    .content { margin-top: 20px; }
  </style>
</head>
<body>
  <div class="header">Application Rejected</div>
  <div class="content">
    <p>Hello [User's Name],</p>
    <p>We regret to inform you that your application to become a user at Drivesation has been rejected. After careful consideration, it was determined that your application did not meet all our necessary documentation requirements.</p>
    <p>Here are a few possible reasons which might have influenced the decision:</p>
    <ul>
      <li>Incomplete submission of required documents.</li>
      <li>Failure to meet our eligibility criteria as outlined during the application process.</li>
    </ul>
    <p>We understand that this news can be disappointing. If you believe this is a mistake or if you are able to gather the required documents, please feel free to reapply or contact us for clarification.</p>
    <p>Thank you for your interest in Drivesation, and we wish you the best in your future endeavors.</p>
    <p>Best Regards,<br>Drivesation Team</p>
  </div>
</body>
</html>
HTML;

header('Content-Type: application/json');
require_once "../utils/OracleDb.php";
require_once "../utils/mailer.php";;
$db = new OracleDB();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['status'], $_POST['user_id'])) {
  $status = (int)$_POST['status'];
  $user_id = (int)$_POST['user_id'];
  try {
    $sql = "UPDATE \"USER\" set status  = :status WHERE user_id = :user_id";
    $getUserSql = "SELECT email_address, NVL(FIRST_NAME, '') || NVL(LAST_NAME, '') as FULL_NAME FROM \"USER\" WHERE user_id = :user_id";

    $updateData = [':status' => $status, ':user_id' => $user_id];
    $updateStid = $db->executeQuery($sql, $updateData);

    $mailer = new Mailer();
    $getProfileData = [':user_id' => $user_id];
    $getStid = $db->executeQuery($getUserSql, $getProfileData);
    $user = $db->fetchRow($getStid);

    $recipientEmail = $user['EMAIL_ADDRESS'];
    $recipientName = $user['FULL_NAME'];
    $subject = $status == 1 ? "Your request is Approved" : "Your request is Rejected";
    $message = $status == 1
      ? str_replace('[User\'s Name]', htmlspecialchars($recipientName), $approvalHtml)
      : str_replace('[User\'s Name]', htmlspecialchars($recipientName), $rejectionHtml);
    $result = $mailer->sendEmail($recipientEmail, $recipientName, $subject, $message);

    $responseHeader = $status == 1 ? "Approved" : "Rejected";
    $responseBody = $status == 1 ? "User" . $user_id . "has been approved" : "User" . $user_id . "has been rejected";

    if ($result) {
      echo json_encode(["header" => $responseHeader, "message" => $responseBody]);
    } else {
      echo json_encode(["message" => "Status updated, but email failed to send."]);
    }
    exit;
  } catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
    exit;
  }
}
