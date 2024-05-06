<div id="messageModal" class="modal">
  <div class="message-modal-content">
    <h1 class="message-modal-header"></h1>
    <span class="message-close-button">×</span>
    <p class="message-modal-text">Success </p>
  </div>
</div>

<style>
  .modal {
    display: none;
    position: fixed;
    z-index: 101;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0, 0, 0);
    background-color: rgba(0, 0, 0, 0.4);

  }

  .message-modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 30%;
  }

  .message-close-button {
    position: sticky;
    top: 0;
    right: 0;
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
  }

  .message-close-button:hover,
  .message-close-button:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }
</style>