<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Info Form</title>
</head>
<body>
    <?php 
    require_once "database/OracleDb.php";

    $sql = "INSERT INTO document (document_id, document_name, document_type, file_name, file_link) VALUES (document_seq.NEXTVAL, :document_name, :document_type, :file_name, :file_link)";
    $db = new OracleDB();

    if (!$db->isConnected()) {
      die("Database connection failed");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset(
      $_POST['document_name'], $_POST['document_type'], $_POST['file_name'], $_POST['file_link'])) {
        $documentName = $_POST['document_name'];
        $documentType = $_POST['document_type'];
        $fileName = $_POST['file_name'];
        $fileLink = $_POST['file_link'];
        $data = [
        ':document_name' => $documentName,
        ':document_type' => $documentType,
        ':file_name' => $fileName,
        ':file_link' => $fileLink
        ];  

        $stid = $db->executeQuery($sql, $data);
        foreach ($data as $key => $val) {
            oci_bind_by_name($stid, $key, $data[$key]);
        }

        if (!oci_execute($stid)) {
        $e = oci_error($stid);
        throw new Exception("Error executing statement: " . $e['message']);
        }
         echo "<p>Document details saved successfully!</p>";
        }
    ?>
    
    <h1>User Information</h1>
    <form method="POST">
        <label for="document_name">Document Name:</label>
        <input type="text" id="document_name" name="document_name" required>

        <label for="document_type">Document Type:</label>
        <input type="text" id="document_type" name="document_type" required>
        <label for="file_name">File Name</label>
        <input type="text" id="file_name" name="file_name" required>
        <label for="file_link">File Link</label>
        <input type="text" id="file_link" name="file_link" required>

        <button type="submit">Submit</button>
    </form>



</body>
</html>
