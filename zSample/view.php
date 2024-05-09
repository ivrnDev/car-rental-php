<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Car Info Page</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background-color: #252f44;
    }

    .profile-card,
    .car-card {
      border: 1px solid #ccc;
      border-radius: 8px;
      overflow: hidden;
      width: 400px;
      height: 700px;
      margin: 0 20px;
      display: flex;
      flex-direction: column;
      background-color: #FFFFFF;
    }

    .profile-info,
    .car-info {
      padding: 20px;
      flex-grow: 1;
      /* Allow content to grow */
    }

    .profile-img,
    .car-img {
      width: 100%;
      height: auto;
    }

    .name {
      margin: 0;
      font-size: 20px;
    }

    .id,
    .address,
    .phone,
    .email,
    .car-type,
    .car-color,
    .car-model,
    .gas,
    .car-des,
    .plate,
    .owner,
    .seat-cap,
    .contact {
      margin: 5px 0;
      padding: 8px;
      font-size: 16px;
    }

    .car-des {
      font-weight: bold;
    }

    .car-type::before,
    .car-color::before,
    .car-model::before,
    .gas::before,
    .car-des::before,
    .plate::before,
    .owner::before,
    .seat-cap::before,
    .contact::before {
      content: attr(class) ": ";
      font-weight: bold;
    }

    .car-type::before {
      content: "Type: ";
    }

    .car-color::before {
      content: "Color: ";
    }

    .car-model::before {
      content: "Model: ";
    }

    .gas::before {
      content: "Fuel Type: ";
    }

    .car-des::before {
      content: "Description: ";
    }

    .plate::before {
      content: "Plate Number: ";
    }

    .owner::before {
      content: "Owner: ";
    }

    .seat-cap::before {
      content: "Seat Capacity: ";
    }

    .contact::before {
      content: "Contact: ";
    }

    /* Background colors for p classes */
    .id,
    .address,
    .phone,
    .email {
      background-color: #dbd8e3;
    }

    .car-type,
    .car-color,
    .car-model,
    .gas,
    .car-des,
    .plate,
    .owner,
    .seat-cap,
    .contact {
      background-color: #d3d3d3;
    }
  </style>
</head>

<body>

 

  <div class="car-card">
    <img src="https://images.squarespace-cdn.com/content/v1/51cdafc4e4b09eb676a64e68/1470951917131-VO6KK2XIFP4LPLCYW7YU/McQueen15.jpg" class="car-img">
    <div class="car-info">
      <h1 class="title">TOYOTA</h1>
      <p class="car-type">Type: Sedan </p>
      <p class="car-color">Color: Blue </p>
      <p class="car-model">Model: Vios</p>
      <p class="gas">Fuel Type: Diesel</p>
      <p class="seat-cap"> Seat Capacity: 8 Seaters</p>
      <p class="car-des">Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
      <p class="plate">Plate Number: ABC-1234</p>
      <p class="owner">Owner: Justine Mendiola</p>
      <p class="contact">Contact: 09283281386</p>
    </div>
  </div>

</body>

</html>