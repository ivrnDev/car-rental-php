  <?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  require_once "functions/get-profile.php";
  require_once "utils/OracleDb.php";

  $db = new OracleDB();

  $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

  if (!empty($userId)) {
    $profile_link = getProfilePicture($userId, $db);
    $imageSrc = !empty($profile_link) ? htmlspecialchars($profile_link) : 'assets/images/default-profile.png';
  }

  ?>
  <?php if (!empty($userId)) : ?>
    <header class="home-header">
      <a href="/drivesation">
        <img class="logo" src="assets/images/logo-bw.png" alt="Drivesation Logo">
      </a>

      <nav>
        <ul>
          <li><a href=" ./">Home</a></li>
          <li><a href="about-us.php">About Us</a></li>
          <li><a href="lease-car.php">Lease Car</a></li>
          <li><a href="car-list.php">Car List</a></li>
          <!-- <li><a href="reviews.php">Reviews</a></li> -->
          <li><a href="/drivesation/functions/logout-user.php">Logout</a></li>
        </ul>

      </nav>

      <div class="profile-container">
        <a href="profile.php">
          <img src="<?php echo $imageSrc; ?>" alt="Profile Picture" height="20" width="20">
        </a>
      </div>
    </header>
  <?php else : ?>
    <header class="landing-header">
      <a href="/drivesation">
        <img class="logo" src="assets/images/logo-bw.png" alt="Drivesation Logo">
      </a>

      <nav>
        <ul>
          <li><a href=" ./">Home</a></li>
          <li><a href="about-us.php">About Us</a></li>
          <li><a href="lease-car.php">Lease Car</a></li>
          <li><a href="car-list.php">Car List</a></li>
          <!-- <li><a href="reviews.php">Reviews</a></li> -->
        </ul>
      </nav>

      <div class="signing-container">
        <a href="signin.php">Log in</a>
        <a href="signup.php">Sign up</a>
      </div>
    </header>
  <?php endif ?>