<?php 
function uploadSignupDocuments($file, $userId, $documentType, $documentName, $db) {
    if (!file_exists("uploads/$userId")) {
        mkdir("uploads/$userId", 0777, true);  
      }
      
      $target_dir = "uploads/$userId/";
      $fileExtension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

      $dateTime = date('YmdHis');
      $document_name = $userId . "_" . $documentType . "-" . $dateTime . "." . $fileExtension;
      $target_file = $target_dir . $document_name;
     
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
       try {
        $sql = "INSERT INTO document (document_id, document_name, document_type, file_link, user_id) VALUES (document_seq.NEXTVAL, :document_name, :document_type, :file_link, :user_id)";
        $stid = $db->executeQuery($sql);
        oci_bind_by_name($stid, ":document_name", $document_name);
        oci_bind_by_name($stid, ":document_type", $documentType);
        oci_bind_by_name($stid, ":file_link", $target_file);
        oci_bind_by_name($stid, ":user_id", $userId);
        oci_execute($stid);
        echo "Uploaded and saved: $documentName<br>";
      } catch (Exception $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
      }
    } else {
        echo "Failed to upload $documentType<br>";
    }
}
?>