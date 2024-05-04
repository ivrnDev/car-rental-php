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
</head>

<body>
  <main>
    <div class="card">
      <img src="uploads/car/5/5_car_image-20240504030324.jpg" alt="car image">
      <h1>Ferrari</h1>
    </div>
   


  </main>


</body>

</html>