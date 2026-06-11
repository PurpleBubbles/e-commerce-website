<?php

//include db connection file
include 'database/db_connection.php';

$image_id = $_GET['image_id'];

if ($image_id == "none") {
    $file = './media/image-break.png';
    $mime = mime_content_type($file);
    header("Content-Type: $mime");
    readfile($file);
    exit();
}

$sql = "SELECT image_data, image_type FROM PRODUCT_IMAGES WHERE image_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$image_id]);
$rows = $stmt-> fetchAll();
$image = $rows[0];
$content_type = $image['image_type'];

header("Content-Type: " . $content_type); // e.g., image/jpeg or image/png
// header("Content-Disposition: attachment; filename=\"" . $image['product_id'] . "." . $image['image_type'] . "\"");
header("Content-Length: " . strlen($image['image_data']));

echo $image['image_data'];