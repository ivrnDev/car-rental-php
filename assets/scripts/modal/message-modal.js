const messageModal = document.getElementById('messageModal');
const messageCloseButton = document.querySelector('.message-close-button');

function showMessageModal(header, message) {
  const modalHeader = messageModal.querySelector('.message-modal-header');
  const modalText = messageModal.querySelector('.message-modal-text');
  modalHeader.textContent = header;
  modalText.textContent = message;
  messageModal.style.display = 'block';
}

messageCloseButton.addEventListener('click', () => {
  messageModal.style.display = 'none';
  location.reload();
});