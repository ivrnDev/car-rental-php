async function updateCarAvailability(car_id, newStatus) {
  try {
    const response = await fetch('api/update-car-availability.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: 'car_id=' + encodeURIComponent(car_id) + '&new_status=' + encodeURIComponent(newStatus)
    });

    const data = await response.json();

    if (data.error) {
      throw new Error(data.error);
    }

    return data;

  } catch (error) {
    console.error('Error:', error);
  }
}
