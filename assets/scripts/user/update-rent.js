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
    const carId = currentButton.getAttribute('data-car-id');
    const statusCode = currentButton.getAttribute('data-value');
    popup.style.display = 'none';

    updateRentStatus(rentId, carId, statusCode, currentButton);
    const convert = {
      1: 2, // On Lease
      5: 1, // Available
      6: 1, // Available
    }
    if (statusCode in convert) {
      //Update Car Availability Status
      const result = updateCarAvailability(carId, convert[statusCode]);
    }

  });

  confirmNo.addEventListener('click', function () {
    popup.style.display = 'none';
  });

  function updateRentStatus(rentId, carId, newStatus, button) {
    fetch('api/update-rent-status.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `rent_id=${encodeURIComponent(rentId)}&new_status=${encodeURIComponent(newStatus)}&car_id=${encodeURIComponent(carId)}`

    })
      .then(response => response.json())
      .then(data => {
        if (data.error) {
          throw new Error(data.error);
        }
        data.forEach(rent => {
          const rentRow = document.querySelector(`[data-rent-id="${rent.RENT_ID}"]`);
          const statusCell = rentRow.querySelector('.status-cell');
          const statusText = convertStatusCodeToText(rent.STATUS);
          statusCell.textContent = statusText;
          if (rent.STATUS === "2") { //If status is rejected
            hideAllButtonsInRow(rentRow);
          } else {
            hideRowButtons(button);
          }
        });

      })
      .catch(error => {
        console.error('Error:', error);
        alert('Failed to update: ' + error.message);
      });
  }
});



function hideRowButtons(button) {
  const buttons = button.closest('.flex-row').querySelectorAll('.accept-btn, .reject-btn');
  buttons.forEach(btn => btn.style.display = "none");
}

function hideAllButtonsInRow(row) {
  const buttons = row.querySelectorAll('.accept-btn, .reject-btn');
  buttons.forEach(btn => btn.style.display = 'none');
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

