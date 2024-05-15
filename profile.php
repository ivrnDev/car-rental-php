 <?php
  require_once "assets/component/header.php";
  require_once "assets/component/modals/confirmation-modal.php";
  require_once "assets/component/modals/message-modal.php";
  require_once "assets/component/loading.php";
  require_once "assets/component/reviews.php";
  require_once "functions/get-cars.php";
  require_once "utils/OracleDb.php";
  require_once "assets/component/profile-page-view/view-car-info.php";

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
   <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
 </head>

 <body>
   <main>
     <div class="left-column">
       <img src="<?= $profile_info['FILE_LINK'] ?>" alt="profile_picture">
       <h1><?= $profile_info['FULLNAME'] ?></h1>
       <p><?= $profile_info['USER_ID'] ?></p>
       <p><?= $profile_info['ADDRESS'] ?></p>
       <p>Phone:</p>
       <p><?= $profile_info['CONTACT_NUMBER'] ?></p>
       <p>Email:</p>
       <p><?= $profile_info['EMAIL_ADDRESS'] ?></p>
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
                      echo "Pending"; // 1-Approve and 2-Reject
                      break;
                    case 1:
                      echo "Approved"; // 3-Process and 0-Cancel
                      break;
                    case 2:
                      echo "Rejected";
                      break;
                    case 3:
                      echo "Processing";
                      break;
                    case 4:
                      echo "Receiving"; // 5- Mark as Received, 0-Contested
                      break;
                    case 5:
                      echo "On Going"; // 6-Return
                      break;
                    case 6:
                      echo "Returning";
                      break;
                    case 7:
                      echo "On Hold"; //8- Mark as Complete
                      break;
                    case 8:
                      echo "Completed";
                      break;
                    case 9:
                      echo "Under Review";
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

               <div class="flex-cell">
                 <button class="view-btn" data-car-id="<?= $rent['CAR_ID'] ?>" data-user-id="<?= $rent['OWNER_ID'] ?>" data-rent-id="<?= $rent['RENT_ID'] ?>">View</button>
               </div>
               <?php if ($rent['STATUS'] == 0) :
                ?>
                 <div class=" flex-cell action-btn">
                   <button class="reject-btn" data-rent-id="<?= $rent['RENT_ID'] ?>" data-status=10 data-car-id=<?= $rent['CAR_ID'] ?>>Cancel</button>
                 </div>
                 <div class="flex-cell"></div>

               <?php elseif ($rent['STATUS'] == 1) : ?>
                 <div class="flex-cell action-btn">
                   <button class="accept-btn" data-rent-id="<?= $rent['RENT_ID'] ?>" data-status=3 data-car-id=<?= $rent['CAR_ID'] ?>>Process Now</button>
                 </div>
                 <div class="flex-cell action-btn">
                   <button class="reject-btn" data-rent-id="<?= $rent['RENT_ID'] ?>" data-status=10 data-car-id=<?= $rent['CAR_ID'] ?>>Cancel</button>
                 </div>
               <?php elseif ($rent['STATUS'] == 4) : ?>
                 <div class="flex-cell action-btn">
                   <button class="accept-btn" data-rent-id="<?= $rent['RENT_ID'] ?>" data-status=5 data-car-id=<?= $rent['CAR_ID'] ?>>Mark as Received</button>
                 </div>
                 <div class="flex-cell action-btn">
                   <button class="reject-btn" data-rent-id="<?= $rent['RENT_ID'] ?>" data-status=9 data-car-id=<?= $rent['CAR_ID'] ?>>Not Receive</button>
                 </div>
               <?php elseif ($rent['STATUS'] == 5) : ?>
                 <div class="flex-cell action-btn">
                   <button class="accept-btn" data-rent-id="<?= $rent['RENT_ID'] ?>" data-status=6 data-car-id=<?= $rent['CAR_ID'] ?>>Return Car</button>
                 </div>
                 <div class="flex-cell">
                 </div>
               <?php elseif ($rent['STATUS'] == 7) : ?>
                 <div class="flex-cell action-btn">
                   <button class="accept-btn" data-rent-id="<?= $rent['RENT_ID'] ?>" data-status=8 data-car-id=<?= $rent['CAR_ID'] ?> data-user-id=<?= $rent['USER_ID'] ?>>Mark as Completed</button>
                 </div>
                 <div class="flex-cell action-btn">
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