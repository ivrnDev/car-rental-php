<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$adminId = $_SESSION['admin_id'];
if (empty($adminId)) {
  header("Location: /drivesation/signin.php");
}
require_once "../assets/component/admin-nav.php";
require_once "../assets/component/admin-header.php";
require_once "../assets/component/loading.php";
require_once "../assets/component/modals/confirmation-modal.php";
require_once "../assets/component/modals/message-modal.php";
require_once "../assets/component/admin-page-view/car-list.php";
require_once "../utils/OracleDb.php";
require_once "../functions/get-cars.php";

$db = new OracleDB();
$cars = getAllCars($db);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Car</title>
  <link rel="stylesheet" href="../assets/styles/admin/layout.css">
  <link rel="stylesheet" href="../assets/styles/admin/car-list.css" />
  <link rel="stylesheet" href="../assets/styles/component/button.css">
</head>

<body id="admin-body">
  <main>
    <h2>Car List</h2>
    <div class="flex-table">
      <div class="flex-row header">
        <div class="flex-cell"></div>
        <div class="flex-cell">Car ID</div>
        <div class="flex-cell">Plate Number</div>
        <div class="flex-cell">Title</div>
        <div class="flex-cell">Car Model</div>
        <div class="flex-cell">Car Brand</div>
        <div class="flex-cell">Amount</div>
        <div class="flex-cell">Availability</div>
        <div class="flex-cell">Status</div>
        <div class="flex-cell">Owner</div>
        <div class="flex-cell"></div>
        <div class="flex-cell"></div>
      </div>
      <?php if (empty($cars)) : ?>
        <div class="flex-row no-data-row">
          <div class="flex-cell" colspan="9">No available data</div>
        </div>
      <?php else : ?>
        <?php foreach ($cars as $car) : ?>
          <div class="flex-row">
            <div class="flex-cell">
              <img src="../<?= htmlspecialchars($car['FILE_LINK']) ?>" alt="Car Profile">
            </div>
            <div class="flex-cell"><?= $car['CAR_ID'] ?></div>
            <div class="flex-cell"><?= $car['PLATE_NUMBER'] ?></div>
            <div class="flex-cell"><?= $car['CAR_TITLE'] ?></div>
            <div class="flex-cell"><?= $car['CAR_MODEL'] ?></div>
            <div class="flex-cell"><?= $car['CAR_BRAND'] ?></div>
            <div class="flex-cell"><?= "₱ " . number_format($car['AMOUNT']) ?></div>
            <div class="flex-cell">
              <?php switch ($car['AVAILABILITY_STATUS']) {
                case 0:
                  echo "Pending";
                  break;
                case 1:
                  echo "Available";
                  break;
                case 2:
                  echo "On Lease";
                  break;
                case 3:
                  echo "Maintenance";
                  break;
                case 4:
                  echo "Rejected";
                  break;
                case 5:
                  echo "Cancelled";
                  break;
                default:
                  echo "Unknown";
                  break;
              } ?>
            </div>
            <div class="flex-cell">
              <?php switch ($car['STATUS']) {
                case 0:
                  echo "Pending";
                  break;
                case 1:
                  echo "Approved";
                  break;
                case 2:
                  echo "Rejected";
                  break;
                case 3:
                  echo "Cancelled";
                  break;
                default:
                  echo "Unknown";
                  break;
              } ?>
            </div>
            <div class="flex-cell">
              <button class="view-btn" data-car-id="<?= $car['CAR_ID'] ?>" data-owner-id=<?= $car['OWNER_ID'] ?>>View</button>
            </div>

            <?php if ($car['STATUS'] == 0) : ?>
              <div class="flex-cell action-btn">
                <button class="accept-btn" data-status=1 data-car-id="<?= $car['CAR_ID'] ?>" data-availability-status=1>Accept</button>
              </div>
              <div class="flex-cell action-btn">
                <button class="reject-btn" data-status=2 data-car-id="<?= $car['CAR_ID'] ?>" data-availability-status=4>Reject</button>
              </div>

            <?php elseif ($car['STATUS'] == 1) : ?>
              <div class="flex-cell action-btn">
                <button class="reject-btn" data-status=3 data-car-id="<?= $car['CAR_ID'] ?>" data-availability-status=5>Cancel</button>
              </div>
            <?php else : ?>
              <div class="flex-cell action-btn">
              </div>
              <div class="flex-cell action-btn">
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      <?php endif ?>
    </div>

  </main>
  <script src="../assets/scripts/admin/car-list.js"></script>
  <script src="../assets/scripts/modal/message-modal.js"></script>
</body>

</html>