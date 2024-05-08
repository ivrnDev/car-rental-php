<?php
require_once "../assets/component/admin-nav.php";
require_once "../assets/component/admin-header.php";
require_once "../functions/analytics.php";
require_once "../utils/OracleDb.php";

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$adminId = $_SESSION['admin_id'];
if (empty($adminId)) {
  header("Location: /drivesation/signin.php");
}

$db = new OracleDB();
$analytics = getAnalytics($db);


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <link rel="stylesheet" href="../assets/styles/admin/layout.css" />
  <link rel="stylesheet" href="../assets/styles/admin/dashboard.css" />
</head>

<body>




  <main>
    <div class="heading-container">
      <h1>Dashboard</h1>
      <p>Welcome to Admin!</p>
    </div>
    <div class="card">
      <h2>Total Users</h2>
      <p><?= $analytics['TOTAL_USERS']?></p>
    </div>
    <div class="card">
      <h2>Pending Applications</h2>
      <p><?= $analytics['PENDING_APPLICANTS']?></p>

    </div>
    <div class="card">
      <h2>Total Cars</h2>
      <p><?= $analytics['TOTAL_CARS']?></p>
    </div>
    <div class="card">
      <h2>Pending Cars</h2>
      <p><?= $analytics['PENDING_CARS']?></p>
    </div>
    <div class="card">
      <h2>Completed Rentals</h2>
      <p><?= $analytics['COMPLETED_RENTALS']?></p>
    </div>
    <div class="card">
      <h2>Pending Rentals</h2>
      <p><?= $analytics['PENDING_RENTALS']?></p>
    </div>
    <div class="card">
      <h2>Available Cars</h2>
      <p><?= $analytics['AVAILABLE_CARS']?></p>

  </main>
</body>

</html>