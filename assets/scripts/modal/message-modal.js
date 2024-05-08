const modal = document.getElementById('messageModal');
const closeButton = document.querySelector('.message-close-button');

closeButton.addEventListener('click', () => {
  modal.style.display = 'none';
  location.reload();
});

function showMessageModal(type, header, message) {
  const modalHeader = modal.querySelector('.message-modal-header');
  const modalText = modal.querySelector('.message-modal-text');
  modalHeader.innerHTML = header;
  modalText.innerHTML = message;
  modalHeader.className = 'message-modal-header ' + type;
  modal.style.display = 'flex';
}

