<div id="confirmationPopup" class="popup-overlay" style="display: none;">
  <div class="popup-content">
    <h4>Confirm Action</h4>
    <p>Are you sure you want to proceed?</p>
    <button id="confirmYes" class="popup-button">Yes</button>
    <button id="confirmNo" class="popup-button">No</button>
  </div>
</div>

<style>
  .popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }

  .popup-content {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
  }

  .popup-button {
    margin: 10px;
    padding: 5px 20px;
  }
</style>