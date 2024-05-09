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

        const profile = data[0];
        const document = data[1];
        const profileImage = document.find(data => data.DOCUMENT_TYPE === 'profile_picture');
        viewProfile.innerHTML = `
        <h1>Profile</h1>
        <img id="profile-image" width=50 height=50 src="/drivesation/${profileImage.FILE_LINK}" alt="profile-picture">
        <p>User ID: ${profile.USER_ID}</p>
        <p>${profile.FULL_NAME}</p>
        <p>${profile.ADDRESS}</p>
        <p>${profile.CONTACT_NUMBER}</p>
        <p>${profile.EMAIL_ADDRESS}</p>`

      })
      .catch(error => {
        console.error('Error:', error);
      });
  }

})