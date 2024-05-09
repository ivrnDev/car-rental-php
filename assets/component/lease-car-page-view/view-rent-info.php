<div class="view-rent-overlay" style="display: none;">
  <div class="content">
    <button class="x">X</button>

    <div class="profile-view">

    </div>

    <div class="car-view">

    </div>
  </div>

</div>


<style>
  .view-rent-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 101;
  }

  .view-rent-overlay .content {
    position: absolute;
    top: 50%;
    left: 50%;
    height: 70%;
    width: 80%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow-y: auto;
    overflow-x: hidden;
    display: flex;
  }

  button.x {
    position: fixed;
    top: 0;
    right: 0;
    width: 25px;
    height: 25px;
  }

  .view-rent-overlay #profile-image {
    width: 20%;
    height: auto;
  }

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
    flex: 1;
  }

  .profile-info,
  .car-info {
    padding: 20px;
    flex-grow: 1;
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

  .id,
  .address,
  .phone,
  .email {
    background-color: #dbd8e3;
  }

  .car-type,
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