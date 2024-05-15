<?php
function uploadSignupDocuments($file, $userId, $documentType, $documentName, $db)
{
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
      $stid = $db->prepareStatement($sql);
      oci_bind_by_name($stid, ":document_name", $document_name);
      oci_bind_by_name($stid, ":document_type", $documentType);
      oci_bind_by_name($stid, ":file_link", $target_file);
      oci_bind_by_name($stid, ":user_id", $userId);
      oci_execute($stid);
    } catch (Exception $e) {
      json_encode(['error', $e->getMessage()]);
    }
  } else {
    json_encode(['error', "Failed to upload"]);
  }
}

function uploadCarDocuments($file, $carId, $documentType, $documentName, $db)
{
  if (!file_exists("../uploads/car/$carId")) {
    mkdir("../uploads/car/$carId", 0777, true);
  }

  $target_dir = "uploads/car/$carId/";
  $fileExtension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

  $dateTime = date('YmdHis');
  $document_name = $carId . "_" . $documentType . "-" . $dateTime . "." . $fileExtension;
  $target_file = $target_dir . $document_name;

  if (move_uploaded_file($file["tmp_name"], "../uploads/car/" . $carId . "/" . $document_name)) {
    try {
      $sql = "INSERT INTO document (document_id, document_name, document_type, file_link, car_id) VALUES (document_seq.NEXTVAL, :document_name, :document_type, :file_link, :car_id)";
      $stid = $db->prepareStatement($sql);
      oci_bind_by_name($stid, ":document_name", $document_name);
      oci_bind_by_name($stid, ":document_type", $documentType);
      oci_bind_by_name($stid, ":file_link", $target_file);
      oci_bind_by_name($stid, ":car_id", $carId);
      oci_execute($stid);
    } catch (Exception $e) {
      json_encode(['error', $e->getMessage()]);
    }
  } else {
    json_encode(['error', "Failed to upload"]);
  }
}

// function uploadUpdateCarDocuments($file, $carId, $documentType, $documentName, $db)
// {
//   // Ensure the upload directory exists
//   if (!file_exists("../uploads/car/$carId")) {
//     mkdir("../uploads/car/$carId", 0777, true);
//   }

//   // Define the target directory
//   $target_dir = "uploads/car/$carId/";
//   $fileExtension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

//   // Generate a unique document name
//   $dateTime = date('YmdHis');
//   $document_name = $carId . "_" . $documentType . "-" . $dateTime . "." . $fileExtension;
//   $target_file = $target_dir . $document_name;

//   // Attempt to move the uploaded file
//   if (move_uploaded_file($file["tmp_name"], "../" . $target_file)) {
//     try {
//       // Check if the document record already exists
//       $sqlCheck = "SELECT document_id FROM \"DOCUMENT\" WHERE car_id = :car_id AND document_type = :document_type";
//       $stidCheck = $db->prepareStatement($sqlCheck);
//       oci_bind_by_name($stidCheck, ":car_id", $carId);
//       oci_bind_by_name($stidCheck, ":document_type", $documentType);
//       oci_execute($stidCheck);
//       $row = $db->fetchAll($stidCheck);
//       return $row;
//       // If document exists, update it
//       if (!empty($row)) {
//         $sqlUpdate = "UPDATE \"DOCUMENT\" SET document_name = :document_name, file_link = :file_link WHERE document_id = :document_id";
//         $stid = $db->prepareStatement($sqlUpdate);
//         oci_bind_by_name($stid, ":document_name", $document_name);
//         oci_bind_by_name($stid, ":file_link", $target_file);
//         oci_bind_by_name($stid, ":document_id", $row['document_id']);
//       } else {
//         // Insert new document record
//         $sqlInsert = "INSERT INTO \"DOCUMENT\" (document_id, document_name, document_type, file_link, car_id) VALUES (document_seq.NEXTVAL, :document_name, :document_type, :file_link, :car_id)";
//         $stid = $db->prepareStatement($sqlInsert);
//         oci_bind_by_name($stid, ":document_name", $document_name);
//         oci_bind_by_name($stid, ":document_type", $documentType);
//         oci_bind_by_name($stid, ":file_link", $target_file);
//         oci_bind_by_name($stid, ":car_id", $carId);
//       }

//       // Execute the prepared statement
//       oci_execute($stid);
//     } catch (Exception $e) {
//       return json_encode(['error' => $e->getMessage()]);
//     }
//   } else {
//     return json_encode(['error' => "Failed to upload file"]);
//   }
// }

function updateCarDocuments($file, $carId, $documentType, $db)
{

  if (!file_exists("../uploads/car/$carId")) {
    mkdir("../uploads/car/$carId", 0777, true);
  }

  $target_dir = "uploads/car/$carId/";

  $fileExtension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
  $dateTime = date('YmdHis');
  $document_name = $carId . "_" . $documentType . "-" . $dateTime . "." . $fileExtension;
  $target_file = $target_dir . $document_name;

  // Retrieve the current document record to get the existing file path
  $sqlGetExisting = "SELECT file_link FROM document WHERE car_id = :car_id AND document_type = :document_type";
  $stid = $db->prepareStatement($sqlGetExisting);
  oci_bind_by_name($stid, ":car_id", $carId);
  oci_bind_by_name($stid, ":document_type", $documentType);
  oci_execute($stid);
  $existing = oci_fetch_array($stid, OCI_ASSOC);

  // If an existing file exists, delete it
  if ($existing && file_exists($existing['FILE_LINK'])) { // Adjust the path as needed
    if (!unlink($existing['FILE_LINK'])) { // Check if the file deletion was successful
      throw new Exception("Failed to delete old file.");
    }
  }

  // Attempt to move the uploaded file
  if (move_uploaded_file($file["tmp_name"], "../uploads/car/" . $carId . "/" . $document_name)) {
    // Update the document record, replacing the existing one
    if ($existing) {
      // Update the existing document record
      $sqlUpdate = "UPDATE \"DOCUMENT\" SET file_link = :file_link, document_name = :document_name WHERE car_id = :car_id AND document_type = :document_type";
    } else {
      // Insert a new document record
      $sqlUpdate = "INSERT INTO \"DOCUMENT\" (document_id, car_id, document_type, file_link, document_name) VALUES (document_seq.NEXTVAL, :car_id, :document_type, :file_link, :document_name)";
    }

    $params = [
      ':file_link' => $target_file,
      ':document_name' => $document_name,
      ':car_id' => $carId,
      ':document_type' => $documentType
    ];
    $db->executeQuery($sqlUpdate, $params);
  } else {
    throw new Exception("Failed to upload file: $documentType");
  }
}
