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
      <form id="createCarForm" method="POST" action="functions/create-car.php">
        <input id="car_model" name="car_model" type="text" placeholder="Car Model" autocomplete="off">
        <input id="plate_number" name="plate_number" type="text" placeholder="Plate Number" autocomplete="off">
        <input id="car_color" name="car_color" type="text" placeholder="Car Color" autocomplete="off">
        <input id="car_brand" name="car_brand" type="text" placeholder="Car Brand" autocomplete="off">
        <input id="door_count" name="door_count" type="text" placeholder="Door Count" autocomplete="off">
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