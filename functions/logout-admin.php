<?php
session_start();

// Assuming you store user-related session data like this
unset($_SESSION['admin_id']);  // Unset only the user ID

// Optionally, check if there are no other needed session variables and destroy the whole session
if (empty($_SESSION['user_id'])) {  // Assuming 'admin_id' is how you store admin session
  session_destroy();  // Destroy the session if no admin is logged in
}

header("Location: ../signin.php");
exit();
