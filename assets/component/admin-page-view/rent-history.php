<div class="view-renthistory-overlay" style="display: none;">
  <div class="view-renthistory-content">
    <button class="view-renthistory-x">X</button>
    <div class="view-renthistory">
    </div>
  </div>
</div>

<style>
  .view-renthistory-overlay {
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

  .view-renthistory-content {
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

  .view-renthistory-x {
    position: absolute;
    top: 0;
    right: 0;
    width: 25px;
    height: 25px;
  }
</style>