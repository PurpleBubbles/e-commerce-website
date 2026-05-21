<?php
//start user session
session_start();
include '../controllers/seller_controllers/sold_ctrl.php';

//include db connection file
include '../database/db_connection.php';
$user_id = $_SESSION['user_id'];

//get all sold items of user in session
$sql = "SELECT * FROM PRODUCTS WHERE seller_user_id = ? AND status = 0;";

$stmt = $conn->prepare($sql);
$stmt->execute([$user_id]);
$rows = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css">
    <title>Sold</title>

</head>
<body>

<header>
    <div class="listing_page">
        <label >
            <h3>Sold Products</h3>
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
                <div class="nav-option Bought" onclick="location.href='/seller/bought.php'">
                    <img src="/media/bought.png" class="report-img" alt="bought" />
                    <h3>Bought</h3>
                </div>
                <div class="nav-option Sold" onclick="location.href='/seller/sold.php'">
                    <img src="/media/sold.png" class="report-img" alt="sold" />
                    <h3>Sold</h3>
                </div>
                <div class="nav-option List" onclick="location.href='/seller/listing.php'">
                    <img src="/media/list.png" class="report-img" alt="list new product" />
                    <h3>List</h3>
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

        foreach($rows as $row){
            echo SoldCtrl::displaySoldProducts($conn, $row);
        }

        ?>

    </div>

</div>
</body>
</html>
