// document.getElementById('createCarBtn').addEventListener('click', function () {
//   const form = document.getElementById('createCarForm');
//   const formData = new FormData(form);

//   fetch('process_form.php', {
//     method: 'POST',
//     body: formData
//   })
//     .then(response => response.text())
//     .then(data => {
//       document.getElementById('responseArea').innerHTML = data;
//     })
//     .catch(error => {
//       console.error('Error:', error);
//     });
// });