<div id="createCarPopup" class="create-car-overlay" style="display: none;">
  <div class="create-car-content">
    <h4>Confirm Action</h4>
    <p>Do you really want to update this car?</p>
    <button id="createCarYes" class="create-car-button" type="button">Yes</button>
    <button id="createCarNo" class="create-car-button" type="button">No</button>
  </div>
</div>

<style>
  .create-car-overlay {
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

  .create-car-content {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
  }

  .create-car-button {
    margin: 10px;
    padding: 5px 20px;
  }
</style>