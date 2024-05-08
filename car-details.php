<?php
require_once "assets/component/header.php";
require_once "functions/get-cars.php";

if (isset($_GET['car_id'])) {
  $car_id = htmlspecialchars($_GET['car_id']);
  $db = new OracleDB();
  $result = getCarDetails($car_id, $db);
  if (empty($result)) {
    header("Location: /drivesation/car-list.php");
  }
} else {
  throw new Exception("Error: No Parameters");
}

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$userId = $_SESSION['user_id'];
$db = new OracleDB();
if (!$db->isConnected()) {
  die("Database connection failed");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset(
    $_POST['pick_up_time'],
    $_POST['rent_date_from'],
    $_POST['rent_date_to'],
  )) {
    try {
      $pick_up_time = $_POST['pick_up_time'];
      $rent_date_from = $_POST['rent_date_from'];
      $rent_date_to = $_POST['rent_date_to'];

      $sql = "INSERT INTO Rent (rent_id, user_id, owner_id, car_id, pick_up_time, rent_date_from, rent_date_to, status, transaction_date) VALUES (rent_seq.NEXTVAL, :user_id, :owner_id, :car_id, :pick_up_time, TO_DATE(:rent_date_from, 'YYYY-MM-DD'), TO_DATE(:rent_date_to, 'YYYY-MM-DD'), 0, SYSDATE)";

      $data = [
        ':user_id' => $userId,
        ':owner_id' => $result['OWNER_ID'],
        ':car_id' => $result['CAR_ID'],
        ':pick_up_time' => $pick_up_time,
        ':rent_date_from' => $rent_date_from,
        ':rent_date_to' => $rent_date_to,
      ];

      $db->executeQuery($sql, $data);

      echo "<p>Rent successfully!</p>";
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
  <title>Car Details</title>
  <link rel="stylesheet" href="assets/styles/user/layout.css">
  <link rel="stylesheet" href="assets/styles/user/car-details.css">
</head>

<body>
  <main>
    <div class="card">

      <img src="<?= $result['FILE_LINK']; ?>" alt="<?= $result['CAR_TITLE'] ?>">

      <div class="info">



        <div class="first-line">
          <div class="type">
            <p class="car-type>"><?= htmlspecialchars($result['CAR_TYPE']) ?></p>
          </div>
        </div>

        <p class="seat-cap>"><?= htmlspecialchars($result['SEAT_CAPACITY']) ?></p>
        <p class="car-model"><?= htmlspecialchars($result['CAR_MODEL']) ?></p>
        <p class="car-color"><?= htmlspecialchars($result['CAR_COLOR']) ?></p>
        <p class="plate"><?= htmlspecialchars($result['PLATE_NUMBER']) ?></p>
        <p class="gas"><?= htmlspecialchars($result['GAS_TYPE']) ?></p>
        <p class="car-des"><?= htmlspecialchars($result['CAR_DESCRIPTION']) ?></p>
        <p class="owner-name"><?= htmlspecialchars($result['OWNER_NAME']) ?></p>
        <p class="contact"><?= htmlspecialchars($result['CONTACT_NUMBER']) ?></p>
        <p class="email"><?= htmlspecialchars($result['EMAIL_ADDRESS']) ?></p>

      </div>
    </div>
    <div>

      <form method="POST">
        <label for="pick_up_time">Pick up Time</label>
        <input id="pick_up_time" name="pick_up_time" type="time">

        <label for=" rent_date_from">Pick up Date</label>
        <input id="rent_date_from" name="rent_date_from" type="date">

        <label for=" rent_date_to">Return Date</label>
        <input id="rent_date_to" name="rent_date_to" type="date">

        <button type="submit" <?php if ($result['OWNER_ID'] == $userId) echo "disabled" ?>>Rent a Car</button>


      </form>
    </div>
  </main>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const rentFromDateInput = document.getElementById('rent_date_from');
      const rentToDateInput = document.getElementById('rent_date_to');

      const today = new Date().toISOString().split('T')[0];
      rentFromDateInput.min = today;
      rentToDateInput.min = today;

      rentFromDateInput.addEventListener('change', function() {
        const fromDate = new Date(rentFromDateInput.value);
        fromDate.setDate(fromDate.getDate() + 1); // Adding one day to the pick-up date
        const nextDay = fromDate.toISOString().split('T')[0];

        rentToDateInput.min = nextDay;

        if (rentToDateInput.value && rentToDateInput.value < rentToDateInput.min) {
          rentToDateInput.value = nextDay;
        }
      });

      rentToDateInput.addEventListener('change', function() {
        const toDate = new Date(rentToDateInput.value);
        toDate.setDate(toDate.getDate() - 1);
        const previousDay = toDate.toISOString().split('T')[0];

        rentFromDateInput.max = previousDay;

        if (rentFromDateInput.value && rentFromDateInput.value > rentFromDateInput.max) {
          rentFromDateInput.value = previousDay;
        }
      });
    });
  </script>

</html>