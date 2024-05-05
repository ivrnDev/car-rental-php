  <?php
  require_once "assets/component/header.php";
  require_once "functions/get-cars.php";
  require_once "functions/get-rent-list.php";
  require_once "assets/component/modals/confirmation.-modal.php";
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  $userId = $_SESSION['user_id'];
  if (empty($userId)) {
    header("Location: /drivesation/signin.php");
  }
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
    <link rel="stylesheet" href="assets/styles/component/confirmation-modal.css">
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
          <input id="car_title" name="car_title" type="text" placeholder="Car Title" autocomplete="off">
          <input id="car_description" name="car_description" type="text" placeholder="Description" autocomplete="off">
          <input id="car_model" name="car_model" type="text" placeholder="Car Model" autocomplete="off">
          <input id="plate_number" name="plate_number" type="text" placeholder="Plate Number" autocomplete="off">
          <input id="car_color" name="car_color" type="text" placeholder="Car Color" autocomplete="off">
          <input id="car_brand" name="car_brand" type="text" placeholder="Car Brand" autocomplete="off">
          <input id="gas_type" name="gas_type" type="text" placeholder="Gas Type" autocomplete="off">
          <input id="seat_capacity" name="seat_capacity" type="number" placeholder="Seat Capacity" autocomplete="off">
          <input id="car_type" name="car_type" type="text" placeholder="Car Type" autocomplete="off">
          <input id="amount" name="amount" type="number" placeholder="Amount" autocomplete="off">
          <label class="file-label" for="car_image">
            Car Image
            <img src="assets/images/add-image.png" alt="Add Image">
          </label>
          <label class="file-label" for="orcr">
            OR/CR
            <img src="assets/images/add-image.png" alt="Add Image">
          </label>

          <input type="file" name="car_image" id="car_image">
          <input type="file" name="orcr" id="orcr">
          <button id="createCarBtn" type="submit">CONFIRM</button>
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
            <div class="flex-cell"></div>

          </div>
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
                    echo "Approve";
                    break;
                  case 2:
                    echo "Rejected";
                    break;
                  default:
                    echo "Unknown";
                    break;
                } ?>
              </div>
              <div class="flex-cell"><?= "₱" . number_format($car['AMOUNT']) ?></div>
              <div class="flex-cell">
                <button class="view-btn">View</button>
              </div>
              <div class="flex-cell">
                <button class="accept-btn">Edit</button>
              </div>
              <div class="flex-cell">
                <button class="reject-btn">Delete</button>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="rent-list container">
        <div class="flex-table">
          <div class="flex-row header">
            <div class="flex-cell">ID</div>
            <div class="flex-cell">Pick Up Time</div>
            <div class="flex-cell">Rent Date</div>
            <div class="flex-cell">Return Date</div>
            <div class="flex-cell">Status</div>
            <div class="flex-cell">Transaction Date</div>
            <div class="flex-cell">Client</div>
            <div class="flex-cell"></div>
            <div class="flex-cell"></div>
          </div>
          <div class="flex-body">
            <?php foreach ($rentList as $rent) : ?>
              <div class="flex-row">
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
                  <?= date('M d, Y g:i A', strtotime($rent['TRANSACTION_DATE'])) ?>
                </div>
                <div class="flex-cell">
                  <Button class="view-btn">View</Button>
                </div>
                <?php if ($rent['STATUS'] == 0) :
                ?>
                  <div class="flex-cell action-btn">
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
    <script src="assets/scripts/user/update-car-availability.js"></script>
    <script src="assets/scripts/user/update-rent.js"></script>



  </body>

  </html>