<?php
//start user session
session_start();

include '../controllers/admin_controllers/adminreport_ctrl.php';
//include db connection file
include '../database/db_connection.php';

//get only the top 5 unresolved reports
$sql = "SELECT * FROM REPORTS WHERE completed_at IS NULL ORDER BY reported_at DESC LIMIT 5";
$stmt = $conn->prepare($sql);
$stmt->execute();
$unresolved_rows = $stmt->fetchAll();

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
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/main.css" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link href="/stylesheet.css" rel="stylesheet" />

</head>

<body style="height: 100vh;">

<header class="header p-3 bg-primary text-white">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/admin/admin_home.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                Admin Home
            </a>
        </div>
    </div>
</header>

<main class="h-100 d-flex flex">
    <div class="h-100 d-flex flex-column flex-shrink-0 p-3 text-bg-secondary" style="width: fit-content">
        <a href="/admin/admin_home.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <img width="40px" src="/media/logo.png" alt="logo" />
            <span class="fs-4 text-black">Admin Center</span>
        </a>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="/admin/admin_home.php" class="nav-link active" aria-current="page">
                    <img width="20px" src="/media/home.png" class="report-img text-black" alt="home"/>
                    Home
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/admin_reports.php" class="nav-link active" aria-current="page">
                    <img width="20px" src="/media/reports.png" class="report-img" alt="reports"/>
                    Reports
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/admin_edit_users.php" class="nav-link active" aria-current="page">
                    <img width="20px" src="/media/users.png" class="report-img" alt="edit users"/>
                    Edit Users
                </a>
            </li>
            <li class="nav-item">
                <a href="/logout/logout.php" class="nav-link active" aria-current="page">
                    <img width="20px" src="/media/logout.png" class="report-img" alt="logout"/>
                    Logout
                </a>
            </li>

        </ul>
    </div>

    <div type="body" class="container-fluid p-4">
        <div class="row g-3" style="margin-top: 4px;">

            <div class="col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-number"><?= $sold_rows['COUNT(product_id)'] ?></div>
                    <div class="stat-label">Products Sold</div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-number"><?= $product_rows['COUNT(product_id)'] ?></div>
                    <div class="stat-label">Total Products</div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-number"><?= $user_rows['COUNT(user_id)'] ?></div>
                    <div class="stat-label">Total Users</div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-number"><?= $report_rows['COUNT(report_id)'] ?></div>
                    <div class="stat-label">Total Reports</div>
                </div>
            </div>


            <div class="report-header">
                <h1 class="Recent-Reports">Recent Reports</h1>
                <button type="button" class="btn bg-primary btn-lg rounded-pill text-light" onclick="location.href='/admin/admin_reports.php'">View All</button>
            </div>

            <table class="table" title="Recent Reports" style="margin-top: 20px;">
                <thead>
                <tr>
                    <th scope="col">Report ID</th>
                    <th scope="col">Reason</th>
                    <th scope="col">Report Date</th>
                    <th scope="col">Resolution</th>
                    <th scope="col">Status</th>
                </tr>
                <?php
                foreach($unresolved_rows as $row){
                    echo ReportCtrl::displayReport($row);
                }
                ?>

                </thead>
            </table>
        </div>
    </div>
</main>
</body>
</html>