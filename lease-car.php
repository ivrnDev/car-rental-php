  <?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  $userId = $_SESSION['user_id'];
  if (empty($userId)) {
    header("Location: /drivesation/signin.php");
  }
  require_once "functions/get-cars.php";
  require_once "functions/get-rent-list.php";
  require_once "assets/component/header.php";
  require_once "assets/component/modals/message-modal.php";
  require_once "assets/component/loading.php";
  require_once "assets/component/modals/delete-car-modal.php";
  require_once "assets/component/modals/confirmation-modal.php";
  require_once "assets/component/modals/create-car-modal.php";
  require_once "assets/component/lease-car-page-view/view-rent-info.php";
  require_once "assets/component/lease-car-page-view/payment-info.php";
  require_once "assets/component/lease-car-page-view/view-car-info.php";
  $trashCars = getAllDeletedCars($userId, $db);

  require_once "assets/component/lease-car-page-view/trash.php";


  $db = new OracleDB();
  $carList = getUserCarList($userId, $db);
  $rentList = getRentersLists($userId, $db);
  $hasFreeTrial = getUserTrial($userId, $db);
  ?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lease Car</title>
    <link rel="stylesheet" href="assets/styles/user/layout.css">
    <link rel="stylesheet" href="assets/styles/component/button.css">
    <link rel="stylesheet" href="assets/styles/component/table.css">
    <link rel="stylesheet" href="assets/styles/user/lease-car.css">
  </head>

  <body>
    <main>
      <div class="lease-form container">
        <h1>Lease Car</h1>
        <p>Input the required fields</p>

        <form id="createCarForm" method="POST" enctype="multipart/form-data">
          <div class="left-column">
            <div class="input-container">
              <input id="car_title" name="car_title" type="text" placeholder="Car Title" autocomplete="off">
              <span class="error-message" id="car_title-error"></span>
            </div>
            <div class="input-container">
              <input required id="car_model" name="car_model" type="text" placeholder="Car Model" autocomplete="off">
              <span class="error-message" id="car_model-error"></span>
            </div>
            <div class="input-container">
              <textarea required id="car_description" name="car_description" type="" placeholder="Description" autocomplete="off" rows="4" cols="40"></textarea>
              <span class="error-message" id="car_description-error"></span>
            </div>
            <div class="input-container">
              <input required id="plate_number" name="plate_number" type="text" placeholder="Plate Number" autocomplete="off">
              <span class="error-message" id="plate_number-error"></span>
            </div>
            <div class="input-container">
              <input required id="car_color" name="car_color" type="text" placeholder="Car Color" autocomplete="off">
              <span class="error-message" id="car_color-error"></span>
            </div>
            <div class="input-container">
              <input required id="car_brand" name="car_brand" type="text" placeholder="Car Brand" autocomplete="off">
              <span class="error-message" id="car_brand-error"></span>
            </div>
            <h3>INPUT THE FOLLOWING DOCUMENTS:</h3>
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
              <input required id="gas_type" name="gas_type" type="text" placeholder="Gas Type" autocomplete="off">
              <span class="error-message" id="gas_type-error"></span>
            </div>
            <div class="input-container">
              <input required id="seat_capacity" name="seat_capacity" type="number" placeholder="Seat Capacity" autocomplete="off">
              <span class="error-message" id="seat_capacity-error"></span>
            </div>
            <div class="input-container">
              <input required id="car_type" name="car_type" type="text" placeholder="Car Type" autocomplete="off">
              <span class="error-message" id="car_type-error"></span>
            </div>
            <div class="input-container">
              <input required id="amount" name="amount" type="number" placeholder="Amount" autocomplete="off">
              <span class="error-message" id="amount-error"></span>
            </div>

            <?php if ($hasFreeTrial['FREE_TRIAL'] == 0) : ?>
              <label class="file-label" for="payment_proof" id="payment_proof_label">
                Proof of Payment
                <span id="payment_proof_name">No file chosen</span><img src="assets/images/add-image.png" alt="Add Proof">
              </label>
              <div class="processing-fee-container">
                <h1>
                  Processing Fee
                </h1>
                <span id="processing-fee" data-trial="<?= $hasFreeTrial['FREE_TRIAL'] ?>">
                  ₱ 0.00
                </span>
              </div>
              <button id="view-payment-method" class="view-btn" type="button">Payment Method</button>

            <?php else : ?>
              <label class="file-label disabled" id="payment_proof_label ">
                Proof of Payment
                <span id="payment_proof_name">No file chosen</span><img src="assets/images/add-image.png" alt="Add Proof">
              </label>
              <div class="processing-fee-container">
                <h1>
                  Processing Fee
                </h1>
                <span id="processing-fee" data-trial="<?= $hasFreeTrial['FREE_TRIAL'] ?>">
                  FREE
                </span>
              </div>
              <button id="view-payment-method" class="view-btn disabled" type="button" disabled>Payment Method</button>
            <?php endif; ?>
            <button id="createCarBtn" class="accept-btn" type="submit">Confirm</button>
          </div>

          <input required type="file" name="car_image" id="car_image">
          <input required type="file" name="orcr" id="orcr">
          <?php if ($hasFreeTrial['FREE_TRIAL'] == 0) : ?>
            <input required type="file" name="payment_proof" id="payment_proof">
          <?php endif; ?>
        </form>
      </div>

      <div class="car-list container">
        <h1>List of Cars</h1>
        <img id="trash-btn" src="assets/images/trash-icon.svg" alt="Trash">
        <div class="flex-table">
          <div class="flex-row header">
            <div class="flex-cell"></div>
            <div class="flex-cell">Car ID</div>
            <div class="flex-cell">Plate No.</div>
            <div class="flex-cell">Title</div>
            <div class="flex-cell">Availability</div>
            <div class="flex-cell">Status</div>
            <div class="flex-cell">Amount</div>
            <div class="flex-cell">Payment Status</div>
            <div class="flex-cell"></div>
            <div class="flex-cell"></div>
            <div class="flex-cell"></div>

          </div>
          <div class="flex-body">
            <?php foreach ($carList as $car) : ?>
              <div class="flex-row">
                <div class="flex-cell"><img src="<?= $car['FILE_LINK'] ?>" alt="<?= $car['CAR_TITLE'] ?>"></div>
                <div class="flex-cell"><?= $car['CAR_ID'] ?></div>
                <div class="flex-cell"><?= $car['PLATE_NUMBER'] ?></div>
                <div class="flex-cell"><?= $car['CAR_TITLE'] ?></div>
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
                    case 2:
                      echo "Cancelled";
                      break;
                    default:
                      echo "Unknown";
                      break;
                  } ?>
                </div>
                <div class="flex-cell"><?= "₱" . number_format($car['AMOUNT']) ?></div>
                <div class="flex-cell">
                  <?php switch ($car['PAYMENT_STATUS']) {
                    case 0:
                      echo "Pending";
                      break;
                    case 1:
                      echo "Processing";
                      break;
                    case 2:
                      echo "Paid";
                      break;
                    case 3:
                      echo "Unpaid";
                      break;
                    case 4:
                      echo "Free Trial";
                      break;
                    case 5:
                      echo "Cancelled";
                      break;
                    default:
                      echo "Unknown";
                      break;
                  } ?>
                </div>
                <div class="flex-cell view-car">
                  <button class="view-btn" data-car-id="<?= $car['CAR_ID'] ?>">View</button>
                </div>
                <div class="flex-cell">
                  <a href="update-car-details.php?car_id=<?= urlencode($car['CAR_ID']) ?>">
                    <button class="accept-btn" data-car-id="<?= $car['CAR_ID'] ?>">Update</button>
                  </a>
                </div>
                <div class="flex-cell delete-car">
                  <button class="reject-btn" data-delete-status=1 data-car-id="<?= $car['CAR_ID'] ?>">Delete</button>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <div class="rent-list container">
        <h1>List of Rents</h1>
        <div class="flex-table">
          <div class="flex-row header">
            <div class="flex-cell">ID</div>
            <div class="flex-cell">Pick Up Time</div>
            <div class="flex-cell">Rent Date</div>
            <div class="flex-cell">Return Date</div>
            <div class="flex-cell">Status</div>
            <div class="flex-cell">Transaction Date</div>
            <div class="flex-cell"></div>
            <div class="flex-cell"></div>
            <div class="flex-cell"></div>
          </div>
          <div class="flex-body">
            <?php foreach ($rentList as $rent) : ?>
              <div class="flex-row" data-rent-id="<?= $rent['RENT_ID'] ?>">
                <div class="flex-cell"><?= $rent['RENT_ID'] ?></div>
                <div class="flex-cell"><?= date('h:i A', strtotime($rent['PICK_UP_TIME'])) ?></div>
                <div class="flex-cell"><?= date('F d, Y', strtotime($rent['RENT_DATE_FROM'])) ?></div>
                <div class="flex-cell"><?= date('F d, Y', strtotime($rent['RENT_DATE_TO'])) ?></div>
                <div class="flex-cell status-cell">
                  <?php switch ($rent['STATUS']) {
                    case 0:
                      echo "Pending"; // 1-Accept and 2-Rejected
                      break;
                    case 1:
                      echo "Approved";
                      break;
                    case 2:
                      echo "Rejected";
                      break;
                    case 3:
                      echo "Processing"; // 4 - Mark as Sent 5 - Cancel
                      break;
                    case 4:
                      echo "Car Sent";
                      break;
                    case 5:
                      echo "On Going"; // 10 - Contact Support
                      break;
                    case 6:
                      echo "Receiving"; // 7-Mark as Received and 10-Contested
                      break;
                    case 7:
                      echo "On Hold";
                      break;
                    case 8:
                      echo "Completed";
                      break;
                    case 9:
                      echo "Under Review"; //10-Contact Support
                      break;
                    case 10:
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
                <div class="flex-cell view-rent">
                  <button class="view-btn" data-car-id="<?= $rent['CAR_ID'] ?>" data-user-id="<?= $rent['USER_ID'] ?>" data-rent-id="<?= $rent['RENT_ID'] ?>">View</button>
                </div>

                <?php if ($rent['STATUS'] == 0) :
                ?>
                  <div class=" flex-cell action-btn">
                    <button class="accept-btn" data-rent-id="<?= $rent['RENT_ID'] ?>" data-value=1 data-car-id="<?= $rent['CAR_ID'] ?>">Accept</button>
                  </div>

                  <div class="flex-cell action-btn">
                    <button class="reject-btn" data-rent-id="<?= $rent['RENT_ID'] ?>" data-value=2>Reject</button>
                  </div>

                <?php elseif ($rent['STATUS'] == 3) : ?>
                  <div class="flex-cell action-btn">
                    <button class="accept-btn" data-rent-id="<?= $rent['RENT_ID'] ?>" data-value=4>Mark as Sent</button>
                  </div>
                  <div class="flex-cell action-btn">
                    <button class="reject-btn" data-rent-id="<?= $rent['RENT_ID'] ?>" data-value=10 data-car-id="<?= $rent['CAR_ID'] ?>">Cancel</button>
                  </div>

                <?php elseif ($rent['STATUS'] == 5) : ?>
                  <div class="flex-cell action-btn">
                    <button class="view-btn" data-rent-id="<?= $rent['RENT_ID'] ?>" data-value=9 data-car-id="<?= $rent['CAR_ID'] ?>">Contact Support</button>
                  </div>
                  <div class="flex-cell"></div>

                <?php elseif ($rent['STATUS'] == 6) : ?>
                  <div class="flex-cell action-btn">
                    <button class="accept-btn" data-rent-id="<?= $rent['RENT_ID'] ?>" data-value=7 data-car-id="<?= $rent['CAR_ID'] ?>">Mark as Received</button>
                  </div>
                  <div class="flex-cell action-btn">
                    <button class="reject-btn" data-rent-id="<?= $rent['RENT_ID'] ?>" data-value=9 data-car-id="<?= $rent['CAR_ID'] ?>">Not Receive</button>
                  </div>

                <?php else : ?>
                  <div class="flex-cell"></div>
                  <div class="flex-cell"></div>
                <?php endif; ?>

              </div>
            <?php endforeach; ?>

          </div>
        </div>
      </div>
    </main>
    <script src="assets/scripts/modal/message-modal.js"></script>
    <script src="assets/scripts/user/lease-form.js"></script>
    <script src="assets/scripts/user/rent-list.js"></script>
    <script src="assets/scripts/user/car-list.js"></script>




  </body>

  </html>