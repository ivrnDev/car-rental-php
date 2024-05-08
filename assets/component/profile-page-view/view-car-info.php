<div class="view-car-overlay" style="display: none;">
  <div class="view-car-content">
    <button class="view-car-x">x</button>
    <div class="view-profile">
    </div>
    <div class="view-car">
    </div>
  </div>
</div>

<style>
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
    height: 70%;
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
    top: 0;
    right: 0;
    width: 25px;
    height: 25px;
  }
</style>