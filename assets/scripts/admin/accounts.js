document.addEventListener('DOMContentLoaded', () => {
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

        viewProfile.innerHTML = `
        <h1>Profile</h1>
        <img id="profile-image" src="/drivesation/${profileInfo.FILE_LINK}" alt="profile-picture">
        <p>User ID: ${profileInfo.USER_ID}</p>
        <p>${profileInfo.FULL_NAME}</p>
        <p>${profileInfo.ADDRESS}</p>
        <p>${profileInfo.CONTACT_NUMBER}</p>
        <p>${profileInfo.EMAIL_ADDRESS}</p>`

      })
      .catch(error => {
        console.error('Error:', error);
      });
  }

})