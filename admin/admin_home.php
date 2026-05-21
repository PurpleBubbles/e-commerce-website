<?php
//start user session
session_start();

include '../controllers/admin_controllers/adminreport_ctrl.php';
//include db connection file
include '../database/db_connection.php';

//get all reports
$sql = "SELECT * FROM REPORTS";
$stmt = $conn->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll();

//get number of sold products
$sql = "SELECT COUNT(product_id) FROM PRODUCTS WHERE status = 0";
$stmt = $conn->prepare($sql);
$stmt->execute();
$sold_rows = $stmt->fetch();

//get number of products
$sql = "SELECT COUNT(product_id) FROM PRODUCTS";
$stmt = $conn->prepare($sql);
$stmt->execute();
$product_rows = $stmt->fetch();

//get number of users
$sql = "SELECT COUNT(user_id) FROM USERS";
$stmt = $conn->prepare($sql);
$stmt->execute();
$user_rows = $stmt->fetch();

//get number of reports
$sql = "SELECT COUNT(report_id) FROM REPORTS";
$stmt = $conn->prepare($sql);
$stmt->execute();
$report_rows = $stmt->fetch();

?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Page</title>
    <link href="/main.css" rel="stylesheet" />

<!--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">-->
<!---->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>

<body style="height: 100vh;">

<header class="p-3 bg-primary text-white">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/admin/admin_home.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                Admin Center
            </a>
        </div>
    </div>
</header>

<main class="h-100 d-flex flex-nowrap">
    <div class="h-100 d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px;">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <img width="20px" src="/media/logo.png" alt="logo" />
            <span class="fs-4">Admin Center</span>
        </a>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="/admin/admin_home.php" class="nav-link active" aria-current="page">
                    <img width="20px" src="/media/home.png" class="report-img" alt="home"/>
                    Home
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/admin_reports.php" class="nav-link active" aria-current="page">
                    <img width="20px" src="/media/reports.png" class="report-img" alt="home"/>
                    Reports
                </a>
            </li>
            <li class="nav-item">
                <a href="/logout/logout.php" class="nav-link active" aria-current="page">
                    <img width="20px" src="/media/logout.png" class="report-img" alt="home"/>
                    Logout
                </a>
            </li>

        </ul>
    </div>

    <div type="body" class="container-fluid">
        <div class="row align-items-start" style="margin-top: 20px;">
            <div class="card col text-center text-light bg-secondary shadow-lg" style="width: 18rem;">
                <div class="card-body">
                    <p class="topic-heading">
                        <?php
                        echo $sold_rows['COUNT(product_id)'];
                        ?>
                    </p>
                    <p class="topic"># Products Sold</p>
                </div>
            </div>

            <div class="card col text-center text-light bg-secondary" style="width: 18rem;">
                <div class="card-body">
                    <p class="topic-heading">
                        <?php
                        echo $product_rows['COUNT(product_id)'];
                        ?>
                    </p>
                    <p class="topic"># Products</p>
                </div>
            </div>

            <div class="card col text-center text-light bg-secondary" style="width: 18rem;">
                <div class="card-body">
                    <p class="topic-heading">
                        <?php
                        echo $user_rows['COUNT(user_id)'];
                        ?>
                    </p>
                    <p class="topic"># Users</p>
                </div>
            </div>

            <div class="card col text-center text-light bg-secondary" style="width: 18rem;">
                <div class="card-body">
                    <p class="topic-heading">
                        <?php
                        echo $report_rows['COUNT(report_id)'];
                        ?>
                    </p>
                    <p class="topic"># Reports</p>
                </div>
            </div>

        <div class="box Reports">
            <div class="text">
                <p class="topic-heading">
                    <?php
                    echo $report_rows['COUNT(report_id)'];
                    ?>
                </p>
                <p class="topic">Number of Reports</p>
            </div>
        </div>
    </div>

    </div>
</main>




            <div class="box Reports">
                <div class="text">
                    <h2 class="topic-heading">
                        <?php
                            echo $report_rows['COUNT(report_id)'];
                        ?>
                    </h2>
                    <h2 class="topic">Number of Reports</h2>
                </div>
            </div>
        </div>

        <div class="report-container">
            <div class="report-header">
                <h1 class="Recent-Reports">Recent Reports</h1>
                <button class="view" onclick="location.href='/admin/admin_reports.php'">View All</button>
            </div>

            <div class="report-body">
                <div class="report-headings">
                    <h3 class="t-op">Report ID</h3>
                    <h3 class="t-op">Reason</h3>
                    <h3 class="t-op">Report Date</h3>
                    <h3 class="t-op">Resolution</h3>
                    <h3 class="t-op">Status</h3>
                </div>

                <div class="reports">

                    <?php
                    foreach($rows as $row){
                        echo ReportCtrl::displayReport($row);
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
    </body>

</html>