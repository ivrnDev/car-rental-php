 <?php 
    $user = $_SESSION["user_id"];
    if(!$user) {
      header("Location: signin.php");
    }
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
       </ul>
     </nav>

     <div class="profile-container">
       <img src="assets/images/default-profile.png" alt="Default Profile">
     </div>
   </header>

   <main>
     MAIN
   </main>


 </body>

 </html>