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

$sql = "SELECT image_id FROM PRODUCT_IMAGES WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$product_id]);
$row_image = $stmt->fetch();

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
    <link href="/main.css" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <title>Reporting</title>

</head>
<body style="height: 100vh;">
    <header class="header p-3 bg-primary text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/seller/report.php?product=<?php echo $product_id?>" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    Report Product
                </a>
                </d>
            </div>
    </header>

    <main class="h-100 d-flex flex-nowrap flex-fill">
        <div class="h-100 d-flex flex-column flex-shrink-0 p-3 text-bg-secondary" style="width: auto;">
            <a href="/seller/home.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <img width="40px" src="/media/logo.png" alt="logo" />
                <span class="fs-4 text-black">Product Name</span>
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
                    <a href="/seller/listing.php" class="nav-link active" aria-current="page">
                        <img width="20px" src="/media/list.png" class="report-img" alt="List Product"/>
                        List
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

                echo ProductReportCtrl::displayReportedProduct($row, $row_image);

                ?>
            </div>

            <form action="report.php?product=<?php echo $product_id?>" method="POST">
                <div class="row d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <textarea style="width: auto" name="report" id="report" required placeholder="Report reason"></textarea>
                    <button style="width: fit-content" type="submit" class="btn btn-primary btn-lg m-1">Report</button>
                </div>
            </form>

        </div>
    </main>

    <?php
    if ($error_message_popup != ""){
        ?>

        <script>
            alert("<?php echo $error_message_popup;?>");
        </script>

        <?php
    }
    ?>



</body>
</html>