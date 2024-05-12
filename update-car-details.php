<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

require_once "assets/component/header.php";
require_once "assets/component/modals/message-modal.php";
require_once "assets/component/modals/confirmation-modal.php";
require_once "assets/component/lease-car-page-view/payment-info.php";
require_once "assets/component/modals/update-car-modal.php";
require_once "assets/component/loading.php";
require_once "functions/get-profile.php";
require_once "functions/get-cars.php";
require_once "utils/OracleDb.php";

if (isset($_GET['car_id'])) {
  $car_id = htmlspecialchars($_GET['car_id']);
  $car = getCarDetails($car_id, $db);
} else {
  throw new Exception("Error: No Parameters");
}

$userId = $_SESSION['user_id'];
if (empty($userId)) {
  header("Location: /drivesation/signin.php");
}
$db = new OracleDB();


$hasFreeTrial = getUserTrial($userId, $db);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="assets/styles/user/layout.css">
  <link rel="stylesheet" href="assets/styles/component/button.css">
  <link rel="stylesheet" href="assets/styles/user/update-car-details.css">
</head>

<body>
  <main>
    <h1 style="color: white">Update Car</h1>
    <form id="updateCarForm" method="POST" enctype="multipart/form-data">
      <div class="left-column">
        <div class="input-container">
          <input id="car_title" name="car_title" type="text" placeholder="Car Title" autocomplete="off" value="<?= $car['CAR_TITLE'] ?>">
          <span class="error-message" id="car_title-error"></span>
        </div>
        <div class="input-container">
          <input required id="car_model" name="car_model" type="text" placeholder="Car Model" autocomplete="off" value="<?= $car['CAR_MODEL'] ?>" disabled>
          <span class="error-message" id="car_model-error"></span>
        </div>
        <div class="input-container">
          <textarea required id="car_description" name="car_description" type="" placeholder="Description" autocomplete="off" rows="4" cols="40"><?= htmlspecialchars($car['CAR_DESCRIPTION']) ?></textarea>
          <span class="error-message" id="car_description-error"></span>
        </div>
        <div class="input-container">
          <input required id="plate_number" name="plate_number" type="text" placeholder="Plate Number" autocomplete="off" value="<?= $car['PLATE_NUMBER'] ?>" disabled>
          <span class="error-message" id="plate_number-error"></span>
        </div>
        <div class="input-container">
          <input required id="car_color" name="car_color" type="text" placeholder="Car Color" autocomplete="off" value="<?= $car['CAR_COLOR'] ?>">
          <span class="error-message" id="car_color-error"></span>
        </div>
        <div class="input-container">
          <input required id="car_brand" name="car_brand" type="text" placeholder="Car Brand" autocomplete="off" value="<?= $car['CAR_BRAND'] ?>" disabled>
          <span class="error-message" id="car_brand-error"></span>
        </div>
        <label class="file-label" for="car_image" id="car_image_label">
          Car Image
          <span id="car_image_name">No file chosen</span><img src="assets/images/add-image.png" alt="Add Image"></label>
        </label>
        <label class="file-label" for="orcr" id="orcr_label">
          OR/CR
          <span id="orcr_name">No file chosen</span><img src="assets/images/add-image.png" alt="Add Image"></label>
        </label>
      </div>


      <div class="right-column">
        <div class="input-container">
          <input required id="gas_type" name="gas_type" type="text" placeholder="Gas Type" autocomplete="off" value="<?= $car['GAS_TYPE'] ?>" disabled>
          <span class="error-message" id="gas_type-error"></span>
        </div>
        <div class="input-container">
          <input required id="seat_capacity" name="seat_capacity" type="number" placeholder="Seat Capacity" autocomplete="off" value="<?= $car['SEAT_CAPACITY'] ?>">
          <span class="error-message" id="seat_capacity-error"></span>
        </div>
        <div class="input-container">
          <input required id="car_type" name="car_type" type="text" placeholder="Car Type" autocomplete="off" value="<?= $car['CAR_TYPE'] ?>" disabled>
          <span class="error-message" id="car_type-error"></span>
        </div>
        <div class="input-container">
          <input required id="amount" name="amount" type="number" placeholder="Amount" autocomplete="off" value="<?= $car['AMOUNT'] ?>">
          <span class="error-message" id="amount-error"></span>
        </div>

        <label class="file-label" for="payment_proof" id="payment_proof_label">
          Proof of Payment
          <span id="payment_proof_name">No file chosen</span><img src="assets/images/add-image.png" alt="Add Proof">
        </label>
        <div class="processing-fee-container" style="color: white">
          <h1>
            Processing Fee
          </h1>
          <span id="processing-fee" data-trial="<?= $hasFreeTrial['FREE_TRIAL'] ?>">
            <?= "₱ " . number_format($car['AMOUNT'] * 0.05, 2) ?>
          </span>
        </div>
        <button id="view-payment-method" class="view-btn" type="button">Payment Method</button>

        <button id="updateCarBtn" class="accept-btn" type="submit">Update</button>
        <p style="color: red;">WARNING: Updating your car will reset the status of your car to pending. </p>
      </div>

      <input required type="file" name="car_image" id="car_image">
      <input required type="file" name="orcr" id="orcr">
      <?php if ($hasFreeTrial['FREE_TRIAL'] == 0) : ?>
        <input required type="file" name="payment_proof" id="payment_proof">
      <?php endif; ?>
    </form>
  </main>

  <script src="assets/scripts/modal/message-modal.js"></script>
  <script src="assets/scripts/user/update-car.js"></script>
</body>

</html>