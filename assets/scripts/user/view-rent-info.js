const viewBtn = document.querySelectorAll('.view-btn');
const exit = document.querySelector('.x');
const overlay = document.querySelector('.view-rent-overlay');
const profileView = document.querySelector('.profile-view');
const carView = document.querySelector('.car-view');
exit.addEventListener('click', () => {
  overlay.style.display = 'none';
  profileView.innerHTML = '';
})

viewBtn.forEach(button => {
  button.addEventListener('click', () => {
    overlay.style.display = 'flex';
  })
})

viewBtn.forEach(button => {
  button.addEventListener('click', () => {
    const userId = button.getAttribute('data-user-id');
    const carId = button.getAttribute('data-car-id');
    const rentId = button.getAttribute('data-rent-id');
    getRentView(carId, userId, rentId);

  })
})







function getRentView(carId, userId, rentId) {
  fetch('api/get-rent-view.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `carId=${encodeURIComponent(carId)}&userId=${encodeURIComponent(userId)}&rentId=${encodeURIComponent(rentId)}`

  })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(data => {
      const { profileResult, profileDocumentResult, carResult } = data;
      const profilePictureDocument = profileDocumentResult.find(doc => doc.DOCUMENT_TYPE === 'profile_picture');

      profileView.innerHTML = `
     <h1>Profile</h1>
      <img id="profile-image" src="${profilePictureDocument.FILE_LINK}" alt="profile-picture">
      <p>User ID: ${profileResult.USER_ID}</p>
      <p>${profileResult.FULL_NAME}</p>
      <p>${profileResult.ADDRESS}</p>
      <p>${profileResult.CONTACT_NUMBER}</p>
      <p>${profileResult.EMAIL_ADDRESS}</p>`

      carView.innerHTML = `
      <h1>Profile</h1>
      <img id="profile-image" src="${carResult.FILE_LINK}" alt="profile-picture">
      <p>User ID: ${carResult.USER_ID}</p>
      <p>Car ID: ${carResult.CAR_ID}</p>
      <p>${carResult.CAR_TITLE}</p>
      <p>${carResult.CAR_MODEL}</p>
      <p>${carResult.CAR_BRAND}</p>
      <p>${carResult.CAR_TYPE}</p>
      <p>₱ ${parseInt(carResult.AMOUNT).toLocaleString()}</p>
      `
    })
    .catch(error => {
      console.error('Error:', error);
    });

}


