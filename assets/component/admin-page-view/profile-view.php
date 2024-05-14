<div class="view-user-overlay" style="display: none;">
  <div class="view-user-content">
    <span class="view-user-x">x</span>
    <h1>Profile Information</h1>
    <div class="view-profile">
      
    </div>
  </div>
</div>


<style>
  .view-user-overlay {
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

  .view-user-content {
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

  .view-user-x {
    position: absolute;
    top: 10px;
    right: 10px;
    color: #aaa;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
  }

  .view-user-x:hover {
    color: #000;
  }

  .profile-image-container {
    width: 200px;
    height: 200px;
    overflow: hidden;
    border-radius: 100px;
    margin-bottom: 20px;
  }

  .profile-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .profile-details p {
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

  .view-user-x {
    position: absolute;
    top: 0px;
    right: 8px;
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
  }

  .view-user-x:hover,
  .view-user-x:focus {
    color: black;
    text-decoration: none;
  }
</style>