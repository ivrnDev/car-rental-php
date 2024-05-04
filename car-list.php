<?php
require_once "assets/component/header.php";
require_once "functions/get-cars.php";
$db = new OracleDB();
$result = getAllCars($db);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Car List</title>
  <link rel="stylesheet" href="assets/styles/user/layout.css">
  <link rel="stylesheet" href="assets/styles/user/car-list.css">
  <link rel="stylesheet" href="assets/styles/component/button.css">
</head>

<body>
  <main>
    <?php foreach ($result as $car) : ?>
      <div class="card">
        <img src="<?= $car['FILE_LINK']; ?>" alt="<?= $car['CAR_TITLE'] ?>">
        <h1><?= htmlspecialchars($car['CAR_TITLE']); ?></h1>
        <p><?= htmlspecialchars($car['CAR_TYPE']) ?></p>
        <p><?= htmlspecialchars($car['SEAT_CAPACITY']) ?></p>
        <p><?= "₱" . htmlspecialchars(number_format($car['AMOUNT'])) . "/ day" ?></p>
        <a id="rent-button" href="car-details.php?car_id=<?= urlencode($car['CAR_ID']) ?>">Rent</a>
      </div>
    <?php endforeach; ?>

  </main>


</body>

</html>