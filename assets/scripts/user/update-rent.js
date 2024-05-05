document.addEventListener('DOMContentLoaded', () => {
  const popup = document.getElementById('confirmationPopup');
  const confirmYes = document.getElementById('confirmYes');
  const confirmNo = document.getElementById('confirmNo');
  const actionBtnContainers = document.querySelectorAll('.action-btn')
  let currentButton;

  actionBtnContainers.forEach(container => {
    const buttons = container.querySelectorAll('button');
    buttons.forEach(button => {
      button.addEventListener('click', function () {
        currentButton = this;
        popup.style.display = 'flex';
      });
    });
  });

  confirmYes.addEventListener('click', function () {
    const rentId = currentButton.getAttribute('data-rent-id');
    const statusCode = currentButton.getAttribute('data-value');
    popup.style.display = 'none';
    updateRentStatus(rentId, statusCode, currentButton);
  });

  confirmNo.addEventListener('click', function () {
    popup.style.display = 'none';
  });

  function updateRentStatus(rentId, newStatus, button) {
    fetch('functions/update-rent-status.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: 'rent_id=' + encodeURIComponent(rentId) + '&new_status=' + newStatus
    })
      .then(response => response.json())
      .then(data => {
        if (data.error) {
          throw new Error(data.error);
        }
        const statusText = convertStatusCodeToText(data.STATUS);
        const statusCell = button.closest('.flex-row').querySelector('.status-cell');
        statusCell.textContent = statusText;
        disableRowButtons(button);
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Failed to update: ' + error.message);
      });
  }

});

function disableRowButtons(button) {
  const buttons = button.closest('.flex-row').querySelectorAll('.accept-btn, .reject-btn');
  buttons.forEach(btn => btn.style.display = "none");
}

function convertStatusCodeToText(code) {
  const statusLookup = {
    0: "Pending",
    1: "Approved",
    2: "Rejected",
    3: "Processing",
    4: "On Going",
    5: "Completed",
    6: "Cancelled",
    default: "Unknown"
  };
  return statusLookup[code] || statusLookup.default;
}
