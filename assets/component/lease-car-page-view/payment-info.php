<div class="view-payment-overlay" style="display: none;">
  <div class="view-payment-content">
    <span class="view-payment-x">x</span>
    <div class="view-payment">
      <img src="/drivesation/assets/images/gcash.jpg" alt="09916820831">
      <h1>09916820831</h1>
    </div>
  </div>
</div>

<style>
  .view-payment-overlay {
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

  .view-payment-content {
    position: absolute;
    top: 50%;
    left: 50%;
    height: 95%;
    width: 30%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow-y: auto;
    overflow-x: hidden;
  }

  .view-payment-x {
    position: absolute;
    top: 0px;
    right: 8px;
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
  }

  .view-payment-x:hover,
  .view-payment-x:focus {
    color: black;
    text-decoration: none;
  }

  .view-payment img {
    width: 100%;
    height: 90%;
    object-fit: cover;
    object-position: top;
  }

  .view-payment h1 {
    text-align: center;
    margin-top: 10px;
    font-size: 24px;
  }
</style>