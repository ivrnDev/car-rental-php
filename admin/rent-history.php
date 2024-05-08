<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
require_once "../assets/component/admin-nav.php";
require_once "../assets/component/admin-header.php";
require_once "../assets/component/admin-nav.php";
require_once "../assets/component/admin-header.php";
require_once "../utils/OracleDb.php";
require_once "../assets/component/modals/confirmation-modal.php";
require_once "../assets/component/modals/message-modal.php";
require_once "../assets/component/loading.php";
require_once "../functions/get-rent-list.php";
require_once "../assets/component/admin-page-view/rent-history.php";

$adminId = $_SESSION['admin_id'];
if (empty($adminId)) {
  header("Location: /drivesation/signin.php");
}
$db = new OracleDB();
$rentList = getAllRenters($db);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Rent History</title>
  <link rel="stylesheet" href="../assets/styles/admin/layout.css">
  <link rel="stylesheet" href="../assets/styles/admin/rent-history.css" />
</head>

<body id="admin-body">
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Account</title>
    <link rel="stylesheet" href="../assets/styles/admin/layout.css">
    <link rel="stylesheet" href="../assets/styles/admin/account.css">
    <link rel="stylesheet" href="../assets/styles/component/button.css">
  </head>

  <body id="admin-body">
    <main>
      <h2>Rent History</h2>
      <div class="flex-table">
        <div class="flex-row header">
          <div class="flex-cell">ID</div>
          <div class="flex-cell">Pick Up Time</div>
          <div class="flex-cell">Rent Date</div>
          <div class="flex-cell">Return Date</div>
          <div class="flex-cell">Status</div>
          <div class="flex-cell">Transaction Date</div>
        </div>
        <?php if (empty($rentList)) : ?>
          <div class="flex-row no-data-row">
            <div class="flex-cell" colspan="9">No available data</div>
          </div>
        <?php else : ?>
          <?php foreach ($rentList as $rent) : ?>
            <div class="flex-row" data-rent-id="<?= $rent['RENT_ID'] ?>">
              <div class="flex-cell"><?= $rent['RENT_ID'] ?></div>
              <div class="flex-cell"><?= date('h:i A', strtotime($rent['PICK_UP_TIME'])) ?></div>
              <div class="flex-cell"><?= date('F d, Y', strtotime($rent['RENT_DATE_FROM'])) ?></div>
              <div class="flex-cell"><?= date('F d, Y', strtotime($rent['RENT_DATE_TO'])) ?></div>
              <div class="flex-cell status-cell">
                <?php switch ($rent['STATUS']) {
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
                    echo "Processing";
                    break;
                  case 4:
                    echo "On Going";
                    break;
                  case 5:
                    echo "Completed";
                    break;
                  case 6:
                    echo "Cancelled";
                    break;
                  default:
                    echo "Unknown";
                    break;
                } ?>
              </div>

              <div class="flex-cell">
                <?php
                $originalFormat = 'd-M-y h.i.s.u A';
                $dateTime = DateTime::createFromFormat($originalFormat, $rent['TRANSACTION_DATE']);
                echo $dateTime->format('M d, Y g:i A')
                ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif ?>

      </div>

    </main>
    <script src="../assets/scripts/modal/message-modal.js"></script>

  </body>

  </html>
  <main></main>

</body>

</html>