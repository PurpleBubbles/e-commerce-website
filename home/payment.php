<?php
//start user session
session_start();

include '../controllers/payment_ctrl.php';
include '../database/db_connection.php';

$product_id = "";

if ($_SERVER["REQUEST_METHOD"] == "GET"){
    $product_id = filter_var($_GET['product']);
}

$sql = "SELECT * FROM PRODUCTS WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$product_id]);
$rows = $stmt->fetch();

?>

<!DOCTYPE html>
<HTML lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <link rel="stylesheet" href="/admin/style.css">
</head>
<body>
<header>
    <div class="payment_page">
        <label >
            <h3>Payment page</h3>
        </label>
    </div>
</header>
<main>
    <article class="cic-card" data-id="p1">

        <?php

            echo PaymentCtrl::displayPayment($rows);

        ?>

    </article>


</main>
</body>
</HTML>
