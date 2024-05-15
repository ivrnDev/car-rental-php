document.addEventListener('DOMContentLoaded', function () {
  const spinner = document.getElementById('loadingSpinner');

  const deleteBtn = document.querySelectorAll('.delete-car .reject-btn');
  const confirmDeleteModal = document.getElementById('confirmDeletePopUp');
  const confirmDeleteYes = document.getElementById('confirmDeleteYes');
  const confirmDeleteNo = document.getElementById('confirmDeleteNo');
  let currentDeleteButton;

  deleteBtn.forEach(button => {
    button.addEventListener('click', () => {
      currentDeleteButton = button;
      confirmDeleteModal.style.display = 'flex';
    })
  })

  confirmDeleteYes.addEventListener('click', function () {
    const deleteStatus = currentDeleteButton.getAttribute('data-delete-status');
    const car_id = currentDeleteButton.getAttribute('data-car-id');
    confirmDeleteModal.style.display = 'none';
    updateCarDeleteStatus(car_id, deleteStatus);
  })

  confirmDeleteNo.addEventListener('click', function () {
    confirmDeleteModal.style.display = 'none';
  });

  function updateCarDeleteStatus(car_id, delete_status) {
    spinner.style.display = 'flex';
    fetch('api/update-car-delete.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `car_id=${encodeURIComponent(car_id)}&delete_status=${encodeURIComponent(delete_status)}`

    })
      .then(response => {
        spinner.style.display = 'none';
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        showMessageModal('error', "Deleted", "Car has been deleted successfully");
        return response.json();
      })
      .then(data => {
      })
      .catch(error => {
        spinner.style.display = 'none';
        console.error('Error:', error);
      });
  }


  //View Car Information
  const viewCarBtn = document.querySelectorAll('.view-car .view-btn');
  const viewCarOverlay = document.querySelector('.view-car-overlay');
  const viewCarExit = document.querySelector('.view-car-x');
  const viewCar = document.querySelector('.view-car');

  viewCarExit.addEventListener('click', () => {
    viewCarOverlay.style.display = 'none';
  })

  viewCarBtn.forEach(button => {
    button.addEventListener('click', () => {
      viewCarOverlay.style.display = 'flex';
    })
  })

  viewCarBtn.forEach(button => {
    button.addEventListener('click', () => {
      const carId = button.getAttribute('data-car-id');
      getCarView(carId);
    })
  })

  function getCarView(car_id) {
    fetch('api/get-car-view.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `car_id=${encodeURIComponent(car_id)}`

    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        const { carData, carDocument } = data;
        const carImage = carDocument.find(data => data.DOCUMENT_TYPE === "car_image");
        const carORCR = carDocument.find(data => data.DOCUMENT_TYPE === "orcr");
        const payment = carDocument.find(data => data.DOCUMENT_TYPE === "payment_proof");
        let paymentProofHtml = payment && payment.FILE_LINK ? `
      <div class="document">
        <p>Payment Proof</p>
        <img src="/drivesation/${payment.FILE_LINK}" alt="Payment Proof">
      </div>` : '';

        viewCar.innerHTML = `
       <div class="car-image-container">
        <img src="/drivesation/${carImage.FILE_LINK}" alt="car picture">
      </div>
      <div class="car-details">
        <p><strong>Car ID:</strong>${carData.CAR_ID}</p>
        <p><strong>Title:</strong>${carData.CAR_TITLE}</p>
        <p><strong>Car Model:</strong>${carData.CAR_MODEL}</p>
        <p><strong>Car Color:</strong>${carData.CAR_COLOR}</p>
        <p><strong>Plate Number:</strong>${carData.PLATE_NUMBER}</p>
        <p><strong>Seat Capacity:</strong>${carData.SEAT_CAPACITY}</p>
        <p><strong>Gas Type:</strong>${carData.GAS_TYPE}</p>
        <p><strong>Car Type:</strong>${carData.CAR_TYPE}</p>
        <p><strong>Description:</strong>${carData.CAR_DESCRIPTION}</p>
      </div>
      <div class="documents-container">
        <div class="document">
          <p>ORCR</p>
          <img src="/drivesation/${carORCR.FILE_LINK}" alt="Driver's License">
        </div>
      ${paymentProofHtml}
      </div>`

      })
      .catch(error => {
        console.error('Error:', error);
      });

  }

  const trashBtn = document.getElementById('trash-btn');
  const trashOverlay = document.querySelector('.trash-car-overlay');
  const trashExit = document.querySelector('.trash-car-x');
  const restoreBtn = document.querySelectorAll('.restore-trash');
  let currentRestoreButton
  trashExit.addEventListener('click', () => {
    trashOverlay.style.display = 'none';
  })

  trashBtn.addEventListener('click', () => {
    trashOverlay.style.display = 'flex';
  })

  restoreBtn.forEach(button => {
    button.addEventListener('click', () => {
      currentRestoreButton = button
      confirmDeleteModal.style.display = 'flex';
    })
  })

  confirmDeleteYes.addEventListener('click', function () {
    const car_id = currentRestoreButton.getAttribute('data-car-id');
    confirmDeleteModal.style.display = 'none';
    restoreCar(car_id);
  })

  confirmDeleteNo.addEventListener('click', function () {
    confirmDeleteModal.style.display = 'none';
  });


  function restoreCar(car_id) {
    spinner.style.display = 'flex';
    fetch('api/update-car-delete.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `car_id=${encodeURIComponent(car_id)}&delete_status=0`

    })
      .then(response => {
        spinner.style.display = 'none';

        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        showMessageModal('error', "Restored", "Car has been restored successfully");
        return response.json();
      })
      .then(data => {
      })
      .catch(error => {
        spinner.style.display = 'none';
        console.error('Error:', error);
      });

  }

})