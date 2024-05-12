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
    const carId = currentButton.getAttribute('data-car-id');
    const status = currentButton.getAttribute('data-status');
    const availability = currentButton.getAttribute('data-availability-status');
    const paymentStatus = currentButton.getAttribute('data-payment');
    updateCarStatus(carId, status, availability, paymentStatus);
    popup.style.display = 'none';
  })

  confirmNo.addEventListener('click', function () {
    popup.style.display = 'none';
  });

  const updateCarStatus = (car_id, status, availability, paymentStatus) => {
    spinner.style.display = 'flex'; // Show spinner
    fetch('/drivesation/api/update-car-status.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `car_id=${encodeURIComponent(car_id)}&status=${encodeURIComponent(status)}&availability=${encodeURIComponent(availability)}&payment_status=${encodeURIComponent(paymentStatus)}`
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
        showMessageModal(data.status == 1 || data.status == 0 ? "success" : "error", `${data.header}`, `${data.body}`);

      })
      .catch(error => {
        spinner.style.display = 'none';
        showMessageModal('error', 'Error', 'Internal Server Error');
        console.error('Error:', error);
      });
  }


  //View Car
  const viewCarBtn = document.querySelectorAll('.view-btn');
  const viewCarOverlay = document.querySelector('.view-car-overlay');
  const viewCarExit = document.querySelector('.view-car-x');
  const viewCar = document.querySelector('.view-car');
  const viewProfile = document.querySelector('.view-profile');

  viewCarExit.addEventListener('click', () => {
    viewCarOverlay.style.display = 'none';
    viewCar.innerHTML = '';
  })

  viewCarBtn.forEach(button => {
    button.addEventListener('click', () => {
      viewCarOverlay.style.display = 'flex';
    })
  })

  viewCarBtn.forEach(button => {
    button.addEventListener('click', () => {
      const carId = button.getAttribute('data-car-id');
      const userId = button.getAttribute('data-owner-id');
      getCarView(carId, userId);
    })
  })

  function getCarView(car_id, ownerId) {
    fetch('/drivesation/api/get-car-view-admin.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `car_id=${encodeURIComponent(car_id)}&owner_id=${encodeURIComponent(ownerId)}`

    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        const { carData, carDocument, profileInfo } = data;
        const carImage = carDocument.find(data => data.DOCUMENT_TYPE === "car_image");
        const carORCR = carDocument.find(data => data.DOCUMENT_TYPE === "orcr");
        viewCar.innerHTML = `
        <h1>Car Details</h1>
        <p>${carData.CAR_ID}</p>
        <p>${carData.CAR_TITLE}</p>
        <p>${carData.PLATE_NUMBER}</p>
        <p>${carData.SEAT_CAPACITY}</p>
        <p>${carData.GAS_TYPE}</p>
        <p>${carData.CAR_COLOR}</p>
        <p>${carData.CAR_DESCRIPTION}</p>
        <p>${carData.CAR_MODEL}</p>
        <img src="/drivesation/${carORCR.FILE_LINK}" alt="${carData.CAR_TITLE} orcr" id="orcr-img">
        `
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