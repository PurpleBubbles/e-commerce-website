<?php
//start user session
session_start();

class ValidationException extends Exception {}

include '../controllers/seller_controllers/productreport_ctrl.php';
//include db connection file
include '../database/db_connection.php';

$product_id = "";
$report_reason="";
$error_message_popup = "";

//get product key from get request otherwise page does not work
if (array_key_exists('product', $_GET)) {
    $product_id = filter_var($_GET['product']);
} else {
    header("HTTP/1.1 401 Unauthorized");
    exit;
}

$sql = "SELECT * FROM PRODUCTS WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$product_id]);
$row = $stmt->fetch();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $report_reason = htmlspecialchars($_POST['report']);

    try {

        $sql = "INSERT INTO REPORTS (report_reason, product_id) VALUES (?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$report_reason, $product_id]);

        // Redirect to buyer page
        header('Location: /seller/home.php');
        exit; // Ensure code stops executing after redirect
        header("Location: target-file.php");
        exit;

    }catch (ValidationException $e){
        $error_message_popup = $e->getMessage();
    }
}

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporting</title>
    <link rel="stylesheet" href="../admin/style.css">
</head>
<body>
<header>
    <div class="report_page">
        <label >
            <h3>Report Product</h3>
        </label>
    </div>

</header>

<div class="main-container">
    <div class="navcontainer">

        <nav class="navigation_bar">
            <div class="nav-upper-options">

                <div class="nav-option Home" onclick="location.href='/seller/home.php'">
                    <img src="/media/home.png" class="report-img" alt="home" />
                    <h3>Home</h3>
                </div>
                <div class="nav-option Logout" onclick="location.href='/logout/logout.php'">
                    <img src="/media/logout.png" class="report-img" alt="logout" />
                    <h3>Logout</h3>
                </div>

            </div>
        </nav>

    </div>

    <div class="main">

        <?php

            echo ProductReportCtrl::displayReportedProduct($row);

        ?>

    </div>

</div>

</body>