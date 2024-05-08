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

    fetch('/drivesation/api/update-user-status.php', {
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


  //View Profile Information
  //View Car
  const viewUserBtn = document.querySelectorAll('.view-btn');
  const viewUserOverlay = document.querySelector('.view-user-overlay');
  const viewUserExit = document.querySelector('.view-user-x');
  const viewProfile = document.querySelector('.view-profile');

  viewUserExit.addEventListener('click', () => {
    viewUserOverlay.style.display = 'none';
    viewProfile.innerHTML = '';
  })

  viewUserBtn.forEach(button => {
    button.addEventListener('click', () => {
      viewUserOverlay.style.display = 'flex';
    })
  })

  viewUserBtn.forEach(button => {
    button.addEventListener('click', () => {
      const userId = button.getAttribute('data-user-id');
      getUserView(userId);
    })
  })

  function getUserView(user_id) {
    fetch('/drivesation/api/get-user-info.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `user_id=${encodeURIComponent(user_id)}`
    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {

        // viewProfile.innerHTML = `
        // <h1>Profile</h1>
        // <img id="profile-image" src="/drivesation/${profileInfo.FILE_LINK}" alt="profile-picture">
        // <p>User ID: ${profileInfo.USER_ID}</p>
        // <p>${profileInfo.FULL_NAME}</p>
        // <p>${profileInfo.ADDRESS}</p>
        // <p>${profileInfo.CONTACT_NUMBER}</p>
        // <p>${profileInfo.EMAIL_ADDRESS}</p>`

      })
      .catch(error => {
        console.error('Error:', error);
      });
  }









})