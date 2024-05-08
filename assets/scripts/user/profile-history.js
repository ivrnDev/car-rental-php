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
    updateRentStatus(rentId, carId, status);
    popup.style.display = 'none';
  })

  confirmNo.addEventListener('click', function () {
    popup.style.display = 'none';
  });

  const updateRentStatus = (rent_id, car_id, status) => {
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
        showMessageModal(status == 6 ? "error" : "success", status == 6 ? "Cancelled" : "Processing", status == 6 ? "Your rent has been cancelled" : "Your rent is now processing. Please contact the owner below.");
      })
      .catch(error => {
        spinner.style.display = 'none';
        console.error('Error:', error);
      });
  }













});





