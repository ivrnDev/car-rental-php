 <?php
  require_once "utils/OracleDb.php";
  require_once "utils/upload.php";
  require_once "assets/component/modals/message-modal.php";
  require_once "assets/component/loading.php";
  $db = new OracleDB();
  if (!$db->isConnected()) {
    die("Database connection failed");
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset(
      $_POST['firstname'],
      $_POST['lastname'],
      $_POST['middlename'],
      $_POST['email_address'],
      $_POST['address'],
      $_POST['contact_number'],
      $_POST['birthdate'],
      $_POST['gender'],
      $_POST['password'],
      $_FILES['profile_picture'],
      $_FILES['valid_id'],
      $_FILES['drivers_license'],
      $_FILES['proof_of_billing'],
      $_FILES['selfie_with_id']
    )) {
      try {
        $first_name = $_POST['firstname'];
        $last_name = $_POST['lastname'];
        $middle_name = $_POST['middlename'];
        $email_address = $_POST['email_address'];
        $address = $_POST['address'];
        $contact_number = $_POST['contact_number'];
        $birthdate = $_POST['birthdate'];
        $gender = $_POST['gender'];
        $password = $_POST['password'];

        $sql = "INSERT INTO \"USER\" (user_id, first_name, last_name, middle_name, contact_number, address, gender, email_address, password, user_role, status, birthdate) VALUES (user_seq.NEXTVAL, :first_name, :last_name, :middle_name, :contact_number, :address, :gender, :email_address, :password, :user_role, :status, TO_DATE(:birthdate, 'YYYY-MM-DD'))
            RETURNING user_id INTO :new_user_id";

        $data = [
          ':first_name' => $first_name,
          ':last_name' => $last_name,
          ':middle_name' => $middle_name,
          ':contact_number' => $contact_number,
          ':address' => $address,
          ':gender' => $gender,
          ':email_address' => $email_address,
          ':password' => $password,
          ':user_role' => 0,
          ':status' => 0,
          ':birthdate' => $birthdate
        ];

        $stid = $db->prepareStatement($sql);

        foreach ($data as $key => $val) {
          oci_bind_by_name($stid, $key, $data[$key]);
        }

        $new_user_id = 0;
        oci_bind_by_name($stid, ":new_user_id", $new_user_id, -1, OCI_B_INT);

        oci_execute($stid);

        $documents = [
          'profile_picture' => 'Profile Picture',
          'valid_id' => 'Valid ID',
          'drivers_license' => 'Driver\'s License',
          'proof_of_billing' => 'Proof of Billing',
          'selfie_with_id' => 'Selfie with ID'
        ];

        $allFilesProvided = true;
        foreach ($documents as $inputName => $docType) {
          if (!isset($_FILES[$inputName]) || $_FILES[$inputName]['error'] ==         UPLOAD_ERR_NO_FILE) {
            $allFilesProvided = false;
          }
        }
        if ($allFilesProvided) {
          foreach ($documents as $inputName => $documentName) {
            uploadSignupDocuments($_FILES[$inputName], $new_user_id, $inputName, $documentName, $db);
          }
        }
        oci_free_statement($stid);
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
   <title>Sign Up</title>
   <link rel="stylesheet" href="assets/styles/user/sign-layout.css">
   <link rel="stylesheet" href="assets/styles/user/signup.css">
   <link rel="stylesheet" href="assets/styles/component/button.css">
 </head>

 <body>
   <header>
     <a href="/drivesation">
       <img id="logo" src="assets/images/logo.png" alt="Drivesation Logo">
     </a>
   </header>

   <main>
     <div class="signup-container">
       <h1>Create an Account</h1>
       <form id="signup-form" method="POST" enctype="multipart/form-data">
         <div class="left-column">
           <div class="input-container">
             <input id="lastname" name="lastname" type="text" placeholder="Last Name" autocomplete="off">
             <span class="error-message" id="lastname-error"></span>
           </div>

           <div class="input-container">
             <input id="firstname" name="firstname" type="text" placeholder="First Name" autocomplete="off">
             <span class="error-message" id="firstname-error"></span>
           </div>

           <div class="input-container">
             <input id="middlename" name="middlename" type="text" placeholder="Middle Name" autocomplete="off">
             <span class="error-message" id="middlename-error"></span>
           </div>

           <div class="input-container">
             <input id="contact_number" name="contact_number" type="text" placeholder="Contact" autocomplete="off">
             <span class="error-message" id="contact_number-error"></span>
           </div>

           <div class="input-container">
             <input id="address" name="address" type="text" placeholder="Address" autocomplete="off">
             <span class="error-message" id="address-error"></span>
           </div>

           <div class="birthdate-container">
             <label for="birthdate">Birthdate</label>
             <div id="birthdate-input-container">
               <input id="birthdate" name="birthdate" type="date" autocomplete="off">
               <span class="error-message" id="birthdate-error"></span>
             </div>
           </div>

           <div class="gender-container">
             <div class="radio-container">
               <input type="radio" id="male" name="gender" value=0 checked>
               <label for="male">Male</label>
             </div>
             <div class="radio-container">
               <input type="radio" id="female" name="gender" value=1>
               <label for="female">Female</label>
             </div>
           </div>

           <label class="file-label" for="profile_picture" id="profile_picture_label">2 x 2 Picture
             <span id="profile_picture_name">No file chosen</span><img src="assets/images/add-image.png" alt="Add Image"></label>
           <label class="file-label" for="drivers_license" id="drivers_license_label">
             Driver's License
             <span id="drivers_license_name">No file chosen</span>
             <img src="assets/images/add-image.png" alt="Add Image">
           </label>
           <label class="file-label" for="valid_id" id="valid_id_label">
             Valid ID
             <span id="valid_id_name">No file chosen</span>
             <img src="assets/images/add-image.png" alt="Add Image">
           </label>
           <label class="file-label" for="proof_of_billing" id="proof_of_billing_label">
             Proof of Billing
             <span id="proof_of_billing_name">No file chosen</span>
             <img src="assets/images/add-image.png" alt="Add Image">
           </label>
           <label class="file-label" for="selfie_with_id" id="selfie_with_id_label">
             Selfie with ID
             <span id="selfie_with_id_name">No file chosen</span>
             <img src="assets/images/add-image.png" alt="Add Image">
           </label>

           <input type="file" name="profile_picture" id="profile_picture">
           <input type="file" name="valid_id" id="valid_id">
           <input type="file" name="drivers_license" id="drivers_license">
           <input type="file" name="proof_of_billing" id="proof_of_billing">
           <input type="file" name="selfie_with_id" id="selfie_with_id">
         </div>

         <div class="right-column">
           <div class="input-container">
             <input id="email_address" name="email_address" type="text" placeholder="Email" autocomplete="off">
             <span class="error-message" id="email_address-error"></span>
           </div>

           <div class="input-container">
             <input id="password" name="password" type="password" placeholder="Password" autocomplete="off">
             <span class="error-message" id="password-error"></span>
           </div>

           <div class="input-container">
             <input id="confirm-password" name="confirm-password" type="password" placeholder="Confirm Password" autocomplete="off">
             <span class="error-message" id="confirm-password-error"></span>
           </div>
           <button id="signup-btn" type="submit">SIGN UP</button>
           <a href="signin.php">Already have an account?</a>
       </form>
     </div>

   </main>
   <script src="assets/scripts/user/signup.js"></script>
   <script src="assets/scripts/modal/message-modal.js"></script>
 </body>

 </html>