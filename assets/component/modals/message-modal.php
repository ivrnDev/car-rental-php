<div id="messageModal" class="modal">
  <div class="message-modal-content">
    <span class="message-close-button">×</span>
    <h1 class="message-modal-header"></h1>
    <p class="message-modal-text"></p>
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
    background-color: rgba(0, 0, 0, 0.4);
    justify-content: center;
    align-items: center;
  }

  .message-modal-content {
    border-radius: 10px;
    position: relative;
    background-color: #fefefe;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 30%;
    min-height: 20%;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    /* align-items: center; */
  }

  .message-close-button {
    position: absolute;
    top: 10px;
    right: 15px;
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
  }

  .message-close-button:hover,
  .message-close-button:focus {
    color: black;
    text-decoration: none;
  }

  .message-modal-header {
    color: #333;
    /* Subtle text color for the header */
    margin-bottom: 20px;
  }

  .message-modal-text {
    color: #666;
    margin-left: 10px;
    /* text-align: center; */
  }

  /* Success and error specific styles */
  .success {
    color: #4CAF50;
    /* Green for success */
  }

  .error {
    color: #D32F2F;
    /* Red for error */
  }

  .initial {
    color: #333;
  }
</style>