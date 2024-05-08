<?php

require_once "utils/mailer.php";

$mailer = new Mailer();
$message = "Hello, this is a custom test mail.";
$subject = "Test Mail";
$recipientEmail = "villamoraivanren@gmail.com";
$recipientName = "Ivan Ren Villamora";
$html = "<h1>SAMPLE</h1>
<p>AHAHAAHAH<p>";
$result = $mailer->sendEmail($recipientEmail, $recipientName, $subject, $html, $message);
echo $result;


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About</title>
  <link rel="stylesheet" href="assets/styles/user/layout.css">
</head>

<body>
  <?php
  require_once "assets/component/header.php";

  ?>

  About US
</body>

</html>