<?php

//include db connection file
include 'database/db_connection.php';

$product_id = 20;

$sql = "SELECT image_id FROM PRODUCT_IMAGES WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$product_id]);
$rows = $stmt-> fetchAll();

header("Content-Type: " . $file['mime_type']); // e.g., image/jpeg or application/pdf
header("Content-Disposition: attachment; filename=\"" . $file['file_name'] . "\"");
header("Content-Length: " . strlen($file['file_data']));

echo $file['file_data'];
exit;