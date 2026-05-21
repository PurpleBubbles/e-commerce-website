<?php

//include db connection file
include 'database/db_connection.php';

$image_id = $_GET['image_id'];

$sql = "SELECT image_data, image_type FROM PRODUCT_IMAGES WHERE image_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$image_id]);
$rows = $stmt-> fetchAll();
$image = $rows[0];

if ($image['image_type'] == 'jpg' || $image['image_type'] == 'jpeg') {
    $content_type = 'image/jpeg';
} else {
    $content_type = 'image/png';
}


header("Content-Type: " . $content_type); // e.g., image/jpeg or image/png
// header("Content-Disposition: attachment; filename=\"" . $image['product_id'] . "." . $image['image_type'] . "\"");
header("Content-Length: " . strlen($image['image_data']));

echo $image['image_data'];