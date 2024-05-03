 <?php 
  require_once "functions/get-profile.php";
  require_once "utils/OracleDb.php";
  $db = new OracleDB();
  
    $userId = $_SESSION["user_id"];
    // if(!$userId) {
    //   header("Location: signin.php");
    //   exit();
    // }
    echo $userId;

    $profile_link = getProfilePicture($userId, $db);
    $imageSrc = !empty($profile_link) ? htmlspecialchars($profile_link) : 'assets/images/default-profile.png';
    
  ?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Drivesation</title>
   <link rel="stylesheet" href="assets/styles/user/layout.css">
 </head>

 <body>

   <header>
     <img src="assets/images/logo-bw.png" alt="Drivesation Logo">
     <nav>
       <ul>
         <li><a href="">Home</a></li>
         <li><a href="">About Us</a></li>
         <li><a href="">Lease Car</a></li>
         <li><a href="">Car List</a></li>
         <li><a href="">Reviews</a></li>
         <li><a href="functions/logout.php">Logout</a></li>
       </ul>
     </nav>

     <div class="profile-container">
       <img src="<?php echo $imageSrc; ?>" alt="Profile Picture">
     </div>
   </header>

   <main>
     MAIN
   </main>


 </body>

 </html>