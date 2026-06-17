<?php
//start user session
session_start();
include '../controllers/seller_controllers/listings_ctrl.php';

//include db connection file
include '../database/db_connection.php';
$user_id = $_SESSION['user_id'];

//get all of users listed products
$sql = "SELECT * FROM PRODUCTS WHERE seller_user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->execute([$user_id]);
$rows = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/main.css" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
        <script defer src="/navbar_small.js"></script>
    <link href="/stylesheet.css" rel="stylesheet" />
    <title>Listings</title>

</head>
<body style="height: 100vh;">

<header class="header p-3 bg-primary text-white">

    <div class="container">
        <div lass="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/seller/home.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                My Listings
            </a>
        </div>
    </div>
</header>

<main class="h-100 d-flex flex-nowrap flex-fill">
    <div class="h-100 d-flex flex-column flex-shrink-0 p-3 text-bg-secondary" style="width: auto;">
        <a href="/seller/user_listings.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <img width="40px" src="/media/logo.png" alt="logo" />
            <span class="fs-4 text-black">Bazaar Inc.</span>
        </a>
        <ul class="nav nav-pills flex-column mb-auto">

            <li class="nav-item my-2">
                <a href="/seller/home.php" class="nav-link active" aria-current="page">
                    <img width="20px" src="/media/home.png" class="report-img text-black" alt="home"/>
                    Home
                </a>
            </li>
            <li class="nav-item my-2">
                <a href="/seller/bought.php" class="nav-link active" aria-current="page">
                    <img width="20px" src="/media/bought.png" class="report-img" alt="Bought items"/>
                    Bought
                </a>
            </li>
            <li class="nav-item my-2">
                <a href="/seller/sold.php" class="nav-link active" aria-current="page">
                    <img width="20px" src="/media/sold.png" class="report-img" alt="Sold items"/>
                    Sold
                </a>
            </li>
            <li class="nav-item my-2">
                <a href="/seller/user_listings.php" class="nav-link active" aria-current="page">
                    <img width="20px" src="/media/collection.png" class="report-img" alt="My Listings"/>
                    My Listings
                </a>
            </li>
            <li class="nav-item my-2">
                <a href="/seller/listing.php" class="nav-link active" aria-current="page">
                    <img width="20px" src="/media/list.png" class="report-img" alt="List Product"/>
                    List
                </a>
            </li>
            <li class="nav-item my-2">
                <a href="/seller/profile.php" class="nav-link active" aria-current="page">
                    <img width="20px" src="/media/profile.png" class="report-img" alt="edit profile"/>
                    Profile
                </a>
            </li>
            <li class="nav-item my-2">
                <a href="/logout/logout.php" class="nav-link active" aria-current="page">
                    <img width="20px" src="/media/logout.png" class="report-img" alt="home"/>
                    Logout
                </a>
            </li>

        </ul>
    </div>

    <div class="container-lg my-1">
        <div class="row">

            <?php
            echo '<div>';

            $count = 0;
            foreach($rows as $row){

                if ($count % 3 == 0) {
                    echo '</div><div class="row">';
                }
                $count++;

                echo ListingsCtrl::displayListings($conn, $row);
            }
            echo '</div>';

            ?>

        </div>
    </div>
</main>
</body>
</html>
