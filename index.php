<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION["user_id"] ?? null;

if(!empty($user)) {
  require_once("home.php");
} else {
  require_once("landing.php");
}
?>