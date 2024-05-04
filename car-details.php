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
      <h1><?= htmlspecialchars($result['CAR_TITLE']); ?></h1>
      <p><?= htmlspecialchars($result['CAR_TYPE']) ?></p>
      <p><?= htmlspecialchars($result['SEAT_CAPACITY']) ?></p>
      <p><?= htmlspecialchars($result['CAR_MODEL']) ?></p>
      <p><?= htmlspecialchars($result['CAR_COLOR']) ?></p>
      <p><?= htmlspecialchars($result['PLATE_NUMBER']) ?></p>
      <p><?= htmlspecialchars($result['GAS_TYPE']) ?></p>
      <p><?= htmlspecialchars($result['CAR_DESCRIPTION']) ?></p>
      <p><?= htmlspecialchars($result['OWNER_NAME']) ?></p>
      <p><?= htmlspecialchars($result['CONTACT_NUMBER']) ?></p>
      <p><?= htmlspecialchars($result['EMAIL_ADDRESS']) ?></p>
      <p id="costDisplay"></p>

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
      rentFromDateInput.min = new Date().toISOString().split('T')[0];;
      rentToDateInput.min = new Date().toISOString().split('T')[0];;
    });
  </script>
</body>

</html>