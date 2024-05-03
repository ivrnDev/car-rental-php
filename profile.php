 <?php 
  require_once "functions/get-profile.php";
  require_once "utils/OracleDb.php";
  session_start();
    $db = new OracleDB();
    $userId = $_SESSION["user_id"];
    $profile_link = getProfilePicture($userId, $db);
    $imageSrc = !empty($profile_link) ? htmlspecialchars($profile_link) : 'assets/images/default-profile.png';

    $profile_info = getProfileInfo($userId, $db);
  ?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profile</title>
   <link rel="stylesheet" href="assets/styles/user/layout.css">
   <link rel="stylesheet" href="assets/styles/user/profile.css">
 </head>

 <body>
   <?php require_once "assets/component/header.php";?>



   <main>
     <div class="left-column">
       <img src="<?php echo $imageSrc?>" alt="">
       <?php 
        if (!empty($profile_info)) {
        echo '<ul>';
        foreach ($profile_info as $key => $value) {
        echo '<li>' . htmlspecialchars($value) . '</li>';
        }
        echo '</ul>';
      } else {
        echo '<p>No profile information available.</p>';
      }
       ?>
     </div>
     <div class="right-column">

     </div>
   </main>


 </body>

 </html>