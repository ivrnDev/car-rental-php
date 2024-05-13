<div class="view-car-overlay" style="display: none;">
  <div class="view-car-content">
    <span class="view-car-x">x</span>
    <div class="view-car">
      <h1>Car Details</h1>
      <div class="image-container">
        <img src="assets/images/car_in_log_in.png" alt="car-image">
      </div>

    </div>
  </div>
</div>

<style>
  .image-container {
    width: 40%;
    height: 40%;
    border: 1px solid black;
  }

  .image-container img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
  }

  .view-car-overlay {
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

  .view-car-content {
    position: absolute;
    top: 50%;
    left: 50%;
    height: 90%;
    width: 80%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow-y: auto;
    overflow-x: hidden;
  }

  .view-car-x {
    position: absolute;
    top: 0px;
    right: 8px;
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
  }

  .view-car-x:hover,
  .view-car-x:focus {
    color: black;
    text-decoration: none;
  }
</style>