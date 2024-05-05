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
});




