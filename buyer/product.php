<?php
//start user session
session_start();

include '../controllers/buyer_controllers/productview_ctrl.php';
include '../controllers/buyer_controllers/bought_productview_ctrl.php';
include '../database/db_connection.php';

$product_id = "";

if ($_SERVER["REQUEST_METHOD"] == "GET"){
    $product_id = filter_var($_GET['product']);
}

$sql = "SELECT * FROM PRODUCTS WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$product_id]);
$row = $stmt->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/main.css" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link href="/stylesheet.css" rel="stylesheet" />
    <title>Product</title>

</head>
<body style="height: 100vh;">

    <header class="header p-3 bg-primary text-white"
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/buyer/product.php?product=<?php echo $product_id ?>" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    Product
                </a>
            </div>
        </div>
    </header>

    <main class="h-100 d-flex flex-nowrap flex-fill">
        <div class="h-100 d-flex flex-column flex-shrink-0 p-3 text-bg-secondary" style="width: auto;">
            <a href="/buyer/home.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <img width="40px" src="/media/logo.png" alt="logo" />
                <span class="fs-4 text-black">Bazaar Inc.</span>
            </a>
            <ul class="nav nav-pills flex-column mb-auto">

                <li class="nav-item my-2">
                    <a href="/buyer/home.php" class="nav-link active" aria-current="page">
                        <img width="20px" src="/media/home.png" class="report-img text-black" alt="home"/>
                        Home
                    </a>
                </li>
                <li class="nav-item my-2">
                    <a href="/buyer/bought.php" class="nav-link active" aria-current="page">
                        <img width="20px" src="/media/bought.png" class="report-img" alt="Bought items"/>
                        Bought
                    </a>
                </li>
                <li class="nav-item my-2">
                    <a href="/buyer/become_seller.php" class="nav-link active" aria-current="page">
                        <img width="20px" src="/media/seller.png" class="report-img" alt="become seller"/>
                        Become Seller
                    </a>
                </li>
                <li class="nav-item my-2">
                    <a href="/buyer/profile.php" class="nav-link active" aria-current="page">
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
                $sql = "SELECT status FROM PRODUCTS WHERE product_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$product_id]);
                $row_product_status = $stmt->fetch();

                if($row_product_status['status'] == 0){
                    echo BoughtViewCtrl::displayDetailedProductView($conn, $row);

                }else {
                    echo ViewCtrl::displayDetailedProductView($conn, $row);
                }

                ?>

            </div>
        </div>

    </main>
</body>
</html>
