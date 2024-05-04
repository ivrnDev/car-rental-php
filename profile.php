 <?php
  require_once "functions/get-profile.php";
  require_once "utils/OracleDb.php";
  session_start();
  $db = new OracleDB();
  $userId = $_SESSION["user_id"];
  $profile_link = getProfilePicture($userId, $db);
  $imageSrc = !empty($profile_link) ? htmlspecialchars($profile_link) : 'assets/images/default-profile.png';

  $profile_info = getProfileInfo($userId, $db);
  $rent_history = getProfileRentHistory($userId, $db);

  ?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profile</title>
   <link rel="stylesheet" href="assets/styles/user/layout.css">
   <link rel="stylesheet" href="assets/styles/user/profile.css">
 </head>

 <body>
   <?php require_once "assets/component/header.php"; ?>



   <main>
     <div class="left-column">
       <img src="<?php echo $imageSrc ?>" alt="">
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
       <h1>Rent History</h1>
       <div class="flex-table">
         <div class="flex-row header">
           <div class="flex-cell">ID</div>
           <div class="flex-cell">Pick Up Time</div>
           <div class="flex-cell">Rent Date</div>
           <div class="flex-cell">Return Date</div>
           <div class="flex-cell">Status</div>
           <div class="flex-cell">Transaction Date</div>
           <div class="flex-cell">Car Owner</div>
           <div class="flex-cell">Car Details</div>
           <div class="flex-cell"></div>
         </div>
         <?php foreach ($rent_history as $rent) : ?>
           <div class="flex-row">
             <div class="flex-cell"><?= $rent['RENT_ID'] ?></div>
             <div class="flex-cell"><?= date('h:i A', strtotime($rent['PICK_UP_TIME'])) ?></div>
             <div class="flex-cell"><?= date('F d, Y', strtotime($rent['RENT_DATE_FROM'])) ?></div>
             <div class="flex-cell"><?= date('F d, Y', strtotime($rent['RENT_DATE_TO'])) ?></div>
             <div class="flex-cell">
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
                  default:
                    echo "Unknown";
                    break;
                } ?>
             </div>

             <div class="flex-cell"><?= date('M d, Y g:i A', strtotime($rent['TRANSACTION_DATE'])) ?></div>
             <div class="flex-cell">
               <Button class="view-btn">View</Button>
             </div>
             <div class="flex-cell">
               <Button class="accept-btn">Accept</Button>
             </div>
             <div class="flex-cell">
               <Button class="reject-btn">Reject</Button>
             </div>
           </div>
         <?php endforeach; ?>
       </div>
     </div>
   </main>


 </body>

 </html>