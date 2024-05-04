<?php
require_once "assets/component/header.php";
require_once "functions/get-cars.php";
if (isset($_GET['car_id'])) {
  $car_id = htmlspecialchars($_GET['car_id']);
  $db = new OracleDB();
  $result = getCarDetails($car_id, $db);
  if(empty($result)){
    header("Location: /drivesation/car-list.php");
  }
  echo "<pre>";
  print_r($result);
  echo "<pre>";
} else {
  throw new Exception("Error: No Parameters");
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
    <!-- <?php foreach ($result as $car) : ?>
      <div class="card">
        <img src="<?= $car['FILE_LINK']; ?>" alt="<?= $car['CAR_TITLE'] ?>">
        <h1><?= htmlspecialchars($car['CAR_TITLE']); ?></h1>
        <p><?= htmlspecialchars($car['CAR_TYPE']) ?></p>
        <p><?= htmlspecialchars($car['SEAT_CAPACITY']) ?></p>
        <p><?= "₱" . htmlspecialchars(number_format($car['AMOUNT'])) . "/ day" ?></p>
        <a href="car-details.php?car_id=<?= urlencode($car['CAR_ID']) ?>">Rent</a>
      </div>
    <?php endforeach; ?> -->

  </main>


</body>

</html>