document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById('updateCarForm');
  const submitButton = document.getElementById('updateCarBtn');
  const inputFields = form.querySelectorAll('input:not([type="file"])');
  const fileInputFields = form.querySelectorAll('input[type="file"]');
  const spinner = document.getElementById('loadingSpinner');
  const createCarPopup = document.getElementById('createCarPopup');
  const createCarYes = document.getElementById('createCarYes');
  const createCarNo = document.getElementById('createCarNo');

  // Check file inputs and update labels
  fileInputFields.forEach(input => {
    input.addEventListener('change', function () {
      const labelSpan = document.getElementById(input.id + '_name');
      labelSpan.textContent = input.files.length > 0 ? input.files[0].name : 'No file chosen';
      if (input.files.length > 0) {
        const inputLabel = document.getElementById(input.id + '_label')
        const labelSpan = document.getElementById(input.id + '_name')
        labelSpan.style.color = 'initial';
        inputLabel.classList.remove('input-error');
      }
    })
  });

  inputFields.forEach(input => {
    input.addEventListener('input', function () {
      clearError(input);
    });
  });

  submitButton.addEventListener('click', function (e) {
    e.preventDefault();
    if (validateForm()) {
      createCarPopup.style.display = 'flex'
    }
  });

  createCarYes.addEventListener('click', function (e) {
    e.preventDefault();
    updateCar(e)
    createCarPopup.style.display = 'none';
  });

  createCarNo.addEventListener('click', function () {
    createCarPopup.style.display = 'none';
  });

  function updateCar() {
    const carId = new URLSearchParams(window.location.search).get('car_id');
    const formData = new FormData(form);
    formData.append('car_id', carId);
    spinner.style.display = 'flex';
    fetch('/drivesation/api/update-car.php', {
      method: 'POST',
      body: formData
    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json()
  })
      .then(data => {
    spinner.style.display = 'none';
    if (data.error) {
      throw new Error(data.error);
    }
    showMessageModal('success', 'Success', 'Updated successfully');
  })
    .catch(error => {
      spinner.style.display = 'none';
      console.error('Error:', error);
      showMessageModal('error', 'Error', 'An error occurred');
    });
}
  function validateForm() {
    let hasError = false;
    const inputFields = form.querySelectorAll('input:not([type="file"])');

    // Clear existing errors
    document.querySelectorAll('.error-message').forEach(function (element) {
      element.textContent = '';
    });

    // Validate each input field
    inputFields.forEach(input => {
      if (!input.value.trim()) { // Check if the field is empty
        const errorSpanId = input.id + '-error';
        const errorSpan = document.getElementById(errorSpanId);
        if (errorSpan) {
          input.classList.add('input-error');
          errorSpan.textContent = 'This field is required';
          hasError = true;
        }
      }
    });

    // fileInputFields.forEach(input => {
    //   if (input.files.length === 0) { // Check if no file is selected
    //     const inputLabel = document.getElementById(input.id + '_label');
    //     const labelSpan = document.getElementById(input.id + '_name');
    //     labelSpan.textContent = 'File is required';
    //     labelSpan.style.color = "red"
    //     inputLabel.classList.add('input-error');  // Add error style
    //     hasError = true;
    //   }
    // });
    return !hasError
  }

  function clearError(input) {
    const errorSpanId = input.id + '-error';
    const errorSpan = document.getElementById(errorSpanId);
    if (errorSpan) {
      errorSpan.textContent = '';
      input.classList.remove('input-error');
    }
  }

  //View Payment
  const viewPaymentBtn = document.getElementById('view-payment-method');
const viewPaymentExit = document.querySelector('.view-payment-x');
const viewPaymentOverlay = document.querySelector('.view-payment-overlay');

viewPaymentExit.addEventListener('click', () => {
  viewPaymentOverlay.style.display = 'none';
})

viewPaymentBtn.addEventListener('click', () => {
  viewPaymentOverlay.style.display = 'flex';
})



//Free Trial User
const displayProcessingFee = document.getElementById('processing-fee');

//Update Processing Fee
const amountInput = document.getElementById('amount');

amountInput.addEventListener('input', () => {
  const amountValue = parseFloat(amountInput.value);
  const processingFee = isNaN(amountValue) || amountValue === 0 ? 0 : amountValue * 0.05;
  displayProcessingFee.innerHTML = `₱ ${processingFee.toLocaleString("en-US", {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  })}`;
})
})