document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById('createCarForm');
  const submitButton = document.getElementById('createCarBtn');
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
    let isValid = validateForm();
    console.log(isValid)
    if (isValid) {
      form.submit();
    }
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



});
