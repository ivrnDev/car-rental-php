document.addEventListener('DOMContentLoaded', () => {
  const spinner = document.getElementById('loadingSpinner');
  const popup = document.getElementById('confirmationPopup');
  const confirmYes = document.getElementById('confirmYes');
  const confirmNo = document.getElementById('confirmNo')
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

  confirmYes.addEventListener('click', () => {
    const userId = currentButton.getAttribute('data-user-id');
    const status = currentButton.getAttribute('data-status');
    updateRentStatus(userId, status);
    popup.style.display = 'none';
  })

  confirmNo.addEventListener('click', function () {
    popup.style.display = 'none';
  });

  const updateRentStatus = (user_id, status) => {
    spinner.style.display = 'flex'; // Show spinner

    fetch('/drivesation/api/update-rent-status.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `user_id=${encodeURIComponent(user_id)}&status=${encodeURIComponent(status)}`
    }).then(response => {
      spinner.style.display = 'none';
      if (response.ok) {
        return response.json();
      } else {
        showMessageModal('error', 'Error', 'Internal Server Error');
        throw new Error('Failed to update rent status.');
      }
    })
      .then(data => {
        if (data.error) {
          throw new Error(data.error);
        }
        showMessageModal(data.status == 1 ? "success" : "error", `${data.header}`, `${data.body}`);

      })
      .catch(error => {
        spinner.style.display = 'none';
        console.error('Error:', error);
      });
  }








})