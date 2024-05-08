<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
require_once "../assets/component/admin-nav.php";
require_once "../assets/component/admin-header.php";
require_once "../utils/OracleDb.php";
require_once "../functions/get-all-client.php";
require_once "../assets/component/modals/confirmation-modal.php";
require_once "../assets/component/modals/message-modal.php";
require_once "../assets/component/loading.php";

$adminId = $_SESSION['admin_id'];
if (empty($adminId)) {
  header("Location: /drivesation/signin.php");
}
$db = new OracleDB();
$users = getAllClient($db);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Applications</title>
  <link rel="stylesheet" href="../assets/styles/admin/layout.css">
  <link rel="stylesheet" href="../assets/styles/admin/applications.css">
  <link rel="stylesheet" href="../assets/styles/component/button.css">
</head>

<body id="admin-body">
  <main>
    <h2>Application</h2>
    <div class="flex-table">
      <div class="flex-row header">
        <div class="flex-cell"></div>
        <div class="flex-cell">ID</div>
        <div class="flex-cell">Last Name</div>
        <div class="flex-cell">First Name</div>
        <div class="flex-cell">Contact No.</div>
        <div class="flex-cell">Email</div>
        <div class="flex-cell"></div>
        <div class="flex-cell"></div>
        <div class="flex-cell"></div>
      </div>
      <?php foreach ($users as $user) : ?>
        <div class="flex-row">
          <div class="flex-cell">
            <img src="../<?= htmlspecialchars($user['FILE_LINK']) ?>" alt="Profile Picture">
          </div>
          <div class="flex-cell"><?= $user['USER_ID'] ?></div>
          <div class="flex-cell"><?= $user['LAST_NAME'] ?></div>
          <div class="flex-cell"><?= $user['FIRST_NAME'] ?></div>
          <div class="flex-cell"><?= $user['CONTACT_NUMBER'] ?></div>
          <div class="flex-cell"><?= $user['EMAIL_ADDRESS'] ?></div>
          <div class="flex-cell">
            <Button class="view-btn">View</Button>
          </div>
          <div class="flex-cell action-btn">
            <Button class="accept-btn" data-status=1 data-user-id="<?= $user['USER_ID'] ?>">Accept</Button>
          </div>
          <div class="flex-cell action-btn">
            <Button class="reject-btn" data-status=2 data-user-id="<?= $user['USER_ID'] ?>">Reject</Button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  </main>
  <script src="../assets/scripts/admin/applications.js"></script>
  <script src="../assets/scripts/modal/message-modal.js"></script>



</body>

</html>