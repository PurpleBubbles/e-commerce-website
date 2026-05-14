<?php
//start user session
session_start();
include '../controllers/bought_ctrl.php';

//include db connection file
include '../database/db_connection.php';
$user_id = "";

$sql = "SELECT * FROM BOUGHT where buyer_user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute(['$user_id']);
$rows = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/admin/style.css">
        <title>Bought</title>

    </head>
    <body>

    <header>
        <div class="home_page">
            <label >
                <h3>Bought Products</h3>
            </label>
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
                    <div class="nav-option Bought" onclick="location.href='/home/bought.php'">
                        <img src="/media/bought.png" class="report-img" alt="bought" />
                        <h3>Bought</h3>
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
                    //check if product has been sold prior to displaying
                    if($row['status'] !== 0){
                        echo BoughtCtrl::displayBoughtProducts($row);
                    }
                }
            ?>

        </div>

    </div>
    </body>
</html>
