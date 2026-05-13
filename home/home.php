<?php

include '../controllers/product_ctrl.php';

//include db connection file
include '../database/db_connection.php';

$sql = "SELECT * FROM PRODUCTS";
$stmt = $conn->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/admin/style.css">
        <title>Home</title>

    </head>
    <body>

    <header>
        <div class="home_page">
            <label >
                <h3>Home</h3>
            </label>
        </div>

        <div class="notifications">
            <div class="circle"></div>
            <img src="/media/notification.png" class="icn" alt="notification alert" />
            <div class="dp">
                <img src="/media/profile.png" class="dpicn" alt="profile emoticon" />
            </div>
        </div>
    </header>

    <div class="main-container">
        <div class="navcontainer">

            <nav class="navigation_bar">
                <div class="nav-upper-options">

                    <div class="nav-option Home" onclick="location.href='/home/home.php'">
                        <img src="/media/home.png" class="report-img" alt="home" />
                        <h3>Home</h3>
                    </div>
                    <div class="nav-option Logout" onclick="location.href='/logn/login.php'">
                        <img src="/media/logout.png" class="report-img" alt="logout" />
                        <h3>Logout</h3>
                    </div>

                </div>
            </nav>

        </div>

        <div class="main">

            <?php
                foreach($rows as $row){
                    echo ProductCtrl::displayProduct($row);
                }
            ?>

        </div>

    </div>
    </body>
</html>
