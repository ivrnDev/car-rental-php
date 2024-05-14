<div class="view-car-overlay" style="display: none;">
  <div class="view-car-content">
    <span class="view-car-x">x</span>
    <h1>Car Details</h1>
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
    position: relative;
    width: 60%;
    max-height: 80%;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    overflow: auto;
    display: flex;
    flex-direction: column;
    /* align-items: center; */
  }

  .view-car-x {
    position: absolute;
    top: 10px;
    right: 10px;
    color: #aaa;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
  }

  .view-car-x:hover {
    color: #000;
  }

  .car-image-container {
    width: 200px;
    height: 200px;
    overflow: hidden;
    border-radius: 100px;
    margin-bottom: 20px;
  }

  .car-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .car-details p {
    margin: 5px 0;
    line-height: 1.5;
    font-size: 16px;
  }

  .documents-container {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    gap: 10px;
    padding-top: 20px;
  }

  .documents-container img {
    width: 180px;
    height: 180px;
    object-fit: contain;
    border-radius: 5px;
  }

  .documents-container p {
    font-weight: bold;
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