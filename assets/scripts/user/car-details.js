document.addEventListener('DOMContentLoaded', function () {
  //Rent Submission
  const spinner = document.getElementById('loadingSpinner');
  const popup = document.getElementById('confirmationPopup');
  const confirmYes = document.getElementById('confirmYes');
  const confirmNo = document.getElementById('confirmNo')
  const rentCarBtn = document.getElementById('rentCarBtn')
  const form = document.getElementById('rent-car');
  const inputFields = form.querySelectorAll('input');


  rentCarBtn.addEventListener('click', function (event) {
    event.preventDefault();
    popup.style.display = 'flex';
  });

  inputFields.forEach(input => {
    input.addEventListener('input', function () {
      clearError(input); // Clear error on input container
    });
  });

  confirmYes.addEventListener('click', (event) => {
    popup.style.display = 'none';
    event.preventDefault();
    let isValid = validateForm();

    if (isValid) {
      const formData = new FormData(form);
      formData.append('owner_id', rentCarBtn.getAttribute('data-owner-id'));
      formData.append('user_id', rentCarBtn.getAttribute('data-user-id'));
      formData.append('car_id', rentCarBtn.getAttribute('data-car-id'));
      formData.append('pick_up_time', document.getElementById('pick_up_time').value);
      formData.append('rent_date_from', document.getElementById('rent_date_from').value);
      formData.append('rent_date_to', document.getElementById('rent_date_to').value);
      console.log(formData)
      submitForm(formData);
    }

  });

  confirmNo.addEventListener('click', function () {
    popup.style.display = 'none';
  });

  const submitForm = (formData) => {
    spinner.style.display = 'flex'; // Show spinner

    fetch('/drivesation/api/rent-car.php', {
      method: 'POST',
      body: formData
    }).then(response => {
      spinner.style.display = 'none';
      if (!response.ok) throw new Error('Network response was not ok.');
      return response.json();
    }).then(data => {
      popup.style.display = 'none';
      showMessageModal("success", "Order Placed", `Your order has been placed. Please Wait for the confirmation of the owner`, ``);
    }).catch(error => {
      console.error('Error:', error);
      showMessageModal("error", "Error", "Failed to process your request.");
    });
  }

  function validateForm() {
    let hasError = false;
    const inputFields = form.querySelectorAll('input');

    // Clear existing errors
    document.querySelectorAll('.error-message').forEach(function (element) {
      element.textContent = '';
    });

    inputFields.forEach(input => {
      const container = input.parentElement;
      if (!input.value.trim()) {
        const errorSpanId = input.id + '-error';
        const errorSpan = document.getElementById(errorSpanId);
        if (errorSpan) {
          container.style.border = '1px solid red'; // Apply red border to container
          errorSpan.textContent = 'Required Field';
          hasError = true;
        }
      }
    });
    // Validate each input field
    return !hasError;
  }
  function clearError(input) {
    input.parentElement.style.border = 'none'; // Remove border from container
    const errorSpan = document.getElementById(input.id + '-error');

    if (errorSpan) {
      errorSpan.textContent = '';
    }
  }

  //Validate Time and Date
  const rentFromDateInput = document.getElementById('rent_date_from');
  const rentToDateInput = document.getElementById('rent_date_to');

  const today = new Date().toISOString().split('T')[0];
  rentFromDateInput.min = today;
  rentToDateInput.min = today;

  rentFromDateInput.addEventListener('change', function () {
    const fromDate = new Date(rentFromDateInput.value);
    fromDate.setDate(fromDate.getDate() + 1);
    const nextDay = fromDate.toISOString().split('T')[0];

    rentToDateInput.min = nextDay;

    if (rentToDateInput.value && rentToDateInput.value < rentToDateInput.min) {
      rentToDateInput.value = nextDay;
    }
  });

  rentToDateInput.addEventListener('change', function () {
    const toDate = new Date(rentToDateInput.value);
    toDate.setDate(toDate.getDate() - 1);
    const previousDay = toDate.toISOString().split('T')[0];

    rentFromDateInput.max = previousDay;

    if (rentFromDateInput.value && rentFromDateInput.value > rentFromDateInput.max) {
      rentFromDateInput.value = previousDay;
    }
  });
})