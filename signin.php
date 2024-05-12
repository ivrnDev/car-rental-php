<?php
session_start();
require_once "utils/OracleDb.php";
$db = new OracleDB();

if (!$db->isConnected()) {
  die("Database connection failed");
}

$result = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['email_address'], $_POST['password'])) {
    $email_address = $_POST['email_address'];
    $password = $_POST['password'];
    try {
      $sql = "SELECT user_id, user_role FROM \"USER\" WHERE email_address=:email_address AND password=:password AND status = 1";
      $data = [
        ':email_address' => $email_address,
        ':password' => $password
      ];
      $stid = $db->executeQuery($sql, $data);
      $result = $db->fetchRow($stid);
      if ($result) {
        if ($result['USER_ROLE'] == 1) {
          $_SESSION['admin_id'] = $result['USER_ID'];
          header("Location: /drivesation/admin/dashboard.php");
          exit;
        }
        $_SESSION['user_id'] = $result['USER_ID'];
        header("Location: /drivesation");
        exit;
      } else {
        $result = "Invalid username or password";
      }
    } catch (Exception $e) {
      echo "<p>Error: " . $e->getMessage() . "</p>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log In</title>
  <link rel="stylesheet" href="assets/styles/user/sign-layout.cs">
  <link rel="stylesheet" href="assets/styles/user/signin.css">
</head>

<body>
  <header>
    <a href="/drivesation">
      <img id="logo" src="assets/images/logo.png" alt="Drivesation Logo">
    </a>
  </header>

  <main>
    <form method="POST">
      <div class="login-section1">
        <div class="login-section">
          <div class="login-container1">
            <div class="vertical-flex-container">
              <p class="login">LOGIN</p>
              <div class="vertical-button-container">
                <div class="vertical-flex-container">
                  <div class="content-wrapper">
                    <input type="text" placeholder="Email" class="input-box" name="email_address" autocomplete="off">
                  </div>
                  <div class="vertical-spacing-container">
                    <input type="password" placeholder="Password" class="input-box" name="password">
                    <button class="login-button">Login</button>
                    <?php if ($result) : ?>
                      <p style="color: red; margin-top: 20px"><?= $result ?></p>
                      <p></p>
                    <?php endif ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="account-prompt-section">
              <div class="account-signup-prompt">
                <p class="dont">Don't have an account yet?</p>
                <p class="signup-prompt-text-style"><a href="signup.php" class="signup-link">Sign up</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
    <div class="featured-content-section">
      <div class="text-container">
        <p class="gradient-text-heading">BOOK ANYTIME,<br />ANYWHERE.</p>
      </div>
      <div class="negative-margin-top">
        <img src="assets/images/car_in_log_in.png" class="car-log-in" />
      </div>
    </div>
    </div>
    </div>




</body>

</html>