//Update rent status
document.addEventListener('DOMContentLoaded', () => {
  const spinner = document.getElementById('loadingSpinner');
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
  function updateRentStatus(rentId, carId, newStatus) {
    spinner.style.display = 'flex'; // Show spinner
    fetch('api/update-rent-status.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `rent_id=${encodeURIComponent(rentId)}&new_status=${encodeURIComponent(newStatus)}&car_id=${encodeURIComponent(carId)}`

    })
      .then(response => {
        spinner.style.display = 'none';
        if (response.ok) {
          showMessageModal(convertStatusHeaderColor(newStatus), convertStatusHeaderResponse(newStatus), convertStatusToResponse(newStatus, rentId));
          return response.json();
        } else {
          showMessageModal('error', 'Error', `Server Error`);
          throw new Error('Failed to update rent status.');
        }
      })
      .then(data => {
        if (data.error) {
          throw new Error(data.error);
        }
      })
      .catch(error => {
        spinner.style.display = 'none';
        console.error('Error:', error);
      });
  }

  function convertStatusHeaderColor(code) {
    const statusLookup = {
      1: `success`,
      2: `error`,
      4: `success`,
      5: `success`,
      7: `initial`,
      8: `success`,
      9: `initial`,
      10: `error`,
      default: "Unknown"
    };
    return statusLookup[code] || statusLookup.default;
  }
  function convertStatusHeaderResponse(code) {
    const statusLookup = {
      1: `Approved`,
      2: `Rejected`,
      4: `Sent Success`,
      5: `Completed`,
      7: `Returned`,
      8: `Completed`,
      9: `Reviewing`,
      10: `Cancelled`,
      default: "Unknown"
    };
    return statusLookup[code] || statusLookup.default;
  }
  function convertStatusToResponse(code, rentId) {
    const statusLookup = {
      1: `Rent No. ${rentId} has been approved`,
      2: `Rent No. ${rentId} has been rejected`,
      4: `Rent No. ${rentId} car has been sent to client`,
      5: `Rent No. ${rentId} is now completed`,
      7: `Rent No. ${rentId} car has been returned`,
      8: `Rent No. ${rentId} is now completed`,
      9: `We're now reviewing your transaction in Rent No. ${rentId}. Kindly email us for more concern`,
      10: `Rent No. ${rentId} has been cancelled`,
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
    <div class="profile-card">
    <img src=${profilePictureDocument.FILE_LINK} class="profile-img">
    <div class="profile-info">
      <h1 class="name">${profileResult.FULL_NAME}</h1>
      <p class="id">ID: ${profileResult.USER_ID}</p>
      <p class="address">Address: ${profileResult.ADDRESS}</p>
      <p class="phone">Phone: ${profileResult.CONTACT_NUMBER}</p>
      <p class="email">Email: ${profileResult.EMAIL_ADDRESS}</p>
    </div>
  </div>`

        carView.innerHTML = `
       <div class="car-card">
    <img src="${carResult.FILE_LINK}" class="car-img">
    <div class="car-info">
      <h1 class="title">${carResult.CAR_TITLE}</h1>
      <p class="car-type">Type: ${carResult.CAR_TYPE} </p>
      <p class="car-model">Model: ${carResult.CAR_MODEL}</p>
      <p class="gas">Fuel Type: ${carResult.CAR_TYPE}</p>
      <p class="seat-cap"> Seat Capacity: ${carResult.SEAT_CAPACITY} Seaters</p>
      <p class="plate">Plate Number: ${carResult.PLATE_NUMBER}</p>
    </div>
  </div>
      `
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }
});





