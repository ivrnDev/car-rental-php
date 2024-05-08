//Update rent status
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

    updateRentStatus(rentId, carId, statusCode);
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

  //Send to server
  function updateRentStatus(carId, newStatus) {
    fetch('api/update-rent-status.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `rent_id=${encodeURIComponent(rentId)}&new_status=${encodeURIComponent(newStatus)}&car_id=${encodeURIComponent(carId)}`

    })
      .then(response => {
        if (response.ok) {
          setTimeout(() => {
            location.reload();
          }, (700));
          showMessageModal("Success", `${convertStatusToResponse(newStatus, rentId)}`);
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
        alert('Failed to update: ' + error.message);
      });
  }


  function convertStatusToResponse(code, rentId) {
    const statusLookup = {
      1: `Rent #${rentId} has been approved`,
      2: `Rent #${rentId} has been rejected`,
      3: `Rent #${rentId} is now processing`,
      4: `Rent #${rentId} is now on going`,
      5: `Rent ${rentId} is now completed`,
      6: `Rent #{rentId} has been cancelled`,
      default: "Unknown"
    };
    return statusLookup[code] || statusLookup.default;
  }


  //Update Car Availability on server
  async function updateCarAvailability(car_id, newStatus) {
    try {
      const response = await fetch('api/update-car-availability.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'car_id=' + encodeURIComponent(car_id) + '&new_status=' + encodeURIComponent(newStatus)
      });

      const data = await response.json();

      if (data.error) {
        throw new Error(data.error);
      }

      return data;

    } catch (error) {
      console.error('Error:', error);
    }
  }


  //View Rent Information

  const viewBtn = document.querySelectorAll('.view-rent .view-btn');
  const viewExit = document.querySelector('.x');
  const viewRentOverlay = document.querySelector('.view-rent-overlay');
  const profileView = document.querySelector('.profile-view');
  const carView = document.querySelector('.car-view');
  viewExit.addEventListener('click', () => {
    viewRentOverlay.style.display = 'none';
    profileView.innerHTML = '';
  })

  viewBtn.forEach(button => {
    button.addEventListener('click', () => {
      viewRentOverlay.style.display = 'flex';
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
});





