document.addEventListener('DOMContentLoaded', function () {
  function showSection(sectionId, elem) {
    document.querySelectorAll('.content-section').forEach(function (section) {
      section.style.display = 'none';
    });

    document.querySelectorAll('.tab-button').forEach(function (button) {
      button.classList.remove('active');
    });

    elem.classList.add('active');

    document.getElementById(sectionId).style.display = 'block';
  }

  document.querySelector('.rentHistoryBtn').addEventListener('click', function () {
    showSection('rentHistory', this);
  });
  document.querySelector('.carListedBtn').addEventListener('click', function () {
    showSection('carListed', this);
  });

  document.querySelector('.rentHistoryBtn').click();

  //Rent History

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
    const rentId = currentButton.getAttribute('data-rent-id');
    const status = currentButton.getAttribute('data-status');
    const carId = currentButton.getAttribute('data-car-id');
    updateRentStatus(rentId, carId, status, () => {
      if (status === "8") {
        showReviewModal();
      }
    });

    popup.style.display = 'none';
  })

  confirmNo.addEventListener('click', function () {
    popup.style.display = 'none';
  });

  const updateRentStatus = (rent_id, car_id, status, callback) => {
    spinner.style.display = 'flex'; // Show spinner

    fetch('/drivesation/api/update-rent-status.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `rent_id=${encodeURIComponent(rent_id)}&new_status=${encodeURIComponent(status)}&car_id=${encodeURIComponent(car_id)}`
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
        showMessageModal(convertStatusHeaderColor(status), convertStatusHeaderResponse(status), convertStatusToResponse(status, rent_id));
        callback();
      })
      .catch(error => {
        spinner.style.display = 'none';
        console.error('Error:', error);
      });
  }

  function convertStatusHeaderColor(code) {
    const statusLookup = {
      3: `initial`,
      4: `success`,
      5: `success`,
      6: `initial`,
      8: `success`,
      9: `initial`,
      10: `error`,
      default: "Unknown"
    };
    return statusLookup[code] || statusLookup.default;
  }
  function convertStatusHeaderResponse(code) {
    const statusLookup = {
      3: `Processing`,
      4: `Sent Success`,
      5: `Received`,
      6: `Returning`,
      8: `Completed`,
      9: `Reviewing`,
      10: `Cancelled`,
      default: "Unknown"
    };
    return statusLookup[code] || statusLookup.default;
  }
  function convertStatusToResponse(code, rentId) {
    const statusLookup = {
      3: `Rent No. ${rentId} is now processing. Please coordinate with the car owner. Click 'View' for more information and contact the owner. `,
      4: `Rent No. ${rentId} car has been sent to client`,
      5: `Rent No. ${rentId} car has been received. Enjoy and ride safe!`,
      6: `Rent No. ${rentId} car is now returning, Please contact the owner for more details`,
      8: `Your transaction in Rent No. ${rentId} has been completed. Thank you for leasing!`,
      9: `We're now reviewing your transaction in Rent No. ${rentId}. Kindly email us for more concern`,
      10: `Rent No. ${rentId} has been cancelled`,
      default: "Unknown"
    };
    return statusLookup[code] || statusLookup.default;
  }

  //View Rent History
  const viewCarBtn = document.querySelectorAll('.view-btn');
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
      getRentView(carId);
    })
  })

  function getRentView(car_id) {
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
        <div class="car-image-container" >
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
        
        `

      })
      .catch(error => {
        console.error('Error:', error);
      });

  }

  //Reviews
  const reviewContainer = document.querySelector('.wrapper-background');
  const reviewBtn = document.querySelectorAll('.review-btn')
  const reviewForm = document.querySelector('.wrapper-background form');
  const cancelBtn = document.querySelector('.btn.cancel');
  const allStars = document.querySelectorAll('.rating .star');
  const ratingValue = document.querySelector('input[name="rating"]');

  reviewBtn.forEach(button => {
    button.addEventListener('click', function () {
      currentReviewBtn = this;
      showReviewModal();
    });
  })

  function showReviewModal() {
    reviewContainer.style.display = 'flex';
  }
  function hideReviewModal() {
    reviewContainer.style.display = 'none';
  }

  cancelBtn.addEventListener('click', () => {
    hideReviewModal()
  })

  reviewForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);


    const carId = currentButton.getAttribute('data-car-id');
    const userId = currentButton.getAttribute('data-user-id');

    formData.append('car_id', carId);
    formData.append('user_id', userId);
    fetch('/drivesation/api/rate-car.php', {
      method: 'POST',
      body: formData
    })
      .then(response => response.json())
      .then(data => {
        reviewContainer.style.display = 'none'; // Close the modal
      })
      .catch(error => {
        console.error('Error:', error);
      });
  });

  allStars.forEach((item, idx) => {
    item.addEventListener('click', function () {
      let click = 0
      ratingValue.value = idx + 1

      allStars.forEach(i => {
        i.classList.replace('bxs-star', 'bx-star')
        i.classList.remove('active')
      })
      for (let i = 0; i < allStars.length; i++) {
        if (i <= idx) {
          allStars[i].classList.replace('bx-star', 'bxs-star')
          allStars[i].classList.add('active')
        } else {
          allStars[i].style.setProperty('--i', click)
          click++
        }
      }
    })

  })







});





