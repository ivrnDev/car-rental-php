<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>

  HOMEPAGE

  <?php 
    session_start();
    $user = $_SESSION["user_id"];
    echo $user;
  ?>

</body>

</html>