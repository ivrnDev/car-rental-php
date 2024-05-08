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
  require_once "assets/component/lease-car-page-view/view-rent-info.php";
  require_once "assets/component/lease-car-page-view/view-car-info.php";


  $db = new OracleDB();
  $carList = getUserCarList($userId, $db);
  $rentList = getRentersLists($userId, $db);
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

        <form id="createCarForm" method="POST" action="functions/create-car.php" enctype="multipart/form-data">

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

            <button id="createCarBtn" class="accept-btn" type="submit">CONFIRM</button>

          </div>



          <input required type="file" name="car_image" id="car_image">
          <input required type="file" name="orcr" id="orcr">
        </form>
      </div>

      <div class="car-list container">
        <h1>List of Cars</h1>
        <div class="flex-table">
          <div class="flex-row header">
            <div class="flex-cell"></div>
            <div class="flex-cell">ID</div>
            <div class="flex-cell">Title</div>
            <div class="flex-cell">Type</div>
            <div class="flex-cell">Model</div>
            <div class="flex-cell">Brand</div>
            <div class="flex-cell">Availability</div>
            <div class="flex-cell">Status</div>
            <div class="flex-cell">Amount</div>
            <div class="flex-cell"></div>
            <div class="flex-cell"></div>

          </div>
          <div class="flex-body">
            <?php foreach ($carList as $car) : ?>
              <div class="flex-row">
                <div class="flex-cell">
                  <?php
                  $fileLinks = $car['FILE_LINKS'];
                  $links = explode(',', $fileLinks);
                  $links = array_map('trim', $links);
                  if (count($links) >= 2) {
                  ?>
                    <img src="<?= htmlspecialchars($links[0]) ?>" alt="Car Image">
                  <?php
                  } else {
                    echo "<p>Image links are missing.</p>";
                  }
                  ?>
                </div>
                <div class="flex-cell"><?= $car['CAR_ID'] ?></div>
                <div class="flex-cell"><?= $car['CAR_TITLE'] ?></div>
                <div class="flex-cell"><?= $car['CAR_TYPE'] ?></div>
                <div class="flex-cell"><?= $car['CAR_MODEL'] ?></div>
                <div class="flex-cell"><?= $car['CAR_BRAND'] ?></div>
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
                <div class="flex-cell view-car">
                  <button class="view-btn" data-car-id="<?= $car['CAR_ID'] ?>">View</button>
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
                <div class="flex-cell view-rent">
                  <Button class="view-btn" data-car-id="<?= $rent['CAR_ID'] ?>" data-user-id="<?= $rent['USER_ID'] ?>" data-rent-id="<?= $rent['RENT_ID'] ?>">View</Button>
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
                    <button class="accept-btn" data-rent-id="<?= $rent['RENT_ID'] ?>" data-value=4>Picked Up</button>
                  </div>
                  <div class="flex-cell action-btn">
                    <button class="reject-btn" data-rent-id="<?= $rent['RENT_ID'] ?>" data-value=6 data-car-id="<?= $rent['CAR_ID'] ?>">Cancel</button>
                  </div>
                <?php elseif ($rent['STATUS'] == 4) : ?>
                  <div class="flex-cell action-btn">
                    <button class="accept-btn" data-rent-id="<?= $rent['RENT_ID'] ?>" data-value=5 data-car-id="<?= $rent['CAR_ID'] ?>">Complete</button>
                  </div>
                  <div class="flex-cell"></div>
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