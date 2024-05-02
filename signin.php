<?php
session_start();
require_once "utils/OracleDb.php";
$db = new OracleDB();

if (!$db->isConnected()) {
    die("Database connection failed");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email_address'], $_POST['password'])) {
        $email_address = $_POST['email_address'];
        $password = $_POST['password'];
        try {
            $sql = "SELECT user_id FROM \"USER\" WHERE email_address=:email_address AND password=:password";
            $data = [
                ':email_address' => $email_address,
                ':password' => $password
            ];
            $stid = $db->executeQuery($sql, $data);
            $result = $db->fetchRow($stid);
            if ($result) {
                $_SESSION['status'] = true;
                $_SESSION['user_id'] = $result['USER_ID'];
                header("Location: index.php");
                exit;
            } else {
                echo "Invalid username or password";
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
  <link rel="stylesheet" href="assets/styles/user/sign-layout.css">
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
      <input id="email_address" name="email_address" type="text" placeholder="Email Address" autocomplete="off">
      <input id="password" name="password" type="text" placeholder="Password" autocomplete="off">
      <button type="submit">Login</button>

    </form>
  </main>
  <img src="/assets/images/login-car.png" alt="Car Image">

</body>

</html>