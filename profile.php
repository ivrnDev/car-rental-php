 <?php
  require_once "assets/component/header.php";
  require_once "assets/component/modals/confirmation-modal.php";
  require_once "assets/component/modals/message-modal.php";
  require_once "assets/component/loading.php";
  require_once "functions/get-cars.php";
  require_once "utils/OracleDb.php";
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  $db = new OracleDB();
  $userId = $_SESSION["user_id"];
  $profile_info = getProfileInfo($userId, $db);
  $rent_history = getProfileRentHistory($userId, $db);
  $carList = getUserCarList($userId, $db);
  ?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profile</title>
   <link rel="stylesheet" href="assets/styles/user/layout.css">
   <link rel="stylesheet" href="assets/styles/user/profile.css">
   <link rel="stylesheet" href="assets/styles/component/table.css">
   <link rel="stylesheet" href="assets/styles/component/button.css">
 </head>

 <body>
   <main>
     <div class="left-column">
       <img src="<? $profile_info['FILE_LINK'] ?>" alt="profile_picture">
       <?php
        if (!empty($profile_info)) {
          echo '<ul>';
          foreach ($profile_info as $key => $value) {
            echo '<li>' . htmlspecialchars($value) . '</li>';
          }
          echo '</ul>';
        } else {
          echo '<p>No profile information available.</p>';
        }
        ?>
     </div>
     <div class="right-column">
       <button class="tab-button rentHistoryBtn">Rent History</button>
       <button class="tab-button carListedBtn">Car Listed</button>

       <div id="rentHistory" class="content-section">
         <div class="flex-row header">
           <div class="flex-cell">ID</div>
           <div class="flex-cell">Pick Up Time</div>
           <div class="flex-cell">Rent Date</div>
           <div class="flex-cell">Return Date</div>
           <div class="flex-cell">Status</div>
           <div class="flex-cell">Transaction Date</div>
           <div class="flex-cell">Details</div>
           <div class="flex-cell"></div>
           <div class="flex-cell"></div>
         </div>
         <div class="flex-body">
           <?php foreach ($rent_history as $rent) : ?>
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

               <div class="flex-cell"><?= date('M d, Y g:i A', strtotime($rent['TRANSACTION_DATE'])) ?></div>

               <div class="flex-cell">
                 <button class="view-btn">View</button>
               </div>
               <?php if ($rent['STATUS'] == 0) :
                ?>
                 <div class="flex-cell action-btn">
                   <button class="reject-btn" data-rent-id="<?= $rent['RENT_ID'] ?>" data-status=6 data-car-id=<?= $rent['CAR_ID'] ?>>Cancel</button>
                 </div>
                 <div class="flex-cell"></div>
               <?php elseif ($rent['STATUS'] == 1) : ?>
                 <div class="flex-cell action-btn">
                   <button class="accept-btn" data-rent-id="<?= $rent['RENT_ID'] ?>" data-status=3 data-car-id=<?= $rent['CAR_ID'] ?>>Process</button>
                 </div>
                 <div class="flex-cell action-btn">
                   <button class="reject-btn" data-rent-id="<?= $rent['RENT_ID'] ?>" data-status=6 data-car-id=<?= $rent['CAR_ID'] ?>>Cancel</button>
                 </div>
               <?php else : ?>
                 <div class="flex-cell"></div>
                 <div class="flex-cell"></div>
               <?php endif; ?>
             </div>
           <?php endforeach; ?>
         </div>
       </div>

       <div id="carListed" class="content-section">
         <div class="flex-row header">
           <div class="flex-cell">ID</div>
           <div class="flex-cell">Title</div>
           <div class="flex-cell">Type</div>
           <div class="flex-cell">Model</div>
           <div class="flex-cell">Color</div>
           <div class="flex-cell">Brand</div>
           <div class="flex-cell">Plate No.</div>
           <div class="flex-cell">Seats</div>
           <div class="flex-cell">Gas</div>
           <div class="flex-cell">Availability</div>
           <div class="flex-cell">Status</div>
           <div class="flex-cell">Amount</div>

         </div>
         <?php foreach ($carList as $car) : ?>
           <div class="flex-row">
             <div class="flex-cell"><?= $car['CAR_ID'] ?></div>
             <div class="flex-cell"><?= $car['CAR_TITLE'] ?></div>
             <div class="flex-cell"><?= $car['CAR_TYPE'] ?></div>
             <div class="flex-cell"><?= $car['CAR_MODEL'] ?></div>
             <div class="flex-cell"><?= $car['CAR_COLOR'] ?></div>
             <div class="flex-cell"><?= $car['CAR_BRAND'] ?></div>
             <div class="flex-cell"><?= $car['PLATE_NUMBER'] ?></div>
             <div class="flex-cell"><?= $car['SEAT_CAPACITY'] ?></div>
             <div class="flex-cell"><?= $car['GAS_TYPE'] ?></div>
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

           </div>
         <?php endforeach; ?>
       </div>
     </div>
   </main>
   <script src="./assets/scripts/user/profile-history.js"></script>
   <script src="assets/scripts/modal/message-modal.js"></script>
 </body>

 </html>