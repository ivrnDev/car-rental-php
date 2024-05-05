document.addEventListener('DOMContentLoaded', () => {
  const acceptButtons = document.querySelectorAll('.acceptBtn');
  acceptButtons.forEach(button => {
    button.addEventListener('click', function () {
      const rentId = this.getAttribute('data-rent-id');
      fetch('functions/update-rent-status.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'rent_id=' + encodeURIComponent(rentId) + '&new_status=1'
      })
        .then(response => response.json())
        .then(data => {
          if (data.error) {
            throw new Error(data.error);
          }

          const statusText = convertStatusCodeToText(data.STATUS);
          const statusCell = this.closest('.flex-row').querySelector('.status-cell');
          statusCell.textContent = statusText;
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Failed to update: ' + error.message);
        });
    });
  });
});
const rejectButtons = document.querySelectorAll('.rejectBtn');
rejectButtons.forEach(button => {
  button.addEventListener('click', function () {
    const rentId = this.getAttribute('data-rent-id');
    fetch('functions/update-rent-status.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: 'rent_id=' + encodeURIComponent(rentId) + '&new_status=2'
    })
      .then(response => response.json())
      .then(data => {
        if (data.error) {
          throw new Error(data.error);
        }

        const statusText = convertStatusCodeToText(data.STATUS);
        const statusCell = this.closest('.flex-row').querySelector('.status-cell');
        statusCell.textContent = statusText;
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Failed to update: ' + error.message);
      });
  });
});


function convertStatusCodeToText(code) {
  const statusLookup = {
    0: " Pending",
    1: "Approved",
    2: "Rejected",
    3: "Processing",
    4: "On Going",
    5: "Completed",
    default: "Unknown"
  };
  return statusLookup[code] || statusLookup.default;
}