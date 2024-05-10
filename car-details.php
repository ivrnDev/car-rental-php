<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
  require_once "assets/component/header.php";
  require_once "functions/get-cars.php";
  require_once "utils/OracleDb.php";
  require_once "assets/component/modals/message-modal.php";
  require_once "assets/component/loading.php";
  require_once "assets/component/modals/confirmation-modal.php";

  if (isset($_GET['car_id'])) {
    $car_id = htmlspecialchars($_GET['car_id']);
    $db = new OracleDB();
    $result = getCarDetails($car_id, $db);
    if (empty($result)) {
      header("Location: /drivesation/car-list.php");
    }
  } else {
    throw new Exception("Error: No Parameters");
  }
}
$userId = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Car Details</title>
  <link rel="stylesheet" href="assets/styles/user/layout.css">
  <link rel="stylesheet" href="assets/styles/user/car-details.css">
</head>

<body>
  <main>
    <form method="POST" id="rent-car">
      <div class="card">
        <img id="car_image" src="<?= $result['FILE_LINK']; ?>" alt="<?= $result['CAR_TITLE'] ?>">
        <div class="info">
          <div class="first-line">
            <div class="type">
              <p class="car-type>"><?= htmlspecialchars($result['CAR_TYPE']) ?></p>
            </div>

            <div class="seat">
              <p class="seat-cap>">Seats: <?= htmlspecialchars($result['SEAT_CAPACITY']) ?></p>
            </div>
          </div>

          <div class="form-group">
            <div class="time input-container">
              <label for="pick_up_time" id="pick_up_time_label">Pick up Time</label>
              <input id="pick_up_time" name="pick_up_time" type="time" onkeydown="return false">
            </div>
            <span class="error-message" id="pick_up_time-error"></span>
          </div>

          <div class="form-group">
            <div class="date input-container">
              <label for="rent_date_from" id="rent_date_from_label">Pick up Date</label>
              <input id="rent_date_from" name="rent_date_from" type="date" onkeydown="return false">
            </div>
            <span class="error-message" id="rent_date_from-error"></span>
          </div>

          <div class="form-group">
            <div class="return-date input-container">
              <label for="rent_date_to" id="rent_date_to_label">Return Date</label>
              <input id="rent_date_to" name="rent_date_to" type="date" onkeydown="return false">
            </div>
            <span class="error-message" id="rent_date_to-error"></span>
          </div>

          <div class="carowner">
            <p>CAR OWNER </p>
          </div>

          <div class="owner-info">

            <p class="owner-name"><?= htmlspecialchars($result['OWNER_NAME']) ?></p>
            <p class="email"><?= htmlspecialchars($result['EMAIL_ADDRESS']) ?></p>
            <p class="contact"><?= htmlspecialchars($result['CONTACT_NUMBER']) ?></p>
          </div>





          <div class="rent">
            <div class="price">
              <p>PRICE </p>
            </div>
            <div class="amount">
              <p class="car-amount"><?= "₱" . number_format($result['AMOUNT']) ?></p>
            </div>
            <div class="button">
              <button id="rentCarBtn" data-user-id="<?= $userId ?>" data-owner-id="<?= $result['OWNER_ID'] ?>" data-car-id="<?= $result['CAR_ID'] ?>" <?php if ($result['OWNER_ID'] == $userId) echo "disabled" ?>>Rent a Car</button>
            </div>
          </div>


          <div class="car-title">
            <p class="contact"><?= htmlspecialchars($result['CAR_TITLE']) ?></p>
          </div>

          <div class="description">
            <div class="text">
              <p>CAR DESCRIPTION</p>
            </div>
            <p class="contact"><?= htmlspecialchars($result['CAR_DESCRIPTION']) ?></p>
          </div>
        </div>
      </div>
      </div>
      </div>

      </div>
    </form>

  </main>
  <script src="assets/scripts/modal/message-modal.js"></script>
  <script src="assets/scripts/user/car-details.js"></script>


</html>