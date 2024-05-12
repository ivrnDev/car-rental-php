<div class="trash-car-overlay" style="display: none;">
  <div class="trash-car-content">
    <span class="trash-car-x">x</span>
    <div class="trash-car-list">
      <h1>Trash Cars </h1>
      <div class="flex-table">
        <div class="flex-row header">
          <div class="flex-cell"></div>
          <div class="flex-cell">Car ID</div>
          <div class="flex-cell">Plate No.</div>
          <div class="flex-cell">Title</div>
          <div class="flex-cell">Amount</div>
          <div class="flex-cell"></div>

        </div>
        <div class="flex-body">
          <?php foreach ($trashCars as $car) : ?>
            <div class="flex-row">
              <div class="flex-cell"><img src="<?= $car['FILE_LINK'] ?>" alt="<?= $car['CAR_TITLE'] ?>"></div>
              <div class="flex-cell"><?= $car['CAR_ID'] ?></div>
              <div class="flex-cell"><?= $car['PLATE_NUMBER'] ?></div>
              <div class="flex-cell"><?= $car['CAR_TITLE'] ?></div>
              <div class="flex-cell"><?= "₱" . number_format($car['AMOUNT']) ?></div>
              <div class="flex-cell view-car">
                <button class="accept-btn restore-trash" data-car-id="<?= $car['CAR_ID'] ?>">Restore</button>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .trash-car-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 100;
  }

  .trash-car-content {
    position: absolute;
    top: 50%;
    left: 50%;
    height: 70%;
    width: 80%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow-y: auto;
    overflow-x: hidden;
  }

  .trash-car-x {
    position: absolute;
    top: 0px;
    right: 8px;
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
  }

  .trash-car-x:hover,
  .trash-car-x:focus {
    color: black;
    text-decoration: none;


  }
</style>