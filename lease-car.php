 <?php
require_once "utils/OracleDb.php";
require_once "utils/upload.php";
session_start();
$owner_id = $_SESSION['user_id'];
$db = new OracleDB();
if (!$db->isConnected()) {
  die("Database connection failed");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset(
    $_POST['car_model'],
    $_POST['plate_number'],
    $_POST['car_color'],
    $_POST['car_brand'],
    $_POST['gas_type'],
    $_POST['seat_capacity'],
    $_FILES['orcr'],
  )) {
    try {
      $car_model = $_POST['car_model'];
      $plate_number = $_POST['plate_number'];
      $car_color = $_POST['car_color'];
      $gas_type = $_POST['gas_type'];
      $car_brand = $_POST['car_brand'];
      $seat_capacity = $_POST['seat_capacity'];
      $orcr = $_FILES['orcr'];

      $sql = "INSERT INTO Car (car_id, car_model, plate_number, car_color, car_brand, availability_status, status, gas_type, seat_capacity, owner_id) VALUES (car_seq.NEXTVAL, :car_model, :plate_number, :car_color, :car_brand, :availability_status, :status, :gas_type, :seat_capacity, :owner_id) RETURNING car_id INTO :new_car_id";

      $data = [
        ':car_model' => $car_model,
        ':plate_number' => $plate_number,
        ':car_color' => $car_color,
        ':car_brand' => $car_brand,
        ':seat_capacity' => $seat_capacity,
        ':gas_type' => $gas_type,
        ':availability_status' => 0,
        ':status' => 0,
        ':owner_id' => $owner_id,
      ];

      $stid = $db->prepareStatement($sql);
      foreach ($data as $key => $val) {
        if (!oci_bind_by_name($stid, $key, $data[$key])) {
          $e = oci_error($stid);
          throw new Exception('Bind Error: ' . $e['message']);
        }
      }

      $new_car_id = 0;
      oci_bind_by_name($stid, ":new_car_id", $new_car_id, -1, OCI_B_INT);
      if (!oci_execute($stid)) {
        $e = oci_error($stid);
        throw new Exception('Execute Error: ' . $e['message']);
      }
      echo "<p>Car details saved successfully!</p>";

      $documents = [
        'orcr' => 'ORCR',
      ];

      $allFilesProvided = true;
      foreach ($documents as $inputName => $docType) {
        if (!isset($_FILES[$inputName]) || $_FILES[$inputName]['error'] ==         UPLOAD_ERR_NO_FILE) {
          echo "File $docType not provided.<br>";
          $allFilesProvided = false;
        }
      }
      if ($allFilesProvided) {
        foreach ($documents as $inputName => $documentName) {
          uploadCarDocuments($_FILES[$inputName], $new_car_id, $inputName, $documentName, $db);
        }
      } else {
        echo "All documents are required. Please upload each file.<br>";
      }
      oci_free_statement($stid);
    } catch (Exception $e) {
      throw new Exception("EROR", $e->getMessage());
    }
  } else {
    throw new Exception("Input required fields");
  }
}
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
   <?php
    require_once "assets/component/header.php";
    ?>
   <main>
     <div class="lease-form container">
       <h1>Lease Car</h1>
       <p>Input the required fields</p>
       <form id="createCarForm" method="POST" enctype="multipart/form-data">
         <input id="car_model" name="car_model" type="text" placeholder="Car Model" autocomplete="off" >
         <input id="plate_number" name="plate_number" type="text" placeholder="Plate Number" autocomplete="off" >
         <input id="car_color" name="car_color" type="text" placeholder="Car Color" autocomplete="off">
         <input id="car_brand" name="car_brand" type="text" placeholder="Car Brand" autocomplete="off">
         <input id="gas_type" name="gas_type" type="text" placeholder="Gas Type" autocomplete="off">
         <input id="seat_capacity" name="seat_capacity" type="number" placeholder="Seat Capacity" autocomplete="off">
         <label class="file-label" for="orcr">
           OR/CR
           <img src="assets/images/add-image.png" alt="Add Image">
         </label>

         <input type="file" name="orcr" id="orcr">
         <button id="createCarBtn" type="submit">CONFIRM</button>
       </form>
     </div>

     <div class="car-list container">
       <h1>List of Cars</h1>
     </div>

     <div class="rent-list container">
       <h1>List of Rent</h1>
     </div>

   </main>

 </body>

 </html>