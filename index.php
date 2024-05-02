<?php 
session_start();
$logged = $_SESSION["status"] ?? false;

if($logged) {
  require_once("home.php");
} else {
  require_once("home.php");
}
?>