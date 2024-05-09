document.addEventListener("DOMContentLoaded", function () {
  const spinner = document.getElementById('loadingSpinner');
  const form = document.getElementById('signup-form');
  const submitButton = document.getElementById('signup-btn');
  const inputFields = form.querySelectorAll('input:not([type="file"])');
  const fileInputFields = form.querySelectorAll('input[type="file"]');

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
    });
  });

  inputFields.forEach(input => {
    input.addEventListener('input', function () {
      clearError(input);
    });
  });

  submitButton.addEventListener('click', function (event) {
    event.preventDefault();
    spinner.style.display = 'flex';

    let isValid = validateForm();

    if (isValid) {
      form.submit();
      spinner.style.display = 'none';
      showMessageModal("success", "Success", "Signup successfully. We're processing your account. Please wait for the confirmation of your account")
    }
    spinner.style.display = 'none';

  });
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

    fileInputFields.forEach(input => {
      if (input.files.length === 0) { // Check if no file is selected
        const inputLabel = document.getElementById(input.id + '_label');
        const labelSpan = document.getElementById(input.id + '_name');
        labelSpan.textContent = 'File is required';
        labelSpan.style.color = "red"
        inputLabel.classList.add('input-error');  // Add error style
        hasError = true;
      }
    });

    // Password matching validation
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    if (password !== confirmPassword) {
      document.getElementById('confirm-password-error').textContent = 'Passwords do not match';
      hasError = true;
    }
    return !hasError; // Return true if there is no error
  }
  function clearError(input) {
    const errorSpanId = input.id + '-error';
    const errorSpan = document.getElementById(errorSpanId);
    if (errorSpan) {
      errorSpan.textContent = '';
      input.classList.remove('input-error');
    }
  }

  const birthdateInput = document.getElementById('birthdate');
  const today = new Date();
  const maxDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
  const minDate = new Date(today.getFullYear() - 100, today.getMonth(), today.getDate());

  const formatDate = function (date) {
    let d = new Date(date),
      month = '' + (d.getMonth() + 1),
      day = '' + d.getDate(),
      year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
  };

  birthdateInput.max = formatDate(maxDate);
  birthdateInput.min = formatDate(minDate);
});
