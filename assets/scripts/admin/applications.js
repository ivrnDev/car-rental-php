document.addEventListener('DOMContentLoaded', () => {
  const acceptBtn = document.querySelectorAll('.accept-btn')
  const rejectBtn = document.querySelectorAll('.accept-btn');
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
    updateUserStatus(userId, status);
  })

  confirmNo.addEventListener('click', function () {
    popup.style.display = 'none';
  });

  const updateUserStatus = (user_id, status) => {
    fetch('/drivesation/api/update-user-status.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `user_id=${encodeURIComponent(user_id)}&status=${encodeURIComponent(status)}`
    }).then(response => {
      if (response.ok) {
        setTimeout(() => {
          location.reload();
        }, (700));
        showMessageModal("", `Success`);
        return response.json();
      } else {
        showMessageModal(`Server Error`);
        throw new Error('Failed to update rent status.');
      }
    })
      .then(data => {
        if (data.error) {
          throw new Error(data.error);
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }








})