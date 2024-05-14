<div class="view-car-overlay" style="display: none ;">
  <div class="view-car-content">
    <span class="view-car-x">x</span>
    <h1>Car Details</h1>
    <div class="view-car">
    </div>
  </div>
</div>

<style>
  .car-details-container {
    display: flex;
    flex-direction: row;
    gap: 20px;
    flex-wrap: wrap;

  }

  .car-details-container div {
    flex: 1 1 25%;
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 20px;
  }

  .car-details-container div p {
    font-size: 20px;
  }

  .images {
    display: flex;
    gap: 4%;
  }

  .images-container {
    flex: 1 1 50%;
    margin-top: 20px
  }

  .car-image-container,
  .orcr-image-container {
    width: 100%;
    /* max-height: 50%; */
    border-radius: 8px;
  }

  .car-image-container img,
  .orcr-image-container img {
    width: 100%;
    height: 300px;
    border-radius: 8px;
    object-fit: contain;
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