  <?php 
  require_once "functions/get-profile.php";
  require_once "utils/OracleDb.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
  $db = new OracleDB();
  
    $userId = $_SESSION["user_id"];

    $profile_link = getProfilePicture($userId, $db);
    $imageSrc = !empty($profile_link) ? htmlspecialchars($profile_link) : 'assets/images/default-profile.png';
    
  ?>
  <header>
    <a href="/drivesation" class="logo">
      <img src="assets/images/logo-bw.png" alt="Drivesation Logo">
    </a>

    <nav>
      <ul>
        <li><a href=" ./">Home</a></li>
        <li><a href="about-us.php">About Us</a></li>
        <li><a href="lease-car.php">Lease Car</a></li>
        <li><a href="car-list.php">Car List</a></li>
        <li><a href="reviews.php">Reviews</a></li>
        <li><a href="functions/logout.php">Logout</a></li>
      </ul>
    </nav>

    <div class="profile-container">
      <a href="profile.php">
        <img src="<?php echo $imageSrc; ?>" alt="Profile Picture">
      </a>

    </div>
    <img src="assets/images/three-bars.svg" alt="bar-logo">
  </header>