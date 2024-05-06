document.addEventListener('DOMContentLoaded', function () {
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
        return response.json();
      })
      .then(data => {
        if (response.status == 200) {
          showMessageModal("Deleted Successfully");
        } else {
          showMessageModal("Failed to delete");
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }
})