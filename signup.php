 <?php 
  require_once "database/OracleDb.php";

  $db = new OracleDB();
  if (!$db->isConnected()) {
  die("Database connection failed");
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // if (isset(
    //     $_POST['firstname'],
    //     $_POST['lastname'],
    //     $_POST['middlename'],
    //     $_POST['email_address'],
    //     $_POST['address'],
    //     $_POST['contact_number'],
    //     $_POST['birthdate'],
    //     $_POST['gender'],
    //     $_POST['password']
    // )) {
    // } else {
    //     echo "<p>Missing required fields.</p>";
    // }

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

            $sql = "INSERT INTO \"USER\" (user_id, first_name, last_name, middle_name, contact_number, address, gender, email_address, password, user_role, status, document_id, birthdate) VALUES (user_seq.NEXTVAL, :first_name, :last_name, :middle_name, :contact_number, :address, :gender, :email_address, :password, :user_role, :status, :document_id, TO_DATE(:birthdate, 'YYYY-MM-DD'))";
            
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
                ':document_id' => 1,
                ':birthdate' => $birthdate
            ];  

            $stid = $db->executeQuery($sql, $data);
            foreach ($data as $key => $val) {
            oci_bind_by_name($stid, $key, $data[$key]);
        }
            oci_execute($stid);
            echo "<p>User details saved successfully!</p>";
        } catch (Exception $e) {
            echo "<p>Error: " . $e->getMessage() . "</p>";
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
 </head>

 <body>
   <header>
     <a href="/drivesation">
       <!-- <img id="logo" src="assets/images/logo.png" alt="Drivesation Logo"> -->
     </a>
   </header>

   <main>
     <form method="POST">
       <h1>Create an Account</h1>
       <input id="lastname" name="lastname" type="text" placeholder="Last Name">
       <input id="firstname" name="firstname" type="text" placeholder="First Name">
       <input id="middlename" name="middlename" type="text" placeholder="Middle Name">
       <input id="address" name="address" type="text" placeholder="Address">
       <input id="contact_number" name="contact_number" type="text" placeholder="Contact ">
       <input id="birthdate" name="birthdate" type="date" placeholder="Date of Birth">

       <input type="radio" id="male" name="gender" value=0>
       <label for="male">Male</label>
       <input type="radio" id="female" name="gender" value=1>
       <label for="female">Female</label>

       <input id="email_address" name="email_address" type="text" placeholder="Email">
       <input id="password" name="password" type="password" placeholder="Password">

       <button type="submit">Submit</button>
     </form>

   </main>
 </body>

 </html>