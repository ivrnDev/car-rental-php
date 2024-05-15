<?php
require_once "assets/component/header.php";
require_once "functions/get-cars.php";
$db = new OracleDB();
$result = getAvailableCars($db);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Car List</title>
  <link rel="stylesheet" href="assets/styles/user/layout.css">
  <link rel="stylesheet" href="assets/styles/user/car-list.css">

</head>

<body>
  <main>
    <?php foreach ($result as $car) : ?>
      <div class="card">
        <div class="card-content">
          <img src="<?= $car['FILE_LINK']; ?>" alt="<?= $car['CAR_TITLE'] ?>">
          <h1><?= htmlspecialchars($car['CAR_TITLE']); ?></h1>
          <div class="row-items">

            <div class="car-type">
              <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
              <i class="material-icons" style="font-size:36px">directions_car</i>
              <p><?= htmlspecialchars($car['CAR_TYPE']) ?></p>
            </div>

            <div class="capacity">
              <i class="material-icons" style="font-size:36px">event_seat</i>
              <p><?= htmlspecialchars($car['SEAT_CAPACITY']) ?></p>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <p><?= "₱" . htmlspecialchars(number_format($car['AMOUNT']) . ' / day') ?></p>

          <?php if (empty($userId)) : ?>
            <a id="rent-button" href="signin.php">Rent</a>
          <?php else : ?>
            <a id="rent-button" href="car-details.php?car_id=<?= urlencode($car['CAR_ID']) ?>">Rent</a>
          <?php endif  ?>
        </div>
        


      </div>
      </div>
      </div>
    <?php endforeach; ?>

  </main>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jomhuria:wght@400" />
</body>

</html>