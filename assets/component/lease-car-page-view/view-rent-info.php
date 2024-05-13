<div class="view-rent-overlay" style="display: none;">
  <div class="content">
    <span class="x">x</span>

    <h1>Profile Information</h1>
    <div class="profile-view">
    
    </div>

    <h1>Car Information</h1>
    <div class="car-view">
     
    </div>
  </div>

</div>


<style>
  .profile-view,
  .car-view {
    width: 100%;
    height: 70%;
    display: flex;
    margin-top: 2%;
  }

  .profile-details,
  .car-details {
    display: flex;
    flex-direction: column;
    gap: 5%;
    margin-left: 2%;
  }

  .content h1 {
    margin-top: 2%;
  }
  .content p {
    font-size: 20px;
    margin-top: 1%;
  }

  .rent-profile-container, .rent-car-container {
    width: 50%;
    height: 100%;
    border: 1px solid black;
  }

  .content img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
  }

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
    height: 90%;
    width: 80%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow-y: auto;
    overflow-x: hidden;
    display: flex;
    flex-direction: column;
    padding: 0 3% 3% 3%;

  }

  span.x {
    position: absolute;
    top: 10px;
    right: 10px;
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;

  }

  span.x:hover,
  span.x:focus {
    color: black;
    text-decoration: none;
  }
</style>