 <?php
  require_once "assets/component/header.php";
  require_once "functions/get-cars.php";
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  $userId = $_SESSION['user_id'];
  if (empty($userId)) {
    header("Location: /drivesation/signin.php");
  }
  $db = new OracleDB();
  $carList = getUserCarList($userId, $db);

  ?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Lease Car</title>
   <link rel="stylesheet" href="assets/styles/user/layout.css">
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
       <div class="flex-row header">
         <div class="flex-cell">ID</div>
         <div class="flex-cell">Title</div>
         <div class="flex-cell">Description</div>
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
           <div class="flex-cell">
             <?php
              $fileLinks = $car['FILE_LINKS'];
              $links = explode(',', $fileLinks);
              $links = array_map('trim', $links);
              if (count($links) >= 2) {
              ?>

               <img src="<?= htmlspecialchars($links[0]) ?>" alt="Car Image">
               <img src="<?= htmlspecialchars($links[1]) ?>" alt="OR/CR Document">
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

     <div class="rent-list container">
       <h1>List of Rent</h1>
     </div>

   </main>

 </body>

 </html>