 <?php 
  require_once "../utils/OracleDb.php";
  require_once "../utils/upload.php";
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
        $_POST['door_count'],
        $_POST['gas_type'],
        $_POST['seat_capacity'],
        $_FILES['orcr'],
    )) {
       try {
          $car_model = $_POST['car_model'];
          $plate_number = $_POST['plate_number'];
          $car_color = $_POST['car_color'];
          $car_brand = $_POST['car_brand'];
          $door_count = $_POST['door_count'];
          $gas_type = $_POST['gas_type'];
          $seat_capacity = $_POST['seat_capacity'];
          $orcr = $_FILES['orcr'];
          echo $car_model;
          echo "HEllo";

            $sql = "INSERT INTO Car (car_id, car_model, plate_number, car_color, car_brand, door_count, gas_type, seat_capacity, owner_id) VALUES (car_seq.NEXTVAL, :car_model, :plate_number, :car_color, :car_brand, :door_count, :gas_type, :seat_capacity, :owner_id)
            RETURNING car_id INTO :new_car_id";
            
            $data = [
                ':car_model' => $car_model,
                ':plate_number' => $plate_number,
                ':car_color' => $car_color,
                ':car_brand' => $car_brand,
                ':door_count' => $door_count,
                ':gas_type' => $gas_type,
                ':seat_capacity' => $seat_capacity,
                ':owner_id' => 44,
            ];  

            $stid = $db->prepareStatement($sql);
            // oci_bind_by_name($stid, ":car_model", $car_model);
            // oci_bind_by_name($stid, ":plate_number", $plate_number);
            // oci_bind_by_name($stid, ":car_brand", $car_brand);
            // oci_bind_by_name($stid, ":door_count", $door_count);
            // oci_bind_by_name($stid, ":gas_type", $gas_type);
            // oci_bind_by_name($stid, ":seat_capacity", $seat_capacity);
            // oci_bind_by_name($stid, ":owner_id", $owner_id);
            foreach ($data as $key => $val) {
            oci_bind_by_name($stid, $key, $data[$key]);
            }
            
            $new_car_id = 0;
            oci_bind_by_name($stid, ":new_car_id", $new_car_id, -1, OCI_B_INT);
            
            oci_execute($stid);
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
                    uploadCarDocuments($_FILES[$inputName], $new_user_id, $inputName, $documentName, $db);
                  }
              } else {
                  echo "All documents are required. Please upload each file.<br>";
              }
                oci_free_statement($stid);
          } catch (Exception $e) {
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
      }
    }
?>