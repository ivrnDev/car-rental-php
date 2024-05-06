document.addEventListener('DOMContentLoaded', function () {

  //Delete Button
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
    fetch('api/update-car-delete.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `car_id=${encodeURIComponent(car_id)}&delete_status=${encodeURIComponent(delete_status)}`

    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        showMessageModal("Deleted", "Car has been deleted successfully");
        return response.json();
      })
      .then(data => {
      })
      .catch(error => {
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
        viewCar.innerHTML = `
        <h1>Car Details</h1>
        <img src="${carImage.FILE_LINK}" alt="${carData.CAR_TITLE} car-image">
        <p>${carData.CAR_ID}</p>
        <p>${carData.CAR_TITLE}</p>
        <p>${carData.PLATE_NUMBER}</p>
        <p>${carData.SEAT_CAPACITY}</p>
        <p>${carData.GAS_TYPE}</p>
        <p>${carData.CAR_COLOR}</p>
        <p>${carData.CAR_DESCRIPTION}</p>
        <p>${carData.CAR_ID}</p>
        <p>${carData.CAR_ID}</p>
        <p>${carData.CAR_ID}</p>
        <img src="${carORCR.FILE_LINK}" alt="${carData.CAR_TITLE} orcr" id="orcr-img">
        `
      })
      .catch(error => {
        console.error('Error:', error);
      });

  }




})