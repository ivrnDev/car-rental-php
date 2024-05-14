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
        const selfieId = document.find(data => data.DOCUMENT_TYPE === 'selfie_with_id');
        const license = document.find(data => data.DOCUMENT_TYPE === 'drivers_license');
        const billing = document.find(data => data.DOCUMENT_TYPE === 'proof_of_billing');
        const validId = document.find(data => data.DOCUMENT_TYPE === 'valid_id');

        viewProfile.innerHTML = `
        <div class="profile-image-container">
        <img src="/drivesation/${profileImage.FILE_LINK}" alt="Profile picture">
      </div>
      <div class="profile-details">
        <p><strong>User ID:</strong>${profile.USER_ID}</p>
        <p><strong>Name:</strong>${profile.FULLNAME}</p>
        <p><strong>Address:</strong>${profile.ADDRESS}</p>
        <p><strong>Phone:</strong>${profile.CONTACT_NUMBER}</p>
        <p><strong>Email:</strong>${profile.EMAIL_ADDRESS}</p>
        <p><strong>Birthdate:</strong>${profile.BIRTHDATE}</p>
        <p><strong>Gender:</strong>${profile.GENDER == 0 ? 'Male' : 'Female'}</p>
      </div>
      <div class="documents-container">
        <div class="document">
          <p>Driver's License</p>
          <img src="/drivesation/${license.FILE_LINK}" alt="Driver's License">
        </div>
        <div class="document">
          <p>Proof of Billing</p>
          <img src="/drivesation/${billing.FILE_LINK}" alt="Proof of Billing">
        </div>
        <div class="document">
          <p>Valid ID</p>
          <img src="/drivesation/${validId.FILE_LINK}" alt="Valid ID">
        </div>
        <div class="document">
          <p>Selfie with ID</p>
          <img src="/drivesation/${selfieId.FILE_LINK}" alt="Selfie with ID">
        </div>
      </div>
        `

      })
      .catch(error => {
        console.error('Error:', error);
      });
  }

})