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
    z-index: 1000;
  }

  .view-rent-overlay .content {
    background-color: red;
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

  button.x {
    position: fixed;
    top: 0;
    left: 0;
    width: 25px;
    height: 25px;
  }

  .view-rent-overlay #profile-image {
    width: 20%;
    height: auto;


  }
</style>