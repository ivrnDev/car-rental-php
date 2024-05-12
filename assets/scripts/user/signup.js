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
      validateInput(input)
    });
  });

  submitButton.addEventListener('click', async function (event) {
    event.preventDefault();
    spinner.style.display = 'flex';

    const formData = new FormData(form);
    const email = formData.get('email_address');

    const isUnique = await isUserUnique(email);
    spinner.style.display = 'none';
    let isValid = validateForm();

    if (isValid) {

      if (isUnique) {
        form.submit();
        showMessageModal("success", "Success", "Signup successfully. We're processing your account. Please wait for the confirmation of your account");
      } else {
        showMessageModal("error", "Failed", "User Exist. Please log in");
      }
    }
  });


  function validateInput(input) {
    const errorSpanId = input.id + '-error';
    const errorSpan = document.getElementById(errorSpanId);
    if (!input.checkValidity()) {
      input.classList.add('input-error');
      errorSpan.textContent = getCustomMessage(input);
    } else {
      input.classList.remove('input-error');
      errorSpan.textContent = '';
    }
  }


  function getCustomMessage(input) {
    if (input.validity.valueMissing) {
      return 'Please fill out this field.';
    } else if (input.validity.patternMismatch) {
      return input.id === 'contact_number' ? 'Contact number must be exactly 11 digits.' : 'Please match the requested format.';
    } else if (input.validity.tooShort) {
      return `Please enter at least ${input.getAttribute('minlength')} characters.`;
    } else if (input.validity.tooLong) {
      return `Please enter no more than ${input.getAttribute('maxlength')} characters.`;
    }
    return 'Invalid input';
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
          errorSpan.textContent = input.validationMessage || 'This field is required';
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


  async function isUserUnique(email) {
    try {
      const response = await fetch('/drivesation/api/validate-user-email.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `email_address=${encodeURIComponent(email)}`
      });
      const data = await response.json();
      if (data.error) {
        throw new Error(data.error);
      }
      return data.isUnique === 1; // Assuming the backend sends { isUnique: 1 } for unique emails
    } catch (error) {
      console.error('Failed to check if user is unique:', error);
      return false; // Consider how to handle errors, e.g., re-throw or handle differently
    }
  }

});
